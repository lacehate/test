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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('Название');
            $table->string('slug')->unique()->comment('ЧПУ');
            $table->text('content')->comment('Контент');
            $table->text('preview')->comment('Превью');
            $table->string('published_at')->nullable()->default(null)->comment('Дата публикации');
            $table->unsignedBigInteger('count')->default(0)->comment('Счетчик');
            $table->foreignId('news_category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
