<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSpamDetectionFieldToGuestbookPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guestbook_posts', function (Blueprint $table) {
            $table->string('spam_detection')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guestbook_posts', function (Blueprint $table) {
            $table->dropColumn('spam_detection');
        });
    }
}
