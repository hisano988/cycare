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
        Schema::create('period_records', function (Blueprint $table) {
            $table->id('period_record_id');
            $table->unsignedInteger('user_id')->comment('ユーザID');
            $table->date('start_date')->comment('開始日');
            $table->date('end_date')->nullable()->comment('終了日');
            $table->boolean('is_calc_target')->comment('計算対象フラグ');
            $table->comment('周期記録');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('period_records');
    }
};
