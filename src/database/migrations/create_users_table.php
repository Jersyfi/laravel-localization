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
        if (
            !Schema::hasColumn(
                config('localization.database.users_table_name'),
                config('localization.database.prefered_locale_column_name')
            )) {
            Schema::table('users', function (Blueprint $table) {
                $table->string(config('localization.database.prefered_locale_column_name'))->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
