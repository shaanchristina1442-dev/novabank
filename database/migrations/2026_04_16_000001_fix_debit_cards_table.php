<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('debit_cards', function (Blueprint $table) {
            if (!Schema::hasColumn('debit_cards', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('debit_cards', 'name')) {
                $table->string('name')->after('user_id');
            }
            if (!Schema::hasColumn('debit_cards', 'card_number')) {
                $table->string('card_number')->unique()->after('name');
            }
            if (!Schema::hasColumn('debit_cards', 'debit_balance')) {
                $table->decimal('debit_balance', 12, 2)->default(0)->after('card_number');
            }
            if (!Schema::hasColumn('debit_cards', 'status')) {
                $table->string('status')->default('active')->after('debit_balance');
            }
        });
    }

    public function down(): void
    {
        Schema::table('debit_cards', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'name', 'card_number', 'debit_balance', 'status']);
        });
    }
};
