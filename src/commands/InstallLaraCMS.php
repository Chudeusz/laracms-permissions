<?php

namespace Chudeusz\Permissions\Commands;

use Illuminate\Console\Command;

class InstallLaraCMS extends Command
{

    const YES = 'Y';

    const NO = 'N';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing LaraCMS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $env = $this->ask('Create .env? Y - Yes, N - No', 'Y');
        if ($env == self::YES)
        {
            copy('.env.example', '.env');
            exec('php artisan key:generate');

            $envFile = file_get_contents('.env');
            $appName = $this->ask('App Name', 'Laravel');

            $envFile = str_replace('DB_HOST=127.0.0.1', 'APP_NAME=' . $appName, $envFile);

            $installDb = $this->ask('Install database?', self::YES);

            if($installDb == self::YES) {
                $envFile = file_get_contents('.env');
                $dbHost = $this->ask('Database host', '127.0.0.1');
                $dbUser = $this->ask('Database user', 'root');
                $dbPassword = $this->ask('Database password', '');
                $dbName = $this->ask('Database name', 'laracms');
                $dbPort = $this->ask('Database port', 3306);

                $envFile = str_replace('DB_HOST=127.0.0.1', 'DB_HOST=' . $dbHost, $envFile);
                $envFile = str_replace('DB_USERNAME=homestead', 'DB_USERNAME=' . $dbUser, $envFile);
                $envFile = str_replace('DB_PASSWORD=secret', 'DB_PASSWORD=' . $dbPassword, $envFile);
                $envFile = str_replace('DB_DATABASE=homestead', 'DB_DATABASE=' . $dbName, $envFile);
                $envFile = str_replace('DB_PORT=3306', 'DB_PORT=' . $dbPort, $envFile);

            }

            file_put_contents('.env', $envFile);

            $commands = $this->ask('Confirm to database migrate and insert seeders?', self::YES);
            if($commands == self::YES) {
                exec('php artisan migrate --seed');
            }
        } else {
            $this->info('Install canceled.');
        }

    }
}
