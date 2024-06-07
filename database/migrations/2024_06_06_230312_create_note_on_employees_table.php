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
        Schema::create('note_on_employees', function (Blueprint $table) {
            $table->id();

            $table->text('note');

            $table->foreignId('incentive_id')
                ->constrained('distributed_incentives')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('regulation_id')
                ->constrained('regulations')
                ->cascadeOnUpdate()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_on_employees');
    }
};
