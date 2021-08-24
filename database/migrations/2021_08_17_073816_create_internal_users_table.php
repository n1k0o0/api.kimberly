<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $internalUserTypes = [...\App\Models\InternalUser::TYPES, \App\Models\InternalUser::TYPE_SUPER_ADMIN];
        Schema::create('internal_users', function (Blueprint $table) use ($internalUserTypes) {
            $table->id();
            $table->string('login')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->enum('type', $internalUserTypes);
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
        Schema::dropIfExists('internal_users');
    }
}
