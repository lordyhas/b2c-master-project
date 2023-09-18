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
        Schema::table('customers', function (Blueprint $table) {
            $table->date('updated_at');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {


            if (Schema::hasColumn('customers', 'updated_at') &&
                Schema::hasColumn('customers', 'created_at')) {
                // drop the phone column

                $table->dropColumn('updated_at');
                $table->dropColumn('created_at');
            }
        });
    }
};
