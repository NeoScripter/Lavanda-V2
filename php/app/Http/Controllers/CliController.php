<?php

namespace Http\Controllers;

use Http\Models\Card;
use Http\Models\User;
use Http\Models\Image;
use Seeders\CardSeeder;

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
                    $suffix = trim($name) !== '' ? " {$name} > {$new_handler}" : " {$new_handler}";
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

        if ($hive->app_env !== 'test') {
            echo "Migration completed.\n";
        }

    }

    function drop(\Base $hive)
    {
        User::setdown();
        Card::setdown();
        Image::setdown();

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
            cli_echo("❌ Usage: php index.php create_user --name=John --email=john@example.com --password=mypassword123", 'error');
            cli_echo("   Password must be at least 8 characters", 'error');
            exit(1);
        }

        try {
            $user = new User();
            $user->copyFrom(compact('name', 'email', 'password'));
            $user->save();

            cli_echo("User created successfully!");
            cli_echo("   ID: {$user->id}");
            cli_echo("   Name: $name");
            cli_echo("   Email: $email");
        } catch (\Exception $e) {
            cli_echo("❌ Failed: {$e->getMessage()}", 'error');
            exit(1);
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
}
