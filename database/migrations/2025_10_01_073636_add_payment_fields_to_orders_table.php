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
        Schema::table('orders', function (Blueprint $table) {
            // إضافة حقول الدفع
            $table->string('payment_method', 32)->nullable()->after('stripe_session_id')->index();
            $table->string('payment_status', 32)->nullable()->after('payment_method')->index();
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->string('payment_reference', 128)->nullable()->after('paid_at')->index();
            $table->json('payment_details')->nullable()->after('payment_reference');

            // حقول خاصة بالدفع عند الاستلام (اختياري)
            $table->timestamp('cod_collected_at')->nullable()->after('payment_details');
            $table->unsignedBigInteger('cod_collector_id')->nullable()->after('cod_collected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // نحاول حذف الفهارس أولاً ثم الأعمدة
            // ملاحظة: Laravel يقبل تمرير مصفوفة أعمدة عند حذف الفهارس
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['payment_reference']);

            $table->dropColumn([
                'payment_method',
                'payment_status',
                'paid_at',
                'payment_reference',
                'payment_details',
                'cod_collected_at',
                'cod_collector_id',
            ]);
        });
    }
};
