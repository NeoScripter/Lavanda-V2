<?php

use Http\Models\Image;
use Support\ImageHandler;

define('VITE_DEV_SERVER', 'http://localhost:5173');

function vite_is_dev(): bool
{
    $handle = @fsockopen('localhost', 5173, timeout: 1);
    if (!$handle) return false;
    fclose($handle);
    return true;
}

function vite_tags(string $entry = ''): string
{
    $manifestPath = APP_DIR . '/public/dist/.vite/manifest.json';
    if (!file_exists($manifestPath)) {
        $manifestPath = APP_DIR . '/public/dist/manifest.json';
    }

    if (!file_exists($manifestPath)) {
        throw new RuntimeException('Vite manifest not found. Run `vite build`.');
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);

    if (!isset($manifest[$entry])) {
        throw new RuntimeException("Entry '{$entry}' not found in Vite manifest.");
    }

    $chunk = $manifest[$entry];
    $tags = [];

    $tags[] = "<script type='module' src='/admin/dist/{$chunk['file']}'></script>";

    foreach ($chunk['css'] ?? [] as $css) {
        $tags[] = "<link rel='stylesheet' href='/admin/dist/{$css}'>";
    }

    foreach ($chunk['imports'] ?? [] as $importKey) {
        foreach ($manifest[$importKey]['css'] ?? [] as $css) {
            $tags[] = "<link rel='stylesheet' href='/admin/dist/{$css}'>";
        }
    }

    return implode(PHP_EOL, $tags) . PHP_EOL;
}

function build_src_set(string $path, string $size, string $ext): string
{
    $sources = [
        ["{$path}-{$size}.{$ext}",     '1x'],
        ["{$path}-{$size}2x.{$ext}",   '2x'],
        ["{$path}-{$size}3x.{$ext}",   '3x'],
    ];

    return implode(
        ', ',
        array_map(
            fn($s) => "{$s[0]} {$s[1]}",
            array_filter($sources, fn($s) => !empty($s[0]))
        )
    );
}

function send_json(array $data, int $status = 200): void
{
    header('Content-Type: application/json');

    http_response_code($status);

    echo json_encode($data);

    exit;
}

function get_json()
{
    $raw = Base::instance()->get('BODY');

    if (!$raw) return [];

    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        send_json(['error' => 'Invalid JSON'], 400);
    }

    return $data;
}


function component(string $path, array $props = []): string
{
    return View::instance()->render("/components/{$path}.php", "text/html", $props);
}

function slot(string $path, array $props = []): void
{
    \Base::instance()->push(
        'SLOTS',
        ['path' => $path, 'props' => $props]
    );
    ob_start();
}

function end_slot(): void
{
    $current = \Base::instance()->pop('SLOTS');
    $content = trim(ob_get_clean());

    echo View::instance()->render(
        "/{$current['path']}.php",
        "text/html",
        array_merge($current['props'], ['slot' => $content])
    );
}

function view(string $name, array $props = []): void
{
    echo View::instance()->render("{$name}.php", "text/html", $props);
}

function serialize_attrs(array|null $attrs)
{
    $attr_string = '';

    foreach ($attrs as $key => $val) {
        if ($val === true) {
            $attr_string .= " $key";
        } elseif ($val !== false && $val !== null) {
            $attr_string .= " $key=\"$val\"";
        }
    }

    return $attr_string;
}

function svg(string $name)
{
    if (str_ends_with($name, '.svg')) {
        $name = trim($name, '.svg');
    }
    $path = APP_DIR . "/public/assets/svgs/{$name}.svg";

    if (file_exists($path)) {
        include($path);
    } else {
        return '';
    };
}


function set_values(array $values)
{
    $flash = \Flash::instance();

    foreach ($values as $key => $val) {
        $flash->setKey("values.{$key}", $val);
    }
};

function set_errors(array $errors)
{
    $flash = \Flash::instance();

    foreach ($errors as $key => $val) {
        $flash->setKey("errors.{$key}", $val);
    }
};

function notify(string $notification)
{
    \Flash::instance()->addMessage($notification);
}

function csrf()
{
    $token = \Base::instance()->get('CSRF');
    return "<input type='hidden' name='token' value='{$token}'>";
}

