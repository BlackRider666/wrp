<?php

use App\Models\Transaction\TransactionStatus\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionStatus::create([
            'name'  =>  'Pending',
        ]);
        TransactionStatus::create([
            'name'  =>  'Complete',
        ]);
        TransactionStatus::create([
            'name'  =>  'Cancel',
        ]);
        TransactionStatus::create([
            'name'  =>  'Error',
        ]);
    }
}
