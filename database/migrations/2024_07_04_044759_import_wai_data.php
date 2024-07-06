<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reg_provinces', function (Blueprint $table) {
            $table->string('id', 2)->primary();
            $table->string('name')->index();
        });

        Schema::create('reg_regencies', function (Blueprint $table) {
            $table->string('id', 4)->primary();
            $table->string('province_id', 2);
            $table->string('name');

            $table->foreign('province_id')->references('id')->on('reg_provinces');
        });

        Schema::create('reg_districts', function (Blueprint $table) {
            $table->string('id', 6)->primary();
            $table->string('regency_id', 4);
            $table->string('name');

            $table->foreign('regency_id')->references('id')->on('reg_regencies');
        });

        Schema::create('reg_villages', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('district_id', 6);
            $table->string('name');

            $table->foreign('district_id')->references('id')->on('reg_districts');
        });

        DB::unprepared(Storage::get('db/wilayah_indonesia.sql'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('reg_villages');
        Schema::drop('reg_districts');
        Schema::drop('reg_regencies');
        Schema::drop('reg_provinces');
    }
};
