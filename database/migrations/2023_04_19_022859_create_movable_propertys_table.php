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
        Schema::create('movable_propertys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secretary_id')->constrained('secretaries');
            $table->foreignId('local_id')->nullable()->constrained('locals');
            $table->foreignId('departament_id')->nullable()->constrained('departaments');
            $table->foreignId('conservation_type_id')->constrained('conservation_states');
            $table->foreignId('acquisition_type_id')->constrained('acquisition_types');
            $table->string('overturning_number');
            $table->string('acquisition_data');
            $table->string('fiscal_note')->nullable();
            $table->string('description');
            $table->decimal('value', 12,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movable_propertys');
    }
};
