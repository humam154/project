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
        Schema::create('increment_on_employees', function (Blueprint $table) {
            $table->foreignId('salary_increment_id')
                ->constrained('salary_increments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('percentage', 3, 2);


            $table->timestamps();


            $table->primary(['salary_increment_id', 'employee_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('increment_on_employees');
    }
};
