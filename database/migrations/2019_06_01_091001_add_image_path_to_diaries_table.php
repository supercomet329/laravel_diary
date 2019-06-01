<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagePathToDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * php artisan make:migration add_image_path_to_diaries_table --table=diaries
         * ↑このコマンドでファイル作成
         * 
         */
        Schema::table('diaries', function (Blueprint $table) {
            $table->string('image_path')->after('body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diaries', function (Blueprint $table) {
            $table->dropColumn(('image_path'));
        });
    }
}