function check_csrf(array $data)
{
    $csrf = \Base::instance()->get('CSRF');
    $token = $data['token'] ?? null;

    if (empty($token) || empty($csrf) || $token !== $csrf) {
        throw new Exception('No csrf token found');
    }
}

function page_url(int $page): string
{
    $params = \Base::instance()->GET;
    $params['page'] = $page;
    return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($params);
}

function shorten_line(?string $line, ?int $limit = 50): string
{
    if (empty($line)) {
        return '';
    }
    return strlen($line) > $limit ? substr($line, 0, $limit) . '...' : $line;
}


function cli_color(string $message, string $status = 'success'): string
{
    $color = match ($status) {
        'success' => '32',
        'error'   => '31',
        'warning' => '33',
        'info'    => '34',
        default   => '0'
    };

    return "\033[{$color}m{$message}\033[0m";
}

function cli_echo(string $message, string $status = 'success'): void
{
    echo cli_color($message . "\n", $status);
}

function get_latest_id(string $table): int
{
    $res = Base::instance()->get('DB')->exec("SELECT MAX(id) AS max_id FROM {$table}");
    return $res[0]['max_id'] ?? 1;
}

function dd(...$vars)
{
    foreach ($vars as $v) {
        echo "<pre>";
        var_dump($v);
        echo "</pre>";
    }
    die(1);
}

function add_markdown_field(array &$data, string $from, string $to)
{
    if (! isset($data[$from]) || ! is_string($data[$from])) {
        return;
    }

    $data[$to] = \Markdown::instance()->convert($data[$from]);
}


function get_db_table_names()
{
    $files = glob(APP_DIR . '/db/migrations/*');
    sort($files);

    return array_filter(
        array_map(
            function ($file) {
                $filename = basename($file);

                if (preg_match('/create_([a-z_]+)_table/', $filename, $matches)) {
                    return $matches[1];
                }

                return '';
            },
            $files
        ),
        'strlen'
    );
}


function delete_files_recursive(array $files)
{
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        } else if (is_dir($file)) {
            delete_files_recursive(glob($file . '/*'));
            rmdir($file);
        }
    }
}

function is_image_attached(int $parent_id, string $parent_type, ?string $where = ''): bool
{
    $where = $where ? "AND $where " : '';

    $rows = Base::instance()->get('DB')->exec(
        "SELECT * FROM images WHERE imageable_id = ? AND imageable_type = ? {$where}LIMIT 1",
        [$parent_id, $parent_type]
    );

    if (empty($rows)) {
        return false;
    }

    return true;
}

function image_variants(array $sizes): array
{
    $sizes = array_map(
        fn($size) => count($size) > 1 ? $size : [$size[0], 0],
        $sizes
    );
    $variants = [];
    $formats  = ['webp', 'avif'];
    $scales   = [1, 2, 3];

    foreach ($sizes as $idx => [$name, $width]) {
        foreach ($formats as $format) {
            foreach ($scales as $scale) {
                $suffix     = $scale > 1 ? "_{$scale}x" : '';
                $variants[] = ["{$name}_{$format}{$suffix}", $width * $scale, $format];
            }
        }

        $variants[] = ["{$name}_tiny", 10 * ($idx + 2), 'webp'];
    }

    return $variants;
}


function normalize_image_input(array $input)
{
    $data = [];
    foreach ($input as $key => $value) {
        if (! is_array($value)) {
            $data[$key] = [$value];
        } else {
            $data[$key] = $value;
        }
    }

    return $data;
}


function purge_files(string $src): void
{
    $dir = dirname(str_replace(\Base::instance()->get('app_url'), WEBROOT, $src));

    if (is_dir($dir)) {
        $files = glob($dir . '/*');

        if (!empty($files)) {
            delete_files_recursive($files);
        }
        rmdir($dir);
    }
}

function purge_file(string $src): void
{
    $src = str_replace(\Base::instance()->get('app_url'), WEBROOT, $src);
    if (file_exists($src)) {
        unlink($src);
    }

    $dir = get_parent_dir($src);
    if (is_dir($dir) && count(scandir($dir)) === 2) {
        rmdir($dir);
    }
}

