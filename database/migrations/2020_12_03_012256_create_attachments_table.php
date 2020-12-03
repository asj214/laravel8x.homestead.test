<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_type');
            $table->bigInteger('attachment_id');
            $table->string('filename');
            $table->string('url');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['attachment_id', 'attachment_type', 'deleted_at'], 'deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
