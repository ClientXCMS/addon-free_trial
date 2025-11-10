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
        Schema::table('freetrial_config', function (Blueprint $table) {
            $table->boolean('show_on_card')->default(true)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('freetrial_config', function (Blueprint $table) {
            $table->dropColumn('show_on_card');
        });
    }
};
