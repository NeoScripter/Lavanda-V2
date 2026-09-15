<?php

namespace Http\Controllers;

use Enums\AppEnv;
use Enums\CardVariant;
use Enums\DBView;
use Enums\ImageableType;
use Exception;
use Factories\ImageFactory;
use Http\Models\Affirmation;
use Http\Models\Article;
use Http\Models\AudioMessage;
use Http\Models\Card;
use Http\Models\FAQ;
use Http\Models\Iching;
use Http\Models\User;
use Http\Models\Image;
use Http\Models\Legal;
use Http\Models\MatchSet;
use Http\Models\PracticeItem;
use Http\Models\Rune;
use Http\Models\Stone;
use Http\Models\Theme;
use Seeders\AffirmationSeeder;
use Seeders\ArticleSeeder;
use Seeders\AudioMessageSeeder;
use Seeders\CardSeeder;
use Seeders\FAQSeeder;
use Seeders\IchingSeeder;
use Seeders\LegalSeeder;
use Seeders\PracticeItemSeeder;
use Seeders\RuneSeeder;
use Seeders\StoneSeeder;

class CliController
{
    private $db_models = [User::class, Theme::class, Card::class, Image::class, FAQ::class, Rune::class, Iching::class, PracticeItem::class, AudioMessage::class, Affirmation::class, Article::class, Stone::class, MatchSet::class, Legal::class];

    private $db_seeders = [CardSeeder::class, FAQSeeder::class, RuneSeeder::class, IchingSeeder::class, PracticeItemSeeder::class, AudioMessageSeeder::class, AffirmationSeeder::class, ArticleSeeder::class, StoneSeeder::class, LegalSeeder::class];


    function routes(\Base $hive)
    {
        $routes = $hive->get('ROUTES');

        $screen_width = 152;
        $method_width = 12;

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

                    $prefix = str_pad($method, $method_width) . ' ';
                    $suffix = trim((string) $name) !== '' ? " {$name} > {$new_handler}" : " {$new_handler}";
                    $url = str_pad($url . ' ', $screen_width - $method_width - strlen($suffix), '.');
                    echo cli_color($prefix, $color) . $url . $suffix . "\n";
                }
            }
        }
    }

    function migrate(\Base $hive)
    {
        foreach ($this->db_models as $model) {
            $model::setup();
        }

        $this->create_db_views();
        $this->create_compound_indexes($hive);

        if ($hive->app_env !== 'test') {
            echo "Migration completed.\n";
        }
    }

    function drop(\Base $hive)
    {
        $this->delete_db_views();

        foreach ($this->db_models as $model) {
            $model::setdown();
        }

        delete_files_recursive(
            glob(UPLOAD_DIR . '/*')
        );

        $this->delete_compound_indexes($hive);

        if ($hive->app_env !== 'test') {
            echo "All tables deleted.\n";
        }
    }

    function seed()
    {
        foreach ($this->db_seeders as $seeder) {
            $seeder::run();
        }
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
        $name = query_user('User name:');
        $email = query_user('User email:');
        $password = query_user('User password:');

        $is_test = AppEnv::is(AppEnv::TESTING);

        $row = $hive->get('DB')->exec('SELECT count(email) FROM users WHERE email = ?', [$email]);

        if (! empty($row[0]['count'])) {
            if (! $is_test) {
                cli_echo("❌ User with this email already exists");
            }
            return false;
        }

        try {
            $user = new User();
            $user->copyFrom(compact('name', 'email', 'password'));
            $user->save();

            if (! $is_test) {
                cli_echo("User created successfully!");
                cli_echo("   Name: $name");
                cli_echo("   Email: $email");
            }
            return true;
        } catch (\Exception $e) {
            if (! $is_test) {
                cli_echo("❌ Failed: {$e->getMessage()}", 'error');
            }
            return false;
        }
    }

    function update_password()
    {
        $email = query_user('User email:');
        $new_password = query_user('New password:');

        try {
            $user = new User();
            $user->load(['email=?', $email]);
            $user->password = $new_password;
            $user->save();

            cli_echo("Password updated successfully!");
            cli_echo("   Name: $user->name");
            cli_echo("   Email: $email");
        } catch (\Exception $e) {
            cli_echo("❌ Failed: {$e->getMessage()}", 'error');
            exit(1);
        }
    }

    private function create_db_views()
    {
        $db = \Base::instance()->get("DB");
        $path = APP_DIR . "/db/Views/";

        foreach (DBView::values() as $view) {

            $sql = file_get_contents($path . $view);

            if ($sql === false) {
                throw new Exception("Db view for  $view not found");
            }

            $db->exec($sql);
        }
    }

    private function delete_db_views()
    {
        $db = \Base::instance()->get("DB");

        foreach (DBView::values() as $view) {
            $db->exec("DROP VIEW IF EXISTS {$view} CASCADE");
        }
    }

    private function create_compound_indexes(\Base $hive)
    {
        $db = $hive->get("DB");

        $exists = $db->exec("SELECT 1 FROM pg_indexes WHERE indexname = 'idx_theme_parent_name'");

        if (!$exists) {
            $db->exec('CREATE UNIQUE INDEX idx_theme_parent_name ON themes (themeable_type, themeable_id, name)');
        }
    }

    private function delete_compound_indexes(\Base $hive)
    {
        $db = $hive->get("DB");
        $db->exec('DROP INDEX IF EXISTS idx_theme_parent_name;');
    }
}
