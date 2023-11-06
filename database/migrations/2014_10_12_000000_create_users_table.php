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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cid');
            $table->integer('organization');
            $table->integer('dc_id');
            $table->string('email')->unique();
            $table->string('contact');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('verified')->default(0);
            $table->integer('user_ref_id')->default(0);
            $table->char('status')->default('I');
            $table->boolean('is_dcfocal')->nullable();
            // $table->string('file_path')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('is_thim_dc')->default(0);
            $table->boolean('is_pling_dc')->default(0);
            $table->boolean('is_jakar_dc')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
