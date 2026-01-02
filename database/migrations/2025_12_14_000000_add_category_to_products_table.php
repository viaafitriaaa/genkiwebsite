<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->default('food')->after('price');
        });

        DB::table('products')
            ->where('name', 'like', 'Genki%')
            ->update(['category' => 'smoothie']);

        DB::table('products')
            ->where('name', 'not like', 'Genki%')
            ->update(['category' => 'food']);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
