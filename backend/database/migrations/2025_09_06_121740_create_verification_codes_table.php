<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('code', 6);
            $table->timestamp('expires_at');
            $table->string('ip_address', 45)->nullable();
            $table->boolean('used')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'code']);
            $table->index(['user_id', 'used']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_codes');
    }
};
