<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpRequestListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_request_lists', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('phone');
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('township_id');
            $table->text('activities');
            $table->text('address');
            $table->string('ip_address')->index();
            $table->text('user_agent')->nullable();
            $table->boolean('status')->default(0);
            $table->index(['name', 'phone']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help_request_lists');
    }
}
