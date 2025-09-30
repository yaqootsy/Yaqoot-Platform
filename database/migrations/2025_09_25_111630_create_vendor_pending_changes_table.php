<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_pending_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // vendor_id هنا يشير إلى vendors.user_id (ليس vendors.id)
            $table->unsignedBigInteger('vendor_id');
            $table->string('field', 100);
            $table->text('old_value')->nullable();
            $table->text('new_value');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('viewed_at')->nullable();

            $table->timestamps();

            $table->index('vendor_id');
            $table->foreign('vendor_id')->references('user_id')->on('vendors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_pending_changes');
    }
};
