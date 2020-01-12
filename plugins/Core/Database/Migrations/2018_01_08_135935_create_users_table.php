<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->string('user_id')->unique();

            $table->string('first_name')->nullable();
            $table->text('avatar')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');


            $table->string('phone_number')->unique()->nullable();
            $table->string('mobile_number')->unique()->nullable();

            $table->text('bio')->nullable();

            $table->enum('gender', ['Men', 'Women'])->nullable();
            $table->enum('lang', ['en', 'fr'])->nullable();

            $table->boolean('status')->default(true);
            $table->boolean('banned')->default(false);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
