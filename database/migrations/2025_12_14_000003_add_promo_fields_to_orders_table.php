<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_promo')->default(false)->after('status');
            $table->string('promo_proof_path')->nullable()->after('is_promo');
            $table->timestamp('promo_verified_at')->nullable()->after('promo_proof_path');
            $table->unsignedInteger('promo_discount_percent')->nullable()->after('promo_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'is_promo',
                'promo_proof_path',
                'promo_verified_at',
                'promo_discount_percent',
            ]);
        });
    }
};
