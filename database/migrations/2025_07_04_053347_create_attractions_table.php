<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attractions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subdistrict_id')->constrained('subdistricts')->onDelete('cascade');
            $table->string('name');
            $table->string('photo_profile')->nullable();
            $table->text('desc');
            $table->boolean('has_facility')->default(false);
            // $table->enum('type', ['your', 'enum', 'values', 'here']); // Replace with actual types
            $table->string('type');
            $table->string('legality');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
