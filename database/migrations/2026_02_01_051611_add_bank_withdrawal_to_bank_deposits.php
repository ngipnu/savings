<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_deposits', function (Blueprint $table) {
            $table->enum('type', ['deposit', 'withdrawal'])->default('deposit')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('bank_deposits', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
