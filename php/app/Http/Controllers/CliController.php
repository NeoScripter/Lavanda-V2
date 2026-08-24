<?php

namespace Http\Controllers;

use Enums\AppEnv;
use Enums\CardVariant;
use Enums\DBView;
use Enums\ImageableType;
use Factories\ImageFactory;
use Http\Models\Card;
use Http\Models\FAQ;
use Http\Models\Iching;
use Http\Models\User;
use Http\Models\Image;
use Http\Models\PracticeItem;
use Http\Models\Rune;
use Http\Models\RuneTheme;
use Seeders\CardSeeder;
use Seeders\FAQSeeder;
use Seeders\IchingSeeder;
use Seeders\PracticeItemSeeder;
use Seeders\RuneSeeder;

const SCREEN_WIDTH = 152;
const METHOD_WIDTH = 12;

class CliController
{
    function routes(\Base $hive)
    {
        $routes = $hive->get('ROUTES');

        foreach ($routes as $url => $methods) {
            foreach ($methods as $route) {
                foreach ($route as $method => $meta) {
                    [$handler, $name] = [$meta[0], $meta[3]];
                    $new_handler = str_replace('Http\Controllers\\', '', $handler);

                    $color = match (trim($method)) {
                        'GET' => 'info',
                        'DELETE' => 'error',
                        default => 'warning',
                    };

                    $prefix = str_pad($method, METHOD_WIDTH) . ' ';
                    $suffix = trim((string) $name) !== '' ? " {$name} > {$new_handler}" : " {$new_handler}";
                    $url = str_pad($url . ' ', SCREEN_WIDTH - METHOD_WIDTH - strlen($suffix), '.');
                    echo cli_color($prefix, $color) . $url . $suffix . "\n";
                }
            }
        }
    }

    function migrate(\Base $hive)
    {
        User::setup();
        Card::setup();
        Image::setup();
        FAQ::setup();
        Rune::setup();
        RuneTheme::setup();
        Iching::setup();
        PracticeItem::setup();

        $this->create_db_views($hive);

        $this->create_card_backs($hive);

        if ($hive->app_env !== 'test') {
            echo "Migration completed.\n";
        }
    }

    function drop(\Base $hive)
    {
        $this->delete_db_views($hive);

        User::setdown();
        Card::setdown();
        Image::setdown();
        FAQ::setdown();
        Rune::setdown();
        RuneTheme::setdown();
        Iching::setdown();
        PracticeItem::setdown();

        delete_files_recursive(
            glob(UPLOAD_DIR . '/*')
        );

        if ($hive->app_env !== 'test') {
            echo "All tables deleted.\n";
        }
    }

    function seed(\Base $hive)
    {
        CardSeeder::run();
        FAQSeeder::run();
        RuneSeeder::run();
        IchingSeeder::run();
        PracticeItemSeeder::run();
    }

    function fresh(\Base $hive)
    {
        $this->drop($hive);
        $this->migrate($hive);
    }

    function link()
    {
        echo APP_DIR . PHP_EOL;
        $storage = APP_DIR  . '/storage/public';
        $link    = APP_DIR  . '/public/storage';

        if (file_exists($link)) {
            echo "Link already exists at {$link}" . PHP_EOL;
            return;
        }

        echo "Storage: {$storage}" . PHP_EOL;
        echo "Link: {$link}" . PHP_EOL;

        if (!is_dir($storage)) {
            mkdir($storage, 0755, true);
            echo "Created storage directory: {$storage}" . PHP_EOL;
        }

        if (symlink($storage, $link)) {
            echo "Symlink created: {$link} -> {$storage}" . PHP_EOL;
        } else {
            echo "Failed to create symlink" . PHP_EOL;
        }
    }

    function create_user(\Base $hive)
    {
        $name = $hive->get('GET.name');
        $email = $hive->get('GET.email');
        $password = $hive->get('GET.password');

        if (empty($name) || empty($email) || strlen($password) < 8) {
            if (! AppEnv::is(AppEnv::TESTING)) {
                cli_echo("❌ Usage: php index.php create_user --name=John --email=john@example.com --password=mypassword123", 'error');
                cli_echo("   Password must be at least 8 characters", 'error');
            }
            return false;
        }

        $row = $hive->get('DB')->exec('SELECT count(email) FROM users WHERE email = ?', [$email]);

        if (! empty($row[0]['count'])) {
            if (! AppEnv::is(AppEnv::TESTING)) {
                cli_echo("❌ User with this email already exists");
            }
            return false;
        }

        try {
            $user = new User();
            $user->copyFrom(compact('name', 'email', 'password'));
            $user->save();

            if (! AppEnv::is(AppEnv::TESTING)) {
                cli_echo("User created successfully!");
                cli_echo("   ID: {$user->id}");
                cli_echo("   Name: $name");
                cli_echo("   Email: $email");
            }
            return true;
        } catch (\Exception $e) {
            if (! AppEnv::is(AppEnv::TESTING)) {
                cli_echo("❌ Failed: {$e->getMessage()}", 'error');
            }
            return false;
        }
    }

