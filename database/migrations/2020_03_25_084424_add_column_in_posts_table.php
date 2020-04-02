<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('keyword', 500)->change();
            $table->dateTime('date')->change();
            $table->string('url_md5', 255)->after('sub_category_id');
            $table->string('url_origin', 255)->after('url_md5');
            $table->string('web', 50)->after('url_origin');
            $table->integer('category_id')->after('sub_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['url_md5', 'url_origin', 'web', 'category_id']);
        });
    }
}
