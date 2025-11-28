<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_type')->nullable();
            $table->string('listing_category')->nullable();
            $table->text('property_details')->nullable();
            $table->decimal('selling_price', 15, 2)->nullable();
            $table->string('commission_offered')->nullable();
            $table->text('conditions')->nullable();
            $table->string('listing_owner')->nullable();
            $table->string('owner_contact_number')->nullable();

            // House & Lot / Townhouse
            $table->decimal('lot_area', 10, 2)->nullable();
            $table->decimal('floor_area', 10, 2)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('carport')->nullable();

            // Lot Only
            $table->string('lot_classification')->nullable();

            // Condo
            $table->string('unit_type')->nullable();
            $table->string('parking')->nullable();

            // Commercial / Apartment
            $table->decimal('monthly_income', 12, 2)->nullable();
            $table->integer('total_units')->nullable();
            $table->string('commercial_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'property_type','listing_category','property_details','selling_price','commission_offered','conditions','listing_owner','owner_contact_number',
                'lot_area','floor_area','bedrooms','bathrooms','carport',
                'lot_classification','unit_type','parking','monthly_income','total_units','commercial_type',
            ]);
        });
    }
};
