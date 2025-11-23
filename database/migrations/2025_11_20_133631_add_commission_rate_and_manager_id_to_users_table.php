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
            // New: Stores the agent's rate (e.g., 0.60, 0.90) for commission calculation.
            $table->decimal('commission_rate', 4, 2)->nullable()->after('role');
            
            // New: Stores the ID of the manager/director this user reports to.
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null')->after('commission_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['manager_id']);
            
            // Drop the columns
            $table->dropColumn('manager_id');
            $table->dropColumn('commission_rate');
        });
    }
};