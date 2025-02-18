<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionAndCategoryToMenusTable extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->text('description')->nullable(); // Add description column
            $table->enum('category', ['FOOD', 'BEVERAGE'])->default('FOOD'); // Add category column
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('description'); // Remove description column
            $table->dropColumn('category'); // Remove category column
        });
    }
}