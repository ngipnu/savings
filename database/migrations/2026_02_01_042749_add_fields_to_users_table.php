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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->after('email'); // admin, student
            $table->string('student_id')->nullable()->unique()->after('role'); // NIS/NISN
            $table->string('class_name')->nullable()->after('student_id');
            $table->string('phone')->nullable()->after('class_name');
            $table->text('address')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_id', 'class_name', 'phone', 'address']);
        });
    }
};
