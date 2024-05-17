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
        Schema::table('divisions', function (Blueprint $table) {
            $table->bigInteger('division_id');
            $table->string('division_name_en');
            $table->renameColumn('name', 'division_name_bn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('division_id')->nullable();
            $table->dropColumn('division_name_en')->nullable();
            $table->renameColumn('division_name_bn', 'name');
        });
    }
};
