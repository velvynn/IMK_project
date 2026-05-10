<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_expired_at')) {
                $table->timestamp('payment_expired_at')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('orders', 'payment_account')) {
                $table->json('payment_account')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'payment_qr_code')) {
                $table->text('payment_qr_code')->nullable()->after('payment_account');
            }
            if (!Schema::hasColumn('orders', 'virtual_account_number')) {
                $table->string('virtual_account_number')->nullable()->after('payment_qr_code');
            }
            if (!Schema::hasColumn('orders', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('paid_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_expired_at', 
                'payment_account', 
                'payment_qr_code', 
                'virtual_account_number', 
                'cancelled_at'
            ]);
        });
    }
};