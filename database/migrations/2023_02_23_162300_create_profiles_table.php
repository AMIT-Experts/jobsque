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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('language')->nullable();
            $table->string('intersted_work')->nullable();
            $table->string('offline_place')->nullable();
            $table->string('remote_place')->nullable();
            $table->string('bio')->nullable();
            $table->integer('education_id')->nullable();
            $table->string('experience')->nullable();
            $table->string('personal detailes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
