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
        Schema::create('job_executions', function (Blueprint $table) {
            $table->id();

            $table->string('job_id')->index();
            $table->string('job_name')->nullable()->index();
            $table->string('connection')->nullable()->index();
            $table->string('queue')->nullable()->index();

            $table->string('status')->index(); // processing | processed | failed
            $table->unsignedInteger('attempts')->nullable();

            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('finished_at')->nullable()->index();
            $table->unsignedInteger('duration_ms')->nullable();

            $table->text('last_error')->nullable();
            $table->string('exception_class')->nullable();
            $table->longText('exception_trace')->nullable();

            $table->longText('log')->nullable();
            $table->json('payload')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_executions');
    }
};

