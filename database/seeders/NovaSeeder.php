<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\Transactions;
use App\Models\Transfer;
use Illuminate\Support\Facades\Hash;

class NovaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //user creation
        $user = User::create([
            'name' => 'Shaan Patel',
            'email' =>'shaan@novabank.com',
            'password' => Hash::make('password123'),


        ]);
        $checkingAccount = Account::create([
            'user_id' => $user->id,
            'name' => 'Checking Account',
            'balance' => 1000.00,
        ]);
        $savingsAccount = Account::create([
            'user_id' => $user->id,
            'name' => 'Savings Account',
            'balance' => 5000.00,
        ]);

        //create transactions
        Transactions::create([
            'user_id' => $user->id,
            'account_id' => $checkingAccount->id,
            'amount' => 200.00,
            'type' => 'debit',
            'description' => 'Grocery shopping',
        ]);
        Transactions::create([
            'user_id' => $user->id,
            'account_id' => $savingsAccount->id,
            'amount' => 1000.00,
            'type' => 'credit',
            'description' => 'Initial deposit',
        ]);
        Transactions::create([
            'user_id' => $user->id,
            'account_id' => $checkingAccount->id,
            'amount' => 150.00,
            'type' => 'debit',
            'description' => 'Utility bill payment',
        ]);
        Transactions::create([
            'user_id' => $user->id,
            'account_id' => $savingsAccount->id,
            'amount' => 500.00,
            'type' => 'credit',
            'description' => 'Salary deposit',
        ]);
    }
}
