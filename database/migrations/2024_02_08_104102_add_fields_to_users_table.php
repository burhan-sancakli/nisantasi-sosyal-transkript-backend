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
            $table->enum('faculty',['Mühendislik ve Mimarlık Fakültesi'])->after('university_id')->default('Mühendislik ve Mimarlık Fakültesi');
            $table->enum('department', ['Yazılım Mühendisliği (İngilizce)', 'Bilgisayar Mühendisliği'])->after("faculty")->default('Yazılım Mühendisliği (İngilizce)');
            $table->boolean('is_admin')->default(false)->after('department');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('faculty');
            $table->dropColumn('department');
            $table->dropColumn('is_admin');
        });
    }
};
