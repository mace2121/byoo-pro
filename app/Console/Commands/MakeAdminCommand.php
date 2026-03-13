<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'byoo:make-admin {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a specific user an admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        $user = \App\Models\User::where('username', $username)->first();

        if (!$user) {
            $this->error("Kullanıcı bulunamadı: {$username}");
            return Command::FAILURE;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("Kullanıcı '{$username}' başarıyla admin yapıldı.");
        
        return Command::SUCCESS;
    }
}
