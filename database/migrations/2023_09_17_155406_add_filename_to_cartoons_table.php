<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cartoons', function (Blueprint $table) {
            $table->string('filename')->after('id');
        });

        // Fill the new field with filename data
        DB::statement(
            'UPDATE cartoons SET filename=CONCAT(
                "images/cartoons/",
                publish_on,
                ".cartoon.",
                random_number,
                ".jpg"
            )'
        );

        Schema::table('cartoons', function (Blueprint $table) {
            $table->dropColumn('publish_on');
            $table->dropColumn('random_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cartoons', function (Blueprint $table) {
            $table->dropColumn('filename');
            $table->date('publish_on');
            $table->string('random_number');
        });
    }
};
