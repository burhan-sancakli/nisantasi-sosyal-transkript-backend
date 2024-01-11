<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['id' => 1, 'parent_id' => null, 'name' => 'Projeler', 'description' => 'açıklama', 'score' => 40],
            ['id' => 2, 'parent_id' => 1, 'name' => 'Patent başvurusunda bulunmak', 'description' => 'açıklama', 'score' => 40],
            ['id' => 3, 'parent_id' => 1, 'name' => 'TÜBİTAK Lisans projeleri yürütücü', 'description' => 'açıklama', 'score' => 30],
            ['id' => 4, 'parent_id' => 1, 'name' => 'TÜBİTAK Lisans projeleri araştırmacı', 'description' => 'açıklama', 'score' => 20],
            ['id' => 5, 'parent_id' => 1, 'name' => 'TÜBİTAK Lisans projeleri bursiyer', 'description' => 'açıklama', 'score' => 10],
            ['id' => 6, 'parent_id' => 1, 'name' => 'Tasarım başvurusu yapmak', 'description' => 'açıklama', 'score' => 20],
            ['id' => 7, 'parent_id' => 1, 'name' => 'Faydalı model başvurusu yapmak', 'description' => 'açıklama', 'score' => 20],
            ['id' => 8, 'parent_id' => 1, 'name' => 'BAP projelerinde araştırmacı', 'description' => 'açıklama', 'score' => 10],
            ['id' => 9, 'parent_id' => 1, 'name' => 'Yeşil kampüs projeleri araştırmacı', 'description' => 'açıklama', 'score' => 10],
            ['id' => 10, 'parent_id' => 1, 'name' => 'TÜBİTAK 2209 A-B Öğrenci Projeleri yürütücü', 'description' => 'açıklama', 'score' => 20],
            ['id' => 11, 'parent_id' => 1, 'name' => 'BAP Projelerinde yürütücü', 'description' => 'açıklama', 'score' => 20],
            ['id' => 12, 'parent_id' => 1, 'name' => 'Uluslararası hakemli dergilerde yazar', 'description' => 'açıklama', 'score' => 30],
            ['id' => 13, 'parent_id' => 1, 'name' => 'Ulusal Kongrede bildiri sunmak', 'description' => 'açıklama', 'score' => 20],
            ['id' => 14, 'parent_id' => 1, 'name' => 'Uluslararası Kongrede bildiri sunmak', 'description' => 'açıklama', 'score' => 50],
            ['id' => 15, 'parent_id' => null, 'name' => 'En az bir dönem süreyle yürütülen idari öğrenci görevleri', 'description' => 'açıklama', 'score' => 60],
            ['id' => 16, 'parent_id' => 15, 'name' => 'Sosyal sorumluluk projelerinde yer almak', 'description' => 'açıklama', 'score' => 20],
            ['id' => 17, 'parent_id' => 15, 'name' => 'TEKNOFEST yarışmasına katılmak', 'description' => 'açıklama', 'score' => 15],
            ['id' => 18, 'parent_id' => 15, 'name' => 'Toplumsal katkı faaliyetlerinde yer almak', 'description' => 'açıklama', 'score' => 15],
            ['id' => 19, 'parent_id' => 15, 'name' => 'Kamu yardım kuruluşlarının faaliyetlerine katılmak', 'description' => 'açıklama', 'score' => 10],
            ['id' => 20, 'parent_id' => 15, 'name' => 'Sürdürülebilirlikle ilgili faaliyetlerde yer almak', 'description' => 'açıklama', 'score' => 10],
            ['id' => 21, 'parent_id' => 15, 'name' => 'Ders kapsamında yapılan sosyal sorumluluk faaliyetlerinde yer almak', 'description' => 'açıklama', 'score' => 5],
            ['id' => 22, 'parent_id' => 15, 'name' => 'Sertifika programlarına katılmak', 'description' => 'açıklama', 'score' => 20],
            ['id' => 23, 'parent_id' => null, 'name' => 'Toplumsal Katkı', 'description' => 'açıklama', 'score' => 50],
            ['id' => 24, 'parent_id' => 23, 'name' => 'En az bir dönem süreyle yürütülen idari öğrenci görevleri', 'description' => 'açıklama', 'score' => 50],
            ['id' => 25, 'parent_id' => 23, 'name' => 'İklim temsilcisi', 'description' => 'açıklama', 'score' => 20],
            ['id' => 26, 'parent_id' => 23, 'name' => 'YÖKAK veya ulusal akreditasyon kuruluşlarında öğrenci temsilciliği', 'description' => 'açıklama', 'score' => 20],
            ['id' => 27, 'parent_id' => 23, 'name' => 'Kalite Komisyonu öğrenci temsilciliği', 'description' => 'açıklama', 'score' => 20],
            ['id' => 28, 'parent_id' => 23, 'name' => 'Strateji Geliştirme Kurulu öğrenci temsilciliği', 'description' => 'açıklama', 'score' => 20],
            ['id' => 29, 'parent_id' => 23, 'name' => 'Öğrenci konseyi başkanlığı', 'description' => 'açıklama', 'score' => 20],
            ['id' => 30, 'parent_id' => 23, 'name' => 'Akademik birim kalite ekibi temsilciliği', 'description' => 'açıklama', 'score' => 15],
            ['id' => 31, 'parent_id' => 23, 'name' => 'Öğrenci konseyi yönetim kurulu üyesi', 'description' => 'açıklama', 'score' => 10],
            ['id' => 32, 'parent_id' => 23, 'name' => 'Fakülte öğrenci temsilciliği', 'description' => 'açıklama', 'score' => 10],
            ['id' => 33, 'parent_id' => null, 'name' => 'Kültür', 'description' => 'açıklama', 'score' => 60],
            ['id' => 34, 'parent_id' => 33, 'name' => 'Değişim programlarından faydalanmak', 'description' => 'açıklama', 'score' => 60],
            ['id' => 35, 'parent_id' => 33, 'name' => 'Erasmus', 'description' => 'açıklama', 'score' => 30],
            ['id' => 36, 'parent_id' => 33, 'name' => 'Değişim programları sorumlusu', 'description' => 'açıklama', 'score' => 10],
            ['id' => 37, 'parent_id' => 33, 'name' => 'MoU üniversiteleri ile anlaşma kapsamında öğrenci değişim programına katılmak', 'description' => 'açıklama', 'score' => 30],
            ['id' => 38, 'parent_id' => null, 'name' => 'Bilim, Kültür, Spor ve Sanat', 'description' => 'açıklama', 'score' => 69],
            ['id' => 39, 'parent_id' => 38, 'name' => 'Uluslararası düzeyde düzenlenen etkinliklerde ödül almak', 'description' => 'açıklama', 'score' => 30],
            ['id' => 40, 'parent_id' => 38, 'name' => 'Uluslararası düzeyde düzenlenen etkinliklerde görev almak', 'description' => 'açıklama', 'score' => 20],
            ['id' => 41, 'parent_id' => 38, 'name' => 'Ulusal düzeyde düzenlenen etkinliklerde ödül almak', 'description' => 'açıklama', 'score' => 15],
            ['id' => 42, 'parent_id' => 38, 'name' => 'Ulusal düzeyde düzenlenen etkinliklerde görev almak', 'description' => 'açıklama', 'score' => 10],
            ['id' => 43, 'parent_id' => 38, 'name' => 'Uluslararası düzeyde düzenlenen etkinliklere katılmak', 'description' => 'açıklama', 'score' => 10],
            ['id' => 44, 'parent_id' => 38, 'name' => 'Ulusal düzeyde düzenlenen etkinliklere katılmak', 'description' => 'açıklama', 'score' => 5],
        ];
        foreach ($activities as $activity) {
            DB::table('activities')->insert([
                'id' => $activity['id'],
                'parent_id' => $activity['parent_id'],
                'name' => $activity['name'],
                'description' => $activity['description'],
                'score' => $activity['score'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }        
    }
}
