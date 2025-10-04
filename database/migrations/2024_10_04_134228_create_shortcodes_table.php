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
        Schema::create('shortcodes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('shortcode', 1000)->nullable();
            $table->string('handle_id', 500)->nullable();
            $table->string('name', 500)->nullable();
            $table->string('name_en', 500)->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image', 500)->nullable();
            $table->integer('sort')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(false);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('admin_id')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortcodes');
    }
};
