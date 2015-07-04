<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_tokens', function (Blueprint $table) {
            $table->binary('token');
            $table->integer('count_ham')->unsigned();
            $table->integer('count_spam')->unsigned();
        });
//        DB::statement('CREATE TABLE filter_tokens (token TINYTEXT BINARY NOT NULL, count_ham INTEGER UNSIGNED NOT NULL, count_spam INTEGER UNSIGNED NOT NULL)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filter_tokens');
    }
}
