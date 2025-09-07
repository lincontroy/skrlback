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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('pin', 4);
            $table->string('customer_id')->unique();
            $table->string('skiller_badge')->nullable();
            $table->boolean('biometrics_enabled')->default(false);
            $table->boolean('notifications_enabled')->default(true);
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('currency', 3)->default('KES');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
