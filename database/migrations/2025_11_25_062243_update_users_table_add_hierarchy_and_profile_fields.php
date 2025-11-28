<?php  

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Personal info
            $table->date('birthday')->nullable()->after('branch_id');
            $table->string('gender')->nullable()->after('birthday');

            // Commission percentage (60/70/80/90)
            $table->float('commission_rate')->default(0)->after('gender');

            // Sales manager assignment (self-referencing)
            $table->unsignedBigInteger('manager_id')->nullable()->after('commission_rate');
            $table->foreign('manager_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn([
                'birthday',
                'gender',
                'commission_rate',
                'manager_id'
            ]);
        });
    }
};
