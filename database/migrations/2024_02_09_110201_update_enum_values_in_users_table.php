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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('faculty', [
                'İktisadi, idari ve Sosyal Bilimler Fakültesi',
                'Tıp Fakültesi', // Add or modify enum values as needed
                'Mühendislik ve Mimarlık Fakültesi',
                'Sanat ve Tasarım Fakültesi'
            ])->change();

            $table->enum('department', [
                'Ekonomi',
                'Ekonomi ve Finans',
                'Finans ve Bankacılık',
                'Gazetecilik',
                'Halkla İlişkiler ve Reklamcılık',
                'Havacılık Yönetimi (Türkçe/İngilizce)',
                'İngiliz Dili ve Edebiyatı (İngilizce)',
                'İngilizce Mütercim ve Tercümanlık',
                'İşletme (İngilizce)',
                'İşletme (Türkçe)',
                'Psikoloji',
                'Psikoloji (İngilizce)',
                'Sağlık Yönetimi',
                'Siyaset Bilimi ve Kamu Yönetimi',
                'Sosyal Hizmet (Türkçe/İngilizce)',
                'Sosyoloji',
                'Tarih',
                'Uluslararası İlişkiler (Türkçe/İngilizce)',
                'Uluslararası Ticaret ve Lojistik',
                'Yeni Medya ve İletişim',
                'Yeni Medya ve İletişim (İngilizce)',
                'Yönetim Bilişim Sistemleri (Türkçe/İngilizce)',

                'Cerrahi Tıp Bilimleri Bölümü',
                'Dahili Tıp Bilimleri Bölümü',
                'Temel Tıp Bilimleri Bölümü',
                
                'Bilgisayar Mühendisliği(Türkçe)',
                'Elektrik-Elektronik Mühendisliği (Türkçe / İngilizce)',
                'Endüstri Mühendisliği(Türkçe)',
                'İç Mimarlık ve Çevre Tasarımı(Türkçe)',
                'İnşaat Mühendisliği (İngilizce/Türkçe)',
                'Makine Mühendisliği(Türkçe)',
                'Mekatronik Mühendisliği(Türkçe)',
                'Mimarlık (İngilizce/Türkçe)',
                'Yazılım Mühendisliği (İngilizce)',

                'Dijital Oyun Tasarımı',
                'Endüstriyel Tasarım',
                'Gastronomi ve Mutfak Sanatları',
                'Grafik Tasarımı',
                'İç Mimarlık',
                'İç Mimarlık (İngilizce)',
                'İletişim ve Tasarımı',
                'Müzik (STF)',
                'Radyo, Televizyon ve Sinema',
                'Sahne ve Gösteri Sanatları Yönetimi',
                'Tekstil ve Moda Tasarımı',
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
