<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('_debit__card') && !Schema::hasTable('debit_cards')) {
            Schema::rename('_debit__card', 'debit_cards');
        }

        if (!Schema::hasColumn('payments', 'debit_card_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->foreignId('debit_card_id')->nullable()->constrained('debit_cards')->onDelete('set null')->after('credit_card_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'debit_card_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropForeign(['debit_card_id']);
                $table->dropColumn('debit_card_id');
            });
        }

        if (Schema::hasTable('debit_cards') && !Schema::hasTable('_debit__card')) {
            Schema::rename('debit_cards', '_debit__card');
        }
    }
};
