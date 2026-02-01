<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('parent_name')->nullable()->after('address');
            $table->string('parent_phone')->nullable()->after('parent_name');
            $table->string('parent_email')->nullable()->after('parent_phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['parent_name', 'parent_phone', 'parent_email']);
        });
    }
};
