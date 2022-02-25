<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->nullable()->default(0)->comment('类型：1资讯新闻 2学习中心');
            $table->integer('class')->nullable()->default(0)->comment('所属文章分类');
            $table->text('description')->comment('描述');
            $table->string('banner')->nullable()->default('')->comment('banner图片');
            $table->string('title')->nullable()->default('')->comment('标题');
            $table->text('content')->comment('内容');
            $table->integer('creator_id')->nullable()->default(0)->comment('作者ID');
            $table->integer('status')->nullable()->default(0)->comment('状态：1已发布 2已删除');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
