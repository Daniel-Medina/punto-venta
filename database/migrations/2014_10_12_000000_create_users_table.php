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
            $table->id();
            $table->string('name');
            $table->string('phone', 10)->nullable();

            $table->string('email')->unique();
            $table->enum('status', ['ACTIVE', 'LOCKED'])->default('ACTIVE');
            //$table->enum('profile', ['ADMIN', 'EMPLEADO'])->default('EMPLEADO');
            $table->string('profile')->default('');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image', 100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
