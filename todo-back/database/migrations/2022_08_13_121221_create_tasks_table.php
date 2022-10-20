<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('task_name');
            $table->string('description');
            $table->string('status');
            $table->bigInteger('duration');
            $table->string('priority');

            // Foreign key
            $table->bigInteger('assignee')->unsigned()->index()->nullable();
            $table->foreign('assignee')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_assignee_foreign');
            $table->dropColumn('assignee');
        });
        Schema::dropIfExists('tasks');
    }
};
