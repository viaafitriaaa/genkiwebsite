<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Bundle;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            AdminUserSeeder::class,
            PromoSeeder::class,
        ]);
    }
}
