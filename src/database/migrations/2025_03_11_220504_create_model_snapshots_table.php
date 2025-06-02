<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('model_snapshots', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject');
            $table->longText('stored_model');
            $table->string('version');
            $table->json('options');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('model_snapshots');
    }
};
