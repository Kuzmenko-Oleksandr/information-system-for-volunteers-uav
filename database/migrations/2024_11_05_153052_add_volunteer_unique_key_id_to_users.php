<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('volunteer_unique_key_id')->nullable()->unique();
            $table->foreign('volunteer_unique_key_id')->references('id')->on('volunteer_unique_key')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['volunteer_unique_key_id']);
            $table->dropColumn('volunteer_unique_key_id');
        });
    }

};
