<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubModulePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_module_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_permission_id');            
            $table->string('sub_module_name');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('module_permission_id')->references('id')->on('module_permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_module_permissions');
    }
}
