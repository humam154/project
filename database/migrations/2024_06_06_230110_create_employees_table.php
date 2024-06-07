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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable(false);

            $table->string('last_name')->nullable(false);

            $table->string('email')
                ->nullable(false)
                ->unique();

            $table->string('phone');

            $table->tinyInteger('employee_of_the_month')
                ->nullable(true)
                ->default(0)
                ->unsigned();

            $table->foreignId('salary_id')
                ->constrained('salaries')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
