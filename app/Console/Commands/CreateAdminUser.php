<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Enter your email');
        $password = $this->secret('Enter your password');

        User::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin user created successfully');
    }
}
