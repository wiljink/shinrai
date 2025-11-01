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
            // If you still have a "name" column, we can drop it (optional)
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }

            // Add new fields based on your registration form
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->after('id');
            }

            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->after('first_name');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['broker', 'agent', 'buyer'])->default('buyer')->after('last_name');
            }

            if (!Schema::hasColumn('users', 'invited_by')) {
                $table->string('invited_by')->nullable()->after('role');
            }

            if (!Schema::hasColumn('users', 'birthday')) {
                $table->date('birthday')->nullable()->after('invited_by');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable()->after('birthday');
            }

            if (!Schema::hasColumn('users', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('gender');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'role',
                'invited_by',
                'birthday',
                'gender',
                'is_approved',
            ]);

            // Optionally restore the 'name' column if it existed
            $table->string('name')->nullable();
        });
    }
};
