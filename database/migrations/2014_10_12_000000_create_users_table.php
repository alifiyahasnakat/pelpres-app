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
            $table->string('nips')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('kelas')->nullable(); 
            $table->string('angkatan')->nullable(); 
            $table->string('nohp')->nullable();
            $table->float('poin_prestasi')->nullable()->default(0);
            $table->integer('poin_pelanggaran')->nullable()->default(0);
            $table->boolean('is_superAdmin')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_guru')->default(false);
            $table->boolean('is_siswa')->default(false);
            $table->boolean('is_alumni')->default(false);
            $table->boolean('is_pensiun')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
