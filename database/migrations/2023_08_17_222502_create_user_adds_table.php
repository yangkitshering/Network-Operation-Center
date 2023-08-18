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
        Schema::create('user_adds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cid');
            $table->integer('organization');
            $table->string('email');
            $table->string('contact');
            $table->boolean('verified')->default(0);
            $table->integer('user_id')->default(0);
            $table->integer('user_ref_id')->default(0);
            $table->char('status')->default('I');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_adds');
    }
};
