<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // المعرف الحقيقي
            $table->uuid('sku')
                ->after('id')
                ->unique()
                ->nullable();

            // معلومات إضافية (لاحقًا)
            $table->string('brand')
                ->nullable()
                ->after('sku');

            $table->string('origin_country')
                ->nullable()
                ->after('brand');

            $table->string('barcode')
                ->nullable()
                ->after('origin_country');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku',
                'brand',
                'origin_country',
                'barcode',
            ]);
        });
    }
};
