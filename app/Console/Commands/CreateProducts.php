<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Product::count() > 0) {
            $this->warn('Products already exist.');

            return;
        }

        $productsArray = [
            [
                'uuid' => Str::uuid(),
                'name' => 'Package 1',
                'chat_credit' => 10,
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Package 2',
                'chat_credit' => 20,
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Package 3',
                'chat_credit' => 30,
            ],
        ];

        Product::insert($productsArray);

        $this->info('Products created successfully.');
    }
}