    function update_password(\Base $hive)
    {
        $email = $hive->get('GET.email');
        $new_password = $hive->get('GET.password');

        if (empty($email) || strlen($new_password) < 8) {
            cli_echo("❌ Usage: php index.php reset_password --email=john@example.com --password=mypassword123", 'error');
            cli_echo("   Password must be at least 8 characters", 'error');
            exit(1);
        }

        $hash = password_hash($new_password, PASSWORD_DEFAULT);

        if ($hash === false) {
            cli_echo("❌ Failed to hash password", 'error');
            exit(1);
        }

        try {
            $user = new User();
            $user->load(['email=?', $email]);
            $user->copyFrom(['password' => $hash]);
            $user->save();

            cli_echo("Password updated successfully!");
            cli_echo("   ID: {$user->id}");
            cli_echo("   Name: $user->name");
            cli_echo("   Email: $email");
        } catch (\Exception $e) {
            cli_echo("❌ Failed: {$e->getMessage()}", 'error');
            exit(1);
        }
    }

    private function create_db_views(\Base $hive)
    {
        $db = $hive->get("DB");

        $card_view = DBView::FLIPCARD->value;

        $db->exec(
            "CREATE OR REPLACE VIEW {$card_view} AS
            SELECT
                c.id, c.name, c.html, c.advice, c.variant, c.locale, c.created_at,
                front.id as front_id, front.imageable_type as front_imageable_type, front.imageable_id as front_imageable_id, front.variant as front_variant, front.src as front_src, front.alt as front_alt,
                back.id as back_id, back.imageable_type as back_imageable_type, back.variant as back_variant, back.src as back_src, back.alt as back_alt
            FROM cards c
            LEFT JOIN images front ON front.imageable_id = c.id AND front.imageable_type = c.variant AND front.variant = 'front'
            LEFT JOIN images back ON back.imageable_type = c.variant AND back.variant = 'back';"
        );

        $rune_view = DBView::RUNE_ASSET->value;
        $imageable_type = ImageableType::RUNE->value;

        $db->exec(
            "CREATE OR REPLACE VIEW {$rune_view} AS
            SELECT
                r.id, r.name, r.advice, r.locale, r.created_at,
                front.id as front_id, front.imageable_type as front_imageable_type, front.imageable_id as front_imageable_id, front.variant as front_variant, front.src as front_src, front.alt as front_alt,
                back.id as back_id, back.imageable_type as back_imageable_type, back.imageable_id as back_imageable_id, back.variant as back_variant, back.src as back_src, back.alt as back_alt
            FROM runes r
            LEFT JOIN images front ON front.imageable_id = r.id AND front.imageable_type = '{$imageable_type}' AND front.variant = 'front'
            LEFT JOIN images back ON back.imageable_id = r.id AND back.imageable_type = '{$imageable_type}' AND back.variant = 'back';"
        );

        $practice_item_view = DBView::PRACTICE_ITEM_ASSET->value;
        $imageable_type = ImageableType::PRACTICE_ITEM->value;

        $db->exec(
            "CREATE OR REPLACE VIEW {$practice_item_view} AS
            SELECT
                item.id, item.title, item.description, item.file_src, item.faqs, item.locale, item.created_at,
                image.id as image_id, image.imageable_type as image_imageable_type, image.imageable_id as image_imageable_id, image.variant as image_variant, image.src as image_src, image.alt as image_alt
            FROM practice_items item
            LEFT JOIN images image ON image.imageable_id = item.id AND image.imageable_type = '{$imageable_type}' AND image.variant = 'image';"
        );
    }

    private function delete_db_views(\Base $hive)
    {
        $db = $hive->get("DB");

        $card_view = DBView::FLIPCARD->value;
        $db->exec("DROP VIEW IF EXISTS {$card_view} CASCADE");

        $rune_view = DBView::RUNE_ASSET->value;
        $db->exec("DROP VIEW IF EXISTS {$rune_view} CASCADE");

        $practice_item_view = DBView::PRACTICE_ITEM_ASSET->value;
        $db->exec("DROP VIEW IF EXISTS {$practice_item_view} CASCADE");
    }

    private function create_card_backs(\Base $hive)
    {
        $dir = $hive->app_env === 'test' ? 'test' : 'models/cards';

        foreach (CardVariant::values() as $card_variant) {
            (new ImageFactory(variant: 'back'))->create(dir: $dir, imageable_type: $card_variant, imageable_id: 1, variant: 'back');
        }
    }
}
