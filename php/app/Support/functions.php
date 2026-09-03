<?php

use DB\Cortex;
use Enums\Locale;
use Enums\ThemeableType;
use Http\Models\Image;
use Jobs\ProcessImageJob;

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

function dd(mixed ...$vars)
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

function convert_to_plural(string $word)
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

function convert_to_snake_case(string $word)
{
    return strtolower(preg_replace('/(?<!^)(?=[A-Z])/', '_', $word));
}

function convert_to_kebab_case(string $word)
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

function extract_file_name(string $path)
{
    return substr($path, strrpos($path, '/') + 1);
}

function read_or_throw(string $path, string $message): string
{
    $content = file_get_contents($path);

    if ($content === false) {
        throw new InvalidArgumentException($message);
    }

    return $content;
}

function to_public_url(string $path)
{
    $app_url = rtrim(\Base::instance()->get('app_url'), '/') . '/';

    $norm_path = str_replace(WEBROOT, $app_url, $path);

    return remove_extra_slashes($norm_path);
}

function to_absolute_path(string $path)
{
    $app_url = rtrim(\Base::instance()->get('app_url'), '/') . '/';

    $norm_path = str_replace($app_url, WEBROOT, $path);

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

function read_existing_variant_sizes(string $path)
{
    $current_path = remove_extra_slashes(
        str_replace(
            \Base::instance()->get('app_url'),
            WEBROOT . '/',
            $path
        )
    );
    $parent_dir = get_parent_dir($current_path);
    $files = read_dir_files($parent_dir);

    $target_sizes = ['-mb.webp' => 'mb', '-tb.webp' => 'tb', '-dk.webp' => 'dk'];
    $sizes = [];

    foreach ($target_sizes as $suffix => $ext) {
        $matched_file = array_find(
            $files,
            fn($file) => str_contains($file, $suffix)
        );

        if ($matched_file) {
            [$width,] = getimagesize($parent_dir . '/' . $matched_file);
            $sizes[$ext] = $width;
        }
    }

    return $sizes;
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

function set_no_image_placeholder()
{
    $fallback = APP_DIR . "/db/Fixtures/Image/no-image/";

    $subdir = \UPLOAD_DIR . '/' . uniqid() . '/';

    $files = array_filter(scandir($fallback), fn($file) => is_file($fallback . $file));

    if (!is_dir($subdir)) {
        mkdir($subdir, 0777, true);
    }

    foreach ($files as $file) {
        copy($fallback . $file, $subdir . $file);
    }

    return to_public_url($subdir . 'no-image');
}

function attach_image_to_model(Cortex $model, string $imageable_type, string $variant, array $file, array $sizes): void
{
    $image = $model->{$variant} ?? new Image();

    if (empty($image->src)) {
        $image->copyfrom([
            'src' => set_no_image_placeholder(),
            'variant' => $variant,
            'imageable_id' => $model->id,
            'imageable_type' => $imageable_type,
            'alt' => $file['alt'] ?? ''
        ]);
        $image->save();
    }

    notify(\Base::instance()->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files'));

    ProcessImageJob::dispatch([
        'image_id' => $image->id,
        'sizes' => $sizes,
        'file' => $file['src']
    ]);
}

function get_unique_themes_by_type(ThemeableType $themeable_type, string|int $themeable_id)
{
    $db = \Base::instance()->get('DB');

    $themes = $db->exec(
        "SELECT
            t1.name,
            MAX(CASE WHEN t1.themeable_id = ? THEN t1.themeable_id ELSE NULL END) AS model_id,
            MAX(CASE WHEN t1.themeable_id = ? THEN t1.id ELSE NULL END) AS theme_id
        FROM themes t1
        WHERE t1.themeable_type = ?
        GROUP BY t1.name
        ORDER BY t1.name",
        [$themeable_id, $themeable_id, $themeable_type->value]
    );

    return array_map(fn($theme) => array_filter($theme), $themes);
}

function get_unique_affirmation_topics(Locale $locale)
{
    $hive = \Base::instance();
    $rows = $hive->get('DB')->exec("SELECT DISTINCT topic FROM affirmations WHERE locale = ? ORDER BY topic", [$locale->value]) ?? [];

    return array_map(fn($row) => $row['topic'], $rows);
}
