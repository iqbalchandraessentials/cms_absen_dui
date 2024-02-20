<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('emergency_name')->nullable();
            $table->string('emergency_number')->nullable();
            $table->string('golongan')->nullable();
            $table->string('active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('emergency_name');
            $table->dropColumn('emergency_number');
            $table->dropColumn('golongan');
            $table->dropColumn('active');
        });
    }
}
