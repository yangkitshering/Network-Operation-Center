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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cid');
            $table->string('email');
            $table->string('contact');
            $table->integer('dc');
            $table->integer('organization');
            $table->integer('rack');
            $table->string('reason'); 
            $table->timestamp('visitFrom')->nullable();
            $table->timestamp('visitTo')->nullable();
            $table->boolean('exited');
            $table->char('status');
            $table->integer('requester_ref');
            $table->string('passport_path');
            $table->string('reject_reason')->nullable();
            $table->integer('focal_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
