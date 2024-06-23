<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    protected $signature = 'app:create-user';

    protected $description = 'Create a user.';

    public function handle(): int
    {
		$name = $this->ask('Name:');
		$email = $this->ask('Email:');
		$password = $this->secret('Password:');

		$user = User::create([
			'name' => $name,
			'email' => $email,
			'password' => Hash::make($password),
		]);

		$this->info(sprintf('User created with ID: %s', $user->id));

		return self::SUCCESS;
    }
}
