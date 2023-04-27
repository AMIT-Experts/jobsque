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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('job_time_type');
            $table->string('job_type');
            $table->string('job_level');
            $table->string('job_description');
            $table->string('job_skill');
            $table->string('comp_name');
            $table->string('comp_email');
            $table->string('comp_website');
            $table->string('about_comp');
            $table->string('location');
            $table->string('salary');
            $table->integer('favorites')->nullable();
            $table->boolean('expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
