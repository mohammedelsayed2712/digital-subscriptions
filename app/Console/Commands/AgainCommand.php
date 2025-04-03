<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class AgainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'again';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $commands = [
            'php artisan migrate:fresh --seed',
            'php artisan storage:link',
            'php artisan cache:clear',
            'php artisan config:clear',
            'php artisan route:clear',
            'php artisan view:clear',
            'php artisan optimize:clear',

        ];
        foreach ($commands as $command) {
            $this->info('Running command: ' . $command);
            $this->info(shell_exec($command));
        }

        $this->info('Again command run successfully!');
        return Command::SUCCESS;
    }
}
