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
            $table->string('name', 50);
            $table->string('short_description', 200)->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->unsignedInteger('project_id');
            $table->unsignedBigInteger('parent_task_id')->nullable();
            $table->timestamp('original_due_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assignee_id')->references('id')->on('assignees');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
