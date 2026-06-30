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
    Schema::create('visitors', function (Blueprint $table) {
        $table->id();

        $table->string('visitor_id')->unique();

        $table->string('name');
        $table->string('phone');
        $table->string('email')->nullable();

        $table->string('company')->nullable();

        $table->string('category');

        $table->string('host_employee');

        $table->text('purpose');

        $table->string('id_proof_type')->nullable();
        $table->string('id_proof_number')->nullable();

        $table->string('photo')->nullable();

        $table->string('vehicle_number')->nullable();

        $table->enum('status', [
            'pending',
            'checked_in',
            'checked_out'
        ])->default('pending');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
