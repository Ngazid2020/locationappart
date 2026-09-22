<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('short_description');
            $table->integer('max_guests')->default(2)->after('base_price');
            $table->integer('bedrooms')->default(1)->after('max_guests');
            $table->integer('bathrooms')->default(1)->after('bedrooms');
            $table->json('amenities')->nullable()->after('bathrooms');
            $table->string('address')->nullable()->after('amenities');
            $table->string('city')->nullable()->after('address');
            $table->decimal('latitude', 10, 7)->nullable()->after('city');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'description', 'max_guests', 'bedrooms', 'bathrooms',
                'amenities', 'address', 'city', 'latitude', 'longitude'
            ]);
        });
    }
};