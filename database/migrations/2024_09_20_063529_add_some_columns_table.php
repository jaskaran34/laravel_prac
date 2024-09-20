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
        Schema::table('log', function (Blueprint $table) {
            //
            $table->string('route_url')->nullable();
            $table->string('route_path')->nullable();
            $table->string('prev_url')->nullable();
            $table->string('route')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log', function (Blueprint $table) {
            //

            $table->dropColumn('route_url');
            $table->dropColumn('route_path');
            $table->dropColumn('prev_url');
            $table->string('route')->nullable(false)->change();
            
        });
    }
};
