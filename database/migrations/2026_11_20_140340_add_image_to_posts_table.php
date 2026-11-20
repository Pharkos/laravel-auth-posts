<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        // Aggiunge la colonna 'image' alla tabella posts esistente
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Percorso dell'immagine (es. "posts/abc123.jpg"), facoltativa
            $table->string('image')->nullable()->after('content');
        });
    }

    // Rollback: rimuove la colonna 'image'
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};