function optimize_files(array $files, array $sizes, ?int $qnt = null): array
{
    if (empty($files) || empty($sizes)) {
        throw new Exception('Files are empty');
    }

    if (is_int($qnt)) {
        $files = array_slice($files, 0, $qnt);
    }

    $records = ImageHandler::make()
        ->process(files: $files, sizes: $sizes);

    if (empty($records)) {
        throw new Exception('No images were generated');
    }

    return $records;
}

function set_morph($self, $value)
{
    $current = array_map(fn($img) => $img->id, $self->gallery ?? []) ?? [];

    if (is_null($value) || empty($value)) {
        return $current ?? [];
    }

    if (is_array($value)) {
        $ids = is_int($value[0]) ? $value : array_map(fn($img) => $img->id, $value);
        return [...$current, ...$ids];
    }

    if (is_int($value)) {
        return [...$current, $value];
    }

    if (!empty($value->id)) {
        return [...$current, $value->id];
    }

    return $current;
}

function get_morph_many($self, $ids, $relation)
{
    if (empty($ids) || ! is_array($ids)) {
        return [];
    }

    $imgs = new Image();
    $imgs = $imgs->find(['id IN ?', $ids]);
    $db_table = $self->getTable();
    $hive = \Base::instance();

    if (empty($imgs)) {
        $hive->DB->exec("UPDATE $db_table SET $relation = NULL WHERE id = ?", [$self->id]);
        return [];
    }

    $new_ids = [];
    foreach ($imgs as $img) {
        $new_ids[] = $img->id;
    }

    if (count($ids) !== count($new_ids)) {
        $hive->DB->exec("UPDATE $db_table SET $relation = ? WHERE id = ?", [json_encode($new_ids), $self->id]);
    }

    return [...$imgs];
}

function get_morph_one($self, $id, $relation)
{
    if (! $id) {
        return null;
    }

    $img = new Image();
    $img->load(['id = ?', $id]);

    if ($img->dry()) {
        $db_table = $self->getTable();
        \Base::instance()->DB->exec("UPDATE $db_table SET $relation = NULL WHERE id = ?", [$self->id]);
        return null;
    }

    return $img;
}

function convert_to_plural($word)
{
    $word = strtolower($word);

    // Already plural
    if (str_ends_with($word, 's')) {
        return $word;
    }

    // Consonant + Y → change to IES
    if (preg_match('/[^aeiou]y$/', $word)) {
        return substr($word, 0, -1) . 'ies';
    }

    // Vowel + Y or anything else → just add S
    return $word . 's';
}

function convert_to_snake_case($word)
{
    return strtolower(preg_replace('/(?<!^)(?=[A-Z])/', '_', $word));
}

function convert_to_kebab_case($word)
{
    return strtolower(preg_replace('/(?<!^)(?=[A-Z])/', '-', $word));
}

function to_wildcards(array $arr, ?string $placeholder = '?')
{
    return implode(
        ',',
        array_fill(0, count($arr), $placeholder)
    );
}

function component_props(array $required, array $optional, array $props)
{
    $missing = array_diff($required, array_keys($props));

    if (!empty($missing)) {
        throw new \InvalidArgumentException(
            sprintf('Missing the following component props: [%s]',  implode(', ', $missing))
        );
    }

    return array_merge($optional, $props);
}

function remove_file_extention(string $path)
{
    return preg_replace('/\.[^.]+$/', '', $path);
}

function remove_extra_slashes(string $path)
{
    return preg_replace('#(?<!:)//+#', '/', $path);
}

function to_public_url(string $path)
{
    $path_stem = remove_file_extention($path);

    $app_url = rtrim(\Base::instance()->get('app_url'), '/') . '/';

    $norm_path = str_replace(WEBROOT, $app_url, $path_stem);

    return remove_extra_slashes($norm_path);
}

function get_parent_dir(string $path)
{
    return substr($path, 0, strrpos($path, '/'));
}

function read_dir_files(string $path)
{
    $all = scandir($path);

    $files = [];
    foreach ($all as $candidate) {
        if (! is_dir($candidate)) {
            $files[] = $candidate;
        }
    }

    return $files;
}

function get_flat_routes()
{
    $routes = [];
    $raw = \Base::instance()->get('ROUTES');

    foreach ($raw as $url => $methods) {
        foreach ($methods as $route) {
            foreach ($route as $method => $_) {
                $routes[] = [
                    'url' => $url,
                    'method' => $method
                ];
            }
        }
    }

    return $routes;
}
