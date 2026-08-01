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
        Schema::create('pengumpulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tugas')->constrained('tugas')->onDelete('cascade');
            $table->foreignId('id_siswa')->constrained('users')->onDelete('cascade');
            $table->text('jawaban_atau_link'); // Siswa mengirim jawaban teks atau link Google Drive agar tidak error upload file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulans');
    }
};
