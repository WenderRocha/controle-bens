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
        Schema::create('real_state_properties', function (Blueprint $table) {
            $table->id();
            $table->string('acquisition_data');
            $table->string('description');
            $table->foreignId('secretary_id')->constrained('secretaries');
            $table->foreignId('acquisition_type_id')->constrained('acquisition_types');
            $table->string('address');
            $table->decimal('value', 12,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_state_properties');
    }
};
