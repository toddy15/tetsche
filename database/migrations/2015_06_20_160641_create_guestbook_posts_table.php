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
        Schema::create('guestbook_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('message');
            $table->text('cheffe')->nullable();
            $table->string('category', 14)->nullable();
            $table->string('spam_detection')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('guestbook_posts');
    }
};
