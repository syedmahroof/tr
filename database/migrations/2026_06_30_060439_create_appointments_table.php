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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_name');
            $table->string('visitor_email')->nullable();
            $table->string('visitor_company')->nullable();
            $table->foreignId('host_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('date_time');
            $table->string('purpose', 500);
            $table->string('status', 50)->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
