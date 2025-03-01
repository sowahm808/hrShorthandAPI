<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade'); // Cascade delete to remove surveys if employee is deleted
            $table->date('survey_date');
            $table->timestamps();

            // Indexes for faster querying
            $table->index('survey_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
};
