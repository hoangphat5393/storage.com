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
        Schema::create('customer', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 191);
            $table->string('full_name')->nullable();
            $table->string('email', 191)->unique('email');
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();
            $table->text('about_me')->nullable();
            $table->date('birthday');
            $table->string('phone', 11);
            $table->mediumText('address');
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('ward')->nullable();
            $table->mediumText('avatar')->nullable();
            $table->string('password');
            $table->boolean('status')->default(false);
            $table->string('remember_token', 191);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
