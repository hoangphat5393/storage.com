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
        Schema::create('category', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('slug', 1000)->nullable();
            $table->string('type', 50);
            $table->string('name', 1000)->nullable();
            $table->string('name_en', 1000)->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('content')->nullable();
            $table->mediumText('content_en')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->integer('parent')->nullable()->default(0);
            $table->boolean('hot')->nullable()->default(false);
            $table->boolean('recommended')->nullable()->default(false);
            $table->integer('sort')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(false);
            $table->integer('admin_id')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
