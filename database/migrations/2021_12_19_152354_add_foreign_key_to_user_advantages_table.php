<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToUserAdvantagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_advantages', function (Blueprint $table) {
            $table->foreign('service_id', 'fk_user_advantages_to_services')
                ->references('id')
                ->on('services')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_advantages', function (Blueprint $table) {
            $table->dropForeign('fk_user_advantages_to_services');
        });
    }
}
