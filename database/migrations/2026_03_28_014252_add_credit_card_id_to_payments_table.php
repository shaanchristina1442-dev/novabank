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
        Schema::table('payments', function (Blueprint $table) {
            //
            $table->foreignId('credit_card_id')->nullable()->constrained('credit_cards')->onDelete('set null')->after('account_id');
            $table->string('payment_source')->default('account')->after('credit_card_id');
        });
        Schema::table('payments', function (Blueprint $table){
            $table->foreignId('account_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
            $table->dropForeign(['credit_card_id']);
            $table->dropColumn(['credit_card_id', 'payment_source']);
            $table->foreignId('account_id')->nullable(false)->change();
        });
    }
};
