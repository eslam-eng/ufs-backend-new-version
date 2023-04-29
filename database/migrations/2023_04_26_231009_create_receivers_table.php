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
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->text('receiving_company');
            $table->string('phone');
            $table->foreignIdFor(\App\Models\Branch::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Location::class,'city_id')->cascadeOnUpdate()->constrained('locations')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Location::class,'area_id')->cascadeOnUpdate()->constrained('locations')->cascadeOnDelete();
            $table->string('reference')->unique()->nullable();
            $table->string('title')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivers');
    }
};
