<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_infos', static function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->date('date_of_birth');
            $table->integer('gender');
            $table->text('about');
            $table->string('city');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamp('created_at')
                ->nullable()
                ->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrentOnUpdate()
                ->nullable()
                ->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
