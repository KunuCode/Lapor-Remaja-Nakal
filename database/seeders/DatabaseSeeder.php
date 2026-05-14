<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SliderPhoto;
use App\Models\CamatPhoto;
use App\Models\Profile;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. Buat Akun Admin
        // ==========================================
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kecamatan.id',
            'password' => 'admin123',
            'phone' => '081234567890',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 2. Buat Akun Masyarakat
        // ==========================================
        $masyarakat = User::create([
            'name' => 'Masyarakat Sample',
            'email' => 'user@test.com',
            'password' => 'user123',
            'phone' => '089876543210',
            'role' => 'masyarakat',
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 3. Buat Slider Photos
        // ==========================================
        SliderPhoto::create([
            'image_path' => 'images/sliders/slide1.jpg',
            'caption' => 'Selamat Datang di Website Kecamatan Silaen',
            'order' => 0,
            'active' => true,
        ]);

        SliderPhoto::create([
            'image_path' => 'images/sliders/slide2.jpg',
            'caption' => 'Laporkan Kenakalan Remaja di Lingkungan Anda',
            'order' => 1,
            'active' => true,
        ]);

        SliderPhoto::create([
            'image_path' => 'images/sliders/slide3.jpg',
            'caption' => 'Bersama Membangun Kecamatan yang Aman dan Sejahtera',
            'order' => 2,
            'active' => true,
        ]);

        // ==========================================
        // 4. Buat Camat Photo
        // ==========================================
        CamatPhoto::create([
            'image_path' => 'images/camat/camat.jpg',
            'name' => 'Nama Camat',
            'position' => 'Camat Kecamatan Silaen',
            'bio' => 'Camat Kecamatan Silaen yang bertugas memimpin dan mengoordinasikan penyelenggaraan pemerintahan, pembangunan, dan pelayanan masyarakat di wilayah Kecamatan Silaen, Kabupaten Toba.',
            'active' => true,
        ]);

        // ==========================================
        // 5. Buat Profil (Visi Misi, Struktur, About)
        // ==========================================
        Profile::create([
            'type' => 'visi_misi',
            'title' => 'Visi dan Misi Kecamatan Silaen',
            'content' => '<h3>Visi</h3><p>Terwujudnya Kecamatan Silaen yang maju, aman, dan sejahtera berdasarkan nilai-nilai kearifan lokal dan semangat gotong royong masyarakat.</p><h3>Misi</h3><ul><li>Meningkatkan kualitas pelayanan publik kepada masyarakat</li><li>Mendorong pertumbuhan ekonomi masyarakat melalui pemberdayaan UMKM</li><li>Menciptakan lingkungan yang aman, tertib, dan kondusif</li><li>Mengembangkan potensi sumber daya alam dan budaya lokal</li><li>Meningkatkan kualitas pendidikan dan kesehatan masyarakat</li><li>Mencegah dan menangani kenakalan remaja secara komprehensif</li></ul>',
            'image_path' => 'images/profiles/visi_misi.jpg',
        ]);

        Profile::create([
            'type' => 'struktur',
            'title' => 'Struktur Organisasi Kecamatan Silaen',
            'content' => '<h3>Struktur Organisasi Pemerintahan Kecamatan Silaen</h3><p>Kecamatan Silaen dipimpin oleh seorang Camat yang bertanggung jawab kepada Bupati melalui Sekretaris Daerah. Struktur organisasi kecamatan terdiri dari:</p><ul><li><strong>Camat</strong> - Pimpinan Kecamatan</li><li><strong>Sekretaris Kecamatan</strong> - Mengkoordinasikan administrasi kecamatan</li><li><strong>Kasi Pemerintahan</strong> - Urusan pemerintahan dan ketertiban</li><li><strong>Kasi Pelayanan Umum</strong> - Urusan pelayanan masyarakat</li><li><strong>Kasi Trantib</strong> - Urusan ketertiban dan keamanan</li><li><strong>Kelurahan/Desa</strong> - Unit pemerintahan di bawah kecamatan</li></ul>',
            'image_path' => 'images/profiles/struktur.jpg',
        ]);

        Profile::create([
            'type' => 'about',
            'title' => 'Tentang Kecamatan Silaen',
            'content' => '<h3>Tentang Kecamatan Silaen</h3><p>Kecamatan Silaen merupakan salah satu kecamatan yang berada di Kabupaten Toba, Provinsi Sumatera Utara. Kecamatan ini memiliki kekayaan budaya dan alam yang luar biasa.</p><p>Dengan semangat pelayanan prima, pemerintah kecamatan berkomitmen untuk terus meningkatkan kesejahteraan masyarakat melalui berbagai program pembangunan dan pemberdayaan.</p><p>Salah satu program unggulan kami adalah penanganan kenakalan remaja melalui pendekatan preventif dan rehabilitatif, dengan melibatkan seluruh elemen masyarakat dalam menjaga keamanan dan ketertiban di lingkungan kecamatan.</p><h4>Kontak Kecamatan</h4><ul><li>Alamat: Jl. Raya Kecamatan Silaen, Kabupaten Toba</li><li>Telepon: (0622) 123456</li><li>Email: kecamatan.silaen@tobakab.go.id</li><li>Jam Pelayanan: Senin - Jumat, 08:00 - 16:00 WIB</li></ul>',
            'image_path' => 'images/profiles/about.jpg',
        ]);

        // ==========================================
        // 6. Buat Berita
        // ==========================================
        $news1 = News::create([
            'title' => 'Kecamatan Silaen Gelar Sosialisasi Pencegahan Kenakalan Remaja',
            'content' => '<p>Kecamatan Silaen pada hari Selasa (15/01/2024) menggelar sosialisasi pencegahan kenakalan remaja yang dihadiri oleh ratusan warga dari berbagai desa di wilayah kecamatan.</p><p>Kegiatan yang bertempat di Aula Kecamatan ini menghadirkan narasumber dari Kepolisian Resort Toba, Dinas Sosial, serta tokoh masyarakat dan agama. Camat Silaen dalam sambutannya menyampaikan bahwa kenakalan remaja menjadi perhatian serius pemerintah kecamatan.</p><p>"Kita harus bersama-sama mencegah kenakalan remaja. Orang tua, guru, dan masyarakat harus berkolaborasi dalam mendidik generasi muda," ujar Camat Silaen.</p><p>Sosialisasi ini juga memperkenalkan sistem pelaporan online melalui website kecamatan, sehingga masyarakat dapat dengan mudah melaporkan kasus-kasus kenakalan remaja yang terjadi di lingkungan mereka.</p>',
            'summary' => 'Kecamatan Silaen menggelar sosialisasi pencegahan kenakalan remaja yang dihadiri ratusan warga. Kegiatan ini menghadirkan narasumber dari kepolisian dan dinas sosial.',
            'link' => null,
            'published' => true,
        ]);

        NewsImage::create([
            'news_id' => $news1->id,
            'image_path' => 'images/news/berita1.jpg',
            'caption' => 'Suasana sosialisasi pencegahan kenakalan remaja di Aula Kecamatan Silaen',
            'order' => 0,
        ]);

        $news2 = News::create([
            'title' => 'Program Magrib Mengaji Dilaunching di Seluruh Desa Kecamatan Silaen',
            'content' => '<p>Dalam upaya mencegah kenakalan remaja, Kecamatan Silaen meluncurkan program "Magrib Mengaji" yang akan dilaksanakan di seluruh masjid dan gereja di wilayah kecamatan.</p><p>Program ini merupakan hasil musyawarah antara pemerintah kecamatan dengan para pemuda, tokoh agama, dan masyarakat. Kegiatan ini diharapkan dapat menjadi wadah positif bagi remaja untuk mengisi waktu luang, khususnya di waktu magrib.</p><p>"Dengan program ini, kita berharap remaja-remaja kita bisa terhindar dari pergaulan bebas dan kegiatan negatif lainnya," kata Sekretaris Kecamatan Silaen.</p><p>Program Magrib Mengaji akan dimulai pada bulan Februari 2024 dan berlangsung setiap hari Senin hingga Jumat. Setiap peserta akan mendapatkan pembinaan dari ustaz/pendeta setempat serta kegiatan kreatif lainnya.</p>',
            'summary' => 'Kecamatan Silaen meluncurkan program Magrib Mengaji di seluruh desa sebagai upaya mencegah kenakalan remaja dan memberikan wadah positif bagi generasi muda.',
            'link' => null,
            'published' => true,
        ]);

        NewsImage::create([
            'news_id' => $news2->id,
            'image_path' => 'images/news/berita2.jpg',
            'caption' => 'Launching program Magrib Mengaji di Kecamatan Silaen',
            'order' => 0,
        ]);

        $news3 = News::create([
            'title' => 'Lomba Kreativitas Remaja Dalam Rangka HUT Kemerdekaan RI',
            'content' => '<p>Menyambut HUT Kemerdekaan Republik Indonesia ke-79, Kecamatan Silaen mengadakan lomba kreativitas remaja yang berlangsung selama satu minggu penuh.</p><p>Berbagai perlombaan diselenggarakan, mulai dari lomba pidato, lomba menulis, lomba fotografi, hingga lomba desain poster bertema kebangsaan dan anti-kenakalan remaja.</p><p>Kepala Kasi Pemuda dan Olahraga Kecamatan Silaen menjelaskan bahwa kegiatan ini bertujuan untuk menggali potensi kreatif remaja serta menjauhkan mereka dari kegiatan negatif.</p><p>"Remaja yang kreatif adalah remaja yang produktif. Melalui lomba ini, kita ingin menunjukkan bahwa ada banyak cara positif untuk mengekspresikan diri," tuturnya.</p><p>Total hadiah yang disiapkan mencapai puluhan juta rupiah, dengan pemenang akan menerima trofi dari Bupati Toba.</p>',
            'summary' => 'Kecamatan Silaen mengadakan lomba kreativitas remaja menyambut HUT RI ke-79 dengan berbagai kategori perlombaan untuk mencegah kenakalan remaja.',
            'link' => null,
            'published' => true,
        ]);

        NewsImage::create([
            'news_id' => $news3->id,
            'image_path' => 'images/news/berita3.jpg',
            'caption' => 'Peserta lomba kreativitas remaja di Kecamatan Silaen',
            'order' => 0,
        ]);

        // ==========================================
        // 7. Buat Laporan Sample
        // ==========================================
        $report1 = Report::create([
            'title' => 'Kelompok Remaja yang Sering Berkumpul di Malam Hari',
            'name' => 'Masyarakat Sample',
            'email' => 'user@test.com',
            'phone' => '089876543210',
            'category' => 'Kenakalan Remaja',
            'village' => 'Desa Silaen',
            'address' => 'Jl. Raya Desa Silaen, Kecamatan Silaen',
            'description' => 'Saya ingin melaporkan adanya kelompok remaja yang sering berkumpul di pinggir jalan pada malam hari. Mereka sering membuat kegaduhan dan terkadang terlibat tawuran dengan kelompok remaja dari desa sebelah. Hal ini sangat mengganggu ketenangan warga sekitar dan membahayakan keselamatan pengguna jalan.',
            'status' => 'baru',
            'admin_note' => null,
            'user_id' => $masyarakat->id,
        ]);

        ReportImage::create([
            'report_id' => $report1->id,
            'image_path' => 'images/reports/laporan1.jpg',
            'caption' => 'Lokasi remaja berkumpul',
            'order' => 0,
        ]);

        $report2 = Report::create([
            'title' => 'Vandalisme di Taman Desa Lumban Gaol',
            'name' => 'Masyarakat Sample',
            'email' => 'user@test.com',
            'phone' => '089876543210',
            'category' => 'Vandalisme',
            'village' => 'Desa Lumban Gaol',
            'address' => 'Taman Desa Lumban Gaol, Kecamatan Silaen',
            'description' => 'Taman desa yang baru saja diperbaiki dengan dana pembangunan desa kini rusak karena coretan-coretan yang dilakukan oleh remaja yang tidak bertanggung jawab. Fasilitas umum seperti bangku taman dan tempat sampah juga rusak. Mohon agar pihak kecamatan dapat menindaklanjuti laporan ini dan mengambil tindakan pencegahan.',
            'status' => 'diproses',
            'admin_note' => 'Laporan telah diterima dan sedang ditindaklanjuti oleh Kasi Trantib. Akan dilakukan koordinasi dengan kepala desa terkait.',
            'user_id' => $masyarakat->id,
        ]);

        ReportImage::create([
            'report_id' => $report2->id,
            'image_path' => 'images/reports/laporan2.jpg',
            'caption' => 'Kerusakan fasilitas taman desa',
            'order' => 0,
        ]);

        // ==========================================
        // 8. Buat Site Settings
        // ==========================================
        SiteSetting::create([
            'key' => 'site_name',
            'value' => 'Lapor Remaja Nakal - Kecamatan Silaen',
        ]);

        SiteSetting::create([
            'key' => 'site_description',
            'value' => 'Sistem pelaporan online untuk masyarakat Kecamatan Silaen dalam melaporkan kasus kenakalan remaja dan permasalahan lingkungan.',
        ]);

        SiteSetting::create([
            'key' => 'contact_email',
            'value' => 'kecamatan.silaen@tobakab.go.id',
        ]);

        SiteSetting::create([
            'key' => 'contact_phone',
            'value' => '(0622) 123456',
        ]);

        SiteSetting::create([
            'key' => 'contact_address',
            'value' => 'Jl. Raya Kecamatan Silaen, Kabupaten Toba, Sumatera Utara',
        ]);
    }
}
