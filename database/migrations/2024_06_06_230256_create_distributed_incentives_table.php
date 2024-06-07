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
        Schema::create('distributed_incentives', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->float('amount');

            $table->tinyInteger('points_amount')->unsigned();

            $table->foreignId('share_id')
                ->constrained('incentive_shares')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributed_incentives');
    }
};
