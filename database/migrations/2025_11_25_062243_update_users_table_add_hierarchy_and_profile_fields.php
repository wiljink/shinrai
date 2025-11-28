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
            // Add columns only if they do not exist
            if (!Schema::hasColumn('users', 'birthday')) {
                $table->date('birthday')->nullable()->after('branch_id');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable()->after('birthday');
            }

            if (!Schema::hasColumn('users', 'manager_id')) {
                $table->unsignedBigInteger('manager_id')->nullable()->after('gender');
                $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('manager_id');
            }

            if (!Schema::hasColumn('users', 'commission_rate')) {
                $table->decimal('commission_rate', 8, 2)->default(0)->after('profile_photo');
            }

            if (!Schema::hasColumn('users', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('commission_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_approved')) $table->dropColumn('is_approved');
            if (Schema::hasColumn('users', 'commission_rate')) $table->dropColumn('commission_rate');
            if (Schema::hasColumn('users', 'profile_photo')) $table->dropColumn('profile_photo');

            // Drop foreign key first
            if (Schema::hasColumn('users', 'manager_id')) {
                $table->dropForeign(['manager_id']);
                $table->dropColumn('manager_id');
            }

            if (Schema::hasColumn('users', 'gender')) $table->dropColumn('gender');
            if (Schema::hasColumn('users', 'birthday')) $table->dropColumn('birthday');
        });
    }
};
