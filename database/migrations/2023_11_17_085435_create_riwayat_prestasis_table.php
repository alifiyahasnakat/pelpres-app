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
        Schema::create('riwayat_prestasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('nisn');
            $table->string('kelas');
            $table->string('angkatan');
            $table->string('kompetisi');
            $table->string('juara');
            $table->string('tingkat');
            $table->string('poin');
            $table->string('keterangan');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_prestasis');
    }
};
