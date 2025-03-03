<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('loans', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('loans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
