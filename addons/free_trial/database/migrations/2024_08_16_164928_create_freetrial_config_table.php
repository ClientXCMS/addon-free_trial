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
        Schema::create('freetrial_config', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('trial_days');
            $table->integer('max_allowed_services')->default(0);
            $table->integer('current_allowed_services')->default(0);
            $table->integer('max_services')->default(1);
            $table->unsignedBigInteger('trials')->default(0);
            $table->enum('type', ['trial', 'free'])->default('trial');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
        if (Schema::hasColumn('services', 'trial_ends_at')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('trial_ends_at');
            });
            Schema::table('services', function (Blueprint $table) {
                $table->timestamp('trial_ends_at')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freetrial_config');
    }
};
