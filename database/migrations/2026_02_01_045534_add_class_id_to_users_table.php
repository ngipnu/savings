<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'class_room_id')) {
                $table->foreignId('class_room_id')->nullable()->after('class_name')->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'class_room_id')) {
                $table->dropForeign(['class_room_id']);
                $table->dropColumn('class_room_id');
            }
        });
    }
};
