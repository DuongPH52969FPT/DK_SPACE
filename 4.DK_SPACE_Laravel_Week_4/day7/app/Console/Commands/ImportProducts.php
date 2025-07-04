<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from fakestoreapi.com';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        $this->info('Fetching products...');
        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->failed()) {
            $this->error('Failed to fetch products');
            return 1;
        }

        $products = $response->json();

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['name' => $p['title']],
                [
                    'description' => $p['description'],
                    'price' => $p['price'],
                    'image_url' => $p['image'],
                ]
            );
        }

        $this->info('Products imported successfully.');
        return 0;
    }
}
