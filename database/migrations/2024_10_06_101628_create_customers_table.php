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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('family', 255)->nullable()->index();
            $table->unsignedBigInteger('mobile')->unique();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('national_code')->nullable()->index();
            $table->date('birthday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
