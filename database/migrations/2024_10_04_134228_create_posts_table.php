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
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 1000)->nullable();
            $table->string('name', 1000)->nullable();
            $table->string('name_en', 1000)->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image', 500)->nullable();
            $table->longText('cover')->nullable();
            $table->longText('icon')->nullable();
            $table->longText('gallery')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->integer('sort')->nullable()->default(0);
            $table->longText('seo_title')->nullable();
            $table->longText('seo_keyword')->nullable();
            $table->longText('seo_description')->nullable();
            $table->integer('gallery_checked')->nullable()->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
