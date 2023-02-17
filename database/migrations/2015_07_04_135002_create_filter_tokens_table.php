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
        Schema::create('filter_tokens', function (Blueprint $table) {
            $table->string('token');
            $table->integer('count_ham')->unsigned();
            $table->integer('count_spam')->unsigned();
        });
        //        DB::statement('CREATE TABLE filter_tokens (token TINYTEXT BINARY NOT NULL, count_ham INTEGER UNSIGNED NOT NULL, count_spam INTEGER UNSIGNED NOT NULL)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('filter_tokens');
    }
};
