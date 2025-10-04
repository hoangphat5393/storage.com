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
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('fullname')->nullable();
            $table->string('birthday')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable()->default('0');
            $table->string('phone')->nullable();
            $table->string('address', 300)->nullable();
            $table->string('email_info')->nullable();
            $table->integer('admin_level');
            $table->boolean('status')->default(false)->comment('0: enbale, 1: unable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
