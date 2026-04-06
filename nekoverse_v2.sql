-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Apr 2026 pada 02.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nekoverse_v2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `excerpt` varchar(300) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `tgl_publish` datetime DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0,
  `is_trending` tinyint(1) DEFAULT 0,
  `status` enum('draft','published') DEFAULT 'published'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `slug`, `isi`, `excerpt`, `gambar`, `id_kategori`, `id_penulis`, `tgl_publish`, `views`, `is_trending`, `status`) VALUES
(10, 'Elden Ring Tembus 30 Juta Kopi, Bukti Kesuksesan Game Soulslike', 'elden-ring', 'Game Elden Ring kembali mencatat pencapaian besar dengan total penjualan yang telah menembus angka 30 juta kopi di seluruh dunia. Pencapaian ini menjadi bukti bahwa game dengan tingkat kesulitan tinggi tetap memiliki daya tarik yang kuat di kalangan pemain.\r\n\r\nSejak dirilis pada tahun 2022, Elden Ring langsung mendapatkan perhatian luas berkat konsep gameplay yang menantang serta dunia open-world yang luas dan detail. Game ini mengusung gaya soulslike yang dikenal dengan tingkat kesulitan tinggi, di mana pemain dituntut untuk memiliki strategi, ketelitian, dan kesabaran dalam menghadapi berbagai tantangan.\r\n\r\nKesuksesan Elden Ring tidak hanya berasal dari gameplay-nya, tetapi juga dari desain dunia yang mendalam dan kebebasan eksplorasi yang diberikan kepada pemain. Banyak pemain menghabiskan waktu puluhan hingga ratusan jam untuk menjelajahi setiap sudut dunia permainan, mengembangkan karakter, serta mengalahkan berbagai musuh dan boss yang menantang.\r\n\r\nSelain itu, komunitas pemain yang aktif juga turut berperan dalam mempertahankan popularitas game ini. Berbagai diskusi, panduan, dan konten kreatif terus bermunculan, membuat Elden Ring tetap relevan meskipun telah dirilis beberapa tahun lalu.\r\n\r\nDengan pencapaian penjualan yang luar biasa ini, Elden Ring semakin mengukuhkan posisinya sebagai salah satu game paling berpengaruh di industri game modern. Ke depan, kesuksesan ini juga membuka peluang untuk pengembangan konten tambahan maupun proyek lanjutan yang berkaitan dengan dunia Elden Ring.', 'Game Elden Ring berhasil mencatat penjualan lebih dari 30 juta kopi di seluruh dunia, menjadikannya salah satu game paling sukses dan berpengaruh dalam beberapa tahun terakhir.', '1775371052_69d2032cb3a4b.jpg', 4, 1, '2026-04-05 00:31:14', 8, 0, 'published'),
(11, 'AKB48 Rilis “Nagori Zakura”, Lagu Perpisahan yang Penuh Makna', 'akb48', 'Grup idol Jepang AKB48 kembali merilis karya terbaru mereka melalui single ke-67 yang berjudul “Nagori Zakura”. Lagu ini langsung menarik perhatian karena menghadirkan tema yang emosional, yaitu tentang perpisahan, kelulusan, serta perasaan cinta yang tidak sempat diungkapkan.\r\n\r\nSecara makna, “Nagori Zakura” menggambarkan bunga sakura yang masih tersisa di akhir musim semi. Dalam budaya Jepang, sakura sering menjadi simbol perpisahan dan awal baru, sehingga lagu ini terasa sangat dekat dengan kehidupan banyak orang, terutama yang sedang mengalami perubahan fase dalam hidup.\r\n\r\nSingle ini juga menjadi momen penting bagi grup karena menampilkan generasi baru sebagai center. Hal ini menunjukkan adanya proses regenerasi dalam tubuh AKB48, di mana anggota baru mulai mengambil peran utama. Perpaduan antara member senior dan generasi baru menciptakan keseimbangan yang menarik dalam penampilan mereka.\r\n\r\nSelain itu, lagu ini juga berkaitan dengan momen kelulusan Mukaichi Mion yang menjadi salah satu figur penting dalam grup. Kehadirannya dalam single ini menambah kesan emosional, terutama bagi penggemar yang telah mengikuti perjalanan kariernya sejak awal.\r\n\r\nMusic video yang dirilis turut memperkuat pesan lagu dengan visual yang menampilkan suasana musim semi dan bunga sakura yang berguguran. Nuansa tersebut memberikan kesan nostalgia sekaligus harapan akan masa depan yang baru.', 'Grup idol AKB48 merilis single ke-67 berjudul “Nagori Zakura” yang mengangkat tema perpisahan, kelulusan, dan perasaan yang belum tersampaikan, sekaligus menjadi momen penting bagi beberapa member.', '1775370320_69d2005031787.webp', 2, 1, '2026-04-05 00:31:46', 9, 0, 'published'),
(12, 'JoJo Steel Ball Run Belum Rilis Episode 2, Ini Penyebabnya', 'jojo-sbr', 'Anime JoJo\'s Bizarre Adventure: Steel Ball Run berhasil menarik perhatian penggemar sejak episode pertamanya dirilis. Episode pembuka tersebut hadir dengan durasi yang cukup panjang dan berfungsi sebagai pengenalan dunia serta karakter utama seperti Johnny Joestar dan Gyro Zeppeli. Dengan latar cerita yang berbeda dari seri sebelumnya, anime ini langsung menciptakan antusiasme tinggi di kalangan penggemar.\r\n\r\nNamun, setelah episode pertama tayang, kelanjutan cerita justru belum kunjung hadir. Banyak penggemar mulai mempertanyakan kapan episode kedua akan dirilis. Berdasarkan informasi yang beredar, salah satu penyebab utama adalah belum adanya jadwal rilis resmi dari pihak distributor maupun platform streaming. Hal ini membuat anime tersebut tidak masuk dalam daftar tayangan mingguan seperti kebanyakan anime lainnya.\r\n\r\nSelain itu, proses produksi juga menjadi faktor penting. Pembuatan anime dengan kualitas tinggi membutuhkan waktu yang tidak sedikit, terutama untuk seri dengan standar visual dan storytelling seperti JoJo. Tim produksi masih berfokus pada penyelesaian episode-episode berikutnya agar tetap memenuhi ekspektasi penggemar. Bahkan, pihak produksi sendiri belum memberikan kepastian mengenai timeline penayangan lanjutan.\r\n\r\nKondisi ini membuat penggemar harus bersabar menunggu kabar resmi selanjutnya. Meskipun demikian, banyak yang meyakini bahwa penundaan ini dilakukan demi menjaga kualitas cerita dan animasi agar tetap maksimal.', 'Anime JoJo\'s Bizarre Adventure: Steel Ball Run menjadi sorotan sejak penayangan episode pertamanya. Namun, hingga kini episode kedua belum juga dirilis karena belum adanya jadwal resmi serta proses produksi yang masih berlangsung.', '1775368821_69d1fa753bb4b.png', 13, 1, '2026-04-05 00:32:15', 18, 0, 'published'),
(13, 'Festival Hanami di Jepang: Tradisi Menikmati Sakura yang Tetap Populer', 'festival-hanami', 'Tradisi Hanami merupakan salah satu budaya paling ikonik di Jepang yang terus bertahan hingga saat ini. Secara harfiah, “hanami” berarti melihat bunga, yang merujuk pada kegiatan menikmati keindahan bunga sakura saat mekar di musim semi.\r\n\r\nTradisi ini sudah ada sejak periode Nara (710–794), yang awalnya hanya dinikmati oleh kalangan bangsawan. Seiring waktu, terutama pada periode Heian, hanami berkembang menjadi festival yang bisa dinikmati oleh seluruh masyarakat Jepang.\r\n\r\nSaat musim sakura tiba, taman-taman di kota seperti Tokyo, Kyoto, dan Osaka dipenuhi oleh orang-orang yang berkumpul bersama keluarga, teman, atau rekan kerja. Mereka biasanya mengadakan piknik di bawah pohon sakura, menikmati makanan, minuman, serta suasana musim semi yang hangat.\r\n\r\nHanami tidak hanya sekadar menikmati keindahan alam, tetapi juga memiliki makna filosofis. Mekarnya bunga sakura yang hanya berlangsung singkat melambangkan kehidupan yang indah namun sementara. Karena itu, tradisi ini juga menjadi momen refleksi untuk menghargai setiap waktu yang dimiliki.\r\n\r\nSelain itu, festival hanami juga identik dengan berbagai aktivitas seperti pesta kecil, menikmati makanan khas musim semi, hingga melihat iluminasi sakura di malam hari atau yang dikenal sebagai yozakura.\r\n\r\nDengan perpaduan antara keindahan alam dan nilai budaya, hanami tetap menjadi salah satu tradisi Jepang yang paling dinantikan setiap tahunnya, baik oleh masyarakat lokal maupun wisatawan dari seluruh dunia.', 'Tradisi Hanami kembali menjadi sorotan saat musim semi di Japan. Festival ini menghadirkan kegiatan menikmati bunga sakura sambil berkumpul, makan, dan merayakan kebersamaan.', '1775374229_69d20f955b2a1.webp', 10, 1, '2026-04-05 14:28:12', 15, 0, 'published'),
(14, 'Ichiran Ramen Rilis Lucky Bag, Paket Kuliner Jepang yang Menarik Perhatian', 'ichiran-ramen', 'Restoran ramen populer Ichiran kembali menarik perhatian dengan merilis lucky bag atau fukubukuro, paket spesial yang dijual saat tahun baru di Jepang. Paket ini dikenal karena berisi berbagai produk dengan nilai lebih tinggi dibandingkan harga jualnya.\r\n\r\nIchiran sendiri terkenal dengan ramen tonkotsu khasnya serta konsep makan unik berupa bilik individu, di mana pelanggan dapat menikmati makanan tanpa gangguan. Konsep ini membuat pengalaman makan menjadi lebih fokus pada rasa.\r\n\r\nDalam edisi terbaru, Ichiran menawarkan beberapa jenis lucky bag dengan harga berbeda, mulai dari ukuran kecil hingga besar. Setiap paket berisi berbagai produk seperti mie ramen, kuah khas, hingga merchandise eksklusif yang tidak dijual secara terpisah.\r\n\r\nTradisi fukubukuro sendiri merupakan bagian dari budaya Jepang saat tahun baru, di mana perusahaan menjual paket misteri dengan isi yang dirahasiakan. Konsep ini memberikan sensasi kejutan bagi pembeli sekaligus nilai ekonomis yang tinggi.\r\n\r\nPopularitas lucky bag Ichiran tidak lepas dari reputasi restoran ini yang memang sudah dikenal luas. Bahkan, antrean panjang sering terlihat di berbagai cabangnya karena tingginya minat pelanggan terhadap ramen khas mereka.\r\n\r\nDengan kombinasi antara tradisi, inovasi, dan kualitas rasa, Ichiran berhasil menjadikan lucky bag sebagai salah satu produk yang dinantikan oleh penggemar kuliner Jepang setiap tahunnya.', 'Restoran Ichiran merilis paket lucky bag berisi berbagai produk ramen dengan harga menarik. Paket ini menjadi bagian dari tradisi tahun baru Jepang sekaligus daya tarik bagi penggemar kuliner.', '1775374326_69d20ff62d793.webp', 9, 1, '2026-04-05 14:29:07', 6, 0, 'published'),
(15, 'Kyushu, Permata Tersembunyi Jepang: Rute 7 Hari Penuh Keajaiban', 'kyushu-permata-tersembunyi-jepang', 'Pulau Kyushu semakin menarik perhatian sebagai destinasi wisata alternatif di Jepang. Berbeda dengan kota besar seperti Tokyo atau Osaka, Kyushu menawarkan pengalaman yang lebih tenang dengan perpaduan alam yang dramatis, sejarah yang kuat, serta kuliner khas yang menggugah selera.\r\n\r\nPerjalanan biasanya dimulai dari Fukuoka, kota terbesar di Kyushu yang menjadi pintu gerbang utama kawasan selatan Jepang. Di sini, wisatawan dapat menikmati suasana modern sekaligus mencicipi kuliner khas seperti ramen di yatai atau kedai kaki lima yang berada di tepi sungai.\r\n\r\nPerjalanan kemudian berlanjut ke Kagoshima dan Miyazaki yang menawarkan nuansa sejarah samurai serta keindahan alam. Salah satu destinasi menarik adalah Obi Castle Town yang masih mempertahankan suasana Jepang era feodal. Selain itu, pengalaman unik seperti perjalanan dengan kereta wisata di Takachiho juga menjadi daya tarik tersendiri.\r\n\r\nDi wilayah Kumamoto, wisatawan dapat mengunjungi Kumamoto Castle yang menjadi simbol ketangguhan sejarah Jepang. Tidak jauh dari sana, terdapat kawasan Gunung Aso yang menawarkan pemandangan gunung berapi aktif serta hamparan alam yang luas dan menakjubkan.\r\n\r\nPerjalanan berlanjut ke Nagasaki, kota pelabuhan yang memiliki sejarah panjang sebagai pintu masuk budaya asing ke Jepang. Wisatawan dapat menikmati panorama kota dari ketinggian serta mengunjungi kawasan Unzen yang terkenal dengan aktivitas geotermalnya.\r\n\r\nSelain itu, kawasan Sasebo dengan gugusan pulau kecilnya juga menjadi destinasi yang menawarkan pemandangan laut yang menenangkan. Aktivitas seperti berlayar mengelilingi pulau-pulau tersebut menjadi pengalaman wisata yang unik dan berkesan.\r\n\r\nDi hari terakhir, wisatawan kembali ke Fukuoka untuk menikmati destinasi seperti kuil Dazaifu Tenmangu serta pengalaman menyusuri kanal di Yanagawa. Perjalanan ini ditutup dengan suasana santai khas Jepang yang memberikan kesan mendalam sebelum kembali pulang.\r\n\r\nSecara keseluruhan, Kyushu menawarkan pengalaman wisata yang lengkap mulai dari budaya, sejarah, hingga keindahan alam. Dengan rute perjalanan yang terstruktur selama tujuh hari, destinasi ini menjadi pilihan tepat bagi wisatawan yang ingin menjelajahi sisi lain Jepang yang belum terlalu ramai.', 'Pulau Kyushu menjadi destinasi wisata alternatif di Japan dengan kombinasi alam, sejarah, dan kuliner. Rute perjalanan 7 hari ini menghadirkan pengalaman lengkap mulai dari Fukuoka hingga Nagasaki.', '1775382060_69d22e2c65b8e.webp', 5, 1, '2026-04-05 16:40:03', 7, 0, 'published'),
(16, 'Gundam Cosmic Light, Figure Unik dengan Efek LED yang Bisa Jadi Lampu Kamar', 'gundam-cosmic-light-figure', 'Bandai menghadirkan inovasi menarik di dunia merchandise anime melalui seri Gundam Cosmic Light. Berbeda dari figure pada umumnya, produk ini tidak hanya menampilkan detail karakter, tetapi juga dilengkapi dengan pencahayaan LED yang memberikan efek visual unik.\r\n\r\nFigure ini dibuat menggunakan plastik transparan sehingga cahaya dari LED pada bagian dasar dapat menyinari seluruh tubuh figure. Efek tersebut menciptakan tampilan yang menyerupai aura bercahaya seperti yang sering terlihat dalam anime Gundam.\r\n\r\nSetiap figure memiliki tinggi sekitar 70 mm dan hadir dalam beberapa varian populer seperti ν Gundam, Zeta Gundam, Qubeley, dan Qubeley Mk-II. Keempat model ini dirancang dengan detail yang tetap mempertahankan ciri khas masing-masing mecha.\r\n\r\nSelain tampilannya yang menarik, figure ini juga memiliki fleksibilitas dalam display. Pengguna dapat menampilkan figure dalam posisi berdiri maupun pose melayang dengan bantuan penyangga. Bahkan, beberapa unit LED dapat digabungkan untuk menciptakan efek pencahayaan yang lebih luas dan dramatis.\r\n\r\nProduk ini pertama kali dirilis oleh Bandai pada November 2014 sebagai bagian dari lini candy toy, yaitu produk mainan yang dijual bersama permen. Meskipun tergolong kecil, konsep inovatifnya membuat seri ini cukup menarik perhatian kolektor maupun penggemar Gundam.\r\n\r\nDengan kombinasi antara desain figure dan teknologi pencahayaan, Gundam Cosmic Light menjadi contoh bagaimana merchandise anime terus berkembang, tidak hanya sebagai koleksi, tetapi juga sebagai elemen dekorasi yang fungsional.', 'Seri figure Gundam Cosmic Light menghadirkan konsep unik dengan tambahan LED yang membuat figure Gundam dapat menyala dan berfungsi sebagai dekorasi sekaligus lampu kamar.', '1775382351_69d22f4f1ec5e.jpg', 7, 1, '2026-04-05 16:45:51', 5, 0, 'published'),
(17, 'Film Live Action 5 Centimeters Per Second Siap Tayang, Dibintangi Mitsuki Takahata dan Hokuto Matsumura', 'film-live-action-5-centimeters-per-second', 'Film 5 Centimeters Per Second akhirnya hadir dalam versi live action setelah sebelumnya dikenal sebagai salah satu anime romance paling ikonik. Karya asli dari Makoto Shinkai ini pertama kali dirilis sebagai anime pada tahun 2007 dan mendapat banyak pujian berkat cerita yang emosional serta visual yang khas.\r\n\r\nDalam versi live action, cerita klasik tersebut dihidupkan kembali dengan pendekatan baru namun tetap mempertahankan inti kisah tentang jarak, waktu, dan cinta yang tak tersampaikan. Film ini dibintangi oleh Hokuto Matsumura sebagai Takaki dan Mitsuki Takahata sebagai Akari.\r\n\r\nKabar baiknya, film ini dijadwalkan tayang di bioskop Indonesia mulai 30 Januari 2026. Sebelumnya, film ini telah melakukan penayangan perdana di ajang internasional dan juga telah dirilis di Jepang pada tahun 2025.\r\n\r\nDisutradarai oleh Yoshiyuki Okuyama, film ini menghadirkan sudut pandang baru dalam menceritakan hubungan antara dua karakter utama yang terpisah oleh jarak dan waktu. Cerita dibagi dalam beberapa fase kehidupan, mulai dari masa kecil, remaja, hingga dewasa, yang menggambarkan bagaimana hubungan mereka berubah seiring berjalannya waktu.\r\n\r\nMenariknya, sang kreator asli, Makoto Shinkai, memberikan tanggapan emosional terhadap adaptasi ini. Ia mengaku sempat merasa ragu di awal, namun akhirnya terhanyut oleh cerita hingga merasa terharu saat menontonnya. Hal ini menunjukkan bahwa versi live action tetap mampu menyampaikan emosi yang kuat seperti versi animenya.\r\n\r\nDengan pendekatan visual yang realistis dan cerita yang tetap menyentuh, film ini diharapkan dapat menarik perhatian baik penggemar lama maupun penonton baru. Adaptasi ini juga menjadi bukti bahwa karya anime dapat terus berkembang dan dihadirkan kembali dalam format berbeda tanpa kehilangan esensi utamanya.', 'Film 5 Centimeters Per Second versi live action siap tayang di Indonesia pada 2026. Adaptasi dari karya legendaris Makoto Shinkai ini dibintangi oleh Hokuto Matsumura dan Mitsuki Takahata.', '1775382773_69d230f58d343.jpeg', 3, 1, '2026-04-05 16:52:53', 5, 0, 'published'),
(18, 'AnimeJapan Kembali Digelar di Tokyo, Event Anime Terbesar Siap Hadirkan Banyak Kejutan', 'animejapan-kembali-digelar-di-tokyo', 'Event tahunan AnimeJapan kembali diselenggarakan dan menjadi salah satu konvensi anime terbesar di dunia. Acara ini biasanya berlangsung di Tokyo Big Sight dan menghadirkan berbagai perusahaan besar di industri anime, mulai dari studio animasi hingga publisher ternama.\r\n\r\nAnimeJapan dikenal sebagai pusat pengumuman penting terkait anime. Dalam event ini, banyak judul baru diumumkan, trailer perdana ditampilkan, serta informasi terbaru mengenai proyek anime yang sedang dikembangkan. Hal ini menjadikan AnimeJapan sebagai ajang yang sangat dinantikan oleh penggemar setiap tahunnya.\r\n\r\nBerdasarkan informasi dari Tokyo Cheapo, event ini biasanya berlangsung selama beberapa hari dengan pembagian antara hari bisnis dan hari publik. Pada hari publik, pengunjung dapat menikmati berbagai booth interaktif, pameran, serta membeli merchandise resmi dari anime favorit mereka.\r\n\r\nSelain itu, AnimeJapan juga menghadirkan panggung khusus yang menampilkan talk show, presentasi, hingga penampilan dari pengisi suara atau kreator anime. Kehadiran tokoh-tokoh penting dalam industri ini menjadi daya tarik tersendiri bagi para penggemar.\r\n\r\nTidak hanya itu, event ini juga menjadi tempat berkumpulnya komunitas anime dari berbagai negara. Banyak pengunjung yang datang untuk merasakan langsung atmosfer budaya pop Jepang, sekaligus mengikuti perkembangan terbaru dari industri anime global.\r\n\r\nDengan skala yang besar dan konten yang beragam, AnimeJapan terus mempertahankan posisinya sebagai salah satu event paling berpengaruh di dunia anime. Setiap tahunnya, event ini selalu menghadirkan inovasi dan kejutan yang membuat penggemar semakin antusias menantikannya.', 'Event AnimeJapan kembali digelar di Tokyo dan menjadi ajang terbesar bagi industri anime untuk menghadirkan pengumuman terbaru, pameran, serta berbagai aktivitas menarik bagi penggemar.', '1775383473_69d233b166e30.jpg', 6, 1, '2026-04-05 17:04:33', 3, 0, 'published'),
(19, 'Jepang Usulkan Aturan Hak Cipta Cosplay, Ini Tanggapan Enako', 'jepang-usulkan-aturan-hak-cipta-cosplay', 'Isu mengenai hak cipta dalam dunia cosplay kembali menjadi perhatian setelah pemerintah Japan mengusulkan peninjauan aturan terkait aktivitas tersebut. Langkah ini dilakukan untuk mengurangi ambiguitas hukum yang selama ini berada di area abu-abu antara fan activity dan pelanggaran hak cipta.\r\n\r\nSecara umum, aktivitas cosplay non-profit tidak dianggap melanggar hak cipta. Namun, masalah mulai muncul ketika cosplay digunakan untuk tujuan komersial, seperti mendapatkan bayaran dari event, menjual photobook, atau konten berbayar di platform tertentu. Dalam kondisi tersebut, cosplayer berpotensi melanggar hak cipta jika tidak memiliki izin dari pemegang lisensi.\r\n\r\nPemerintah Jepang sendiri tidak berencana membuat aturan yang terlalu ketat. Sebaliknya, mereka ingin memberikan panduan yang lebih jelas mengenai situasi apa saja yang bisa dianggap melanggar, sekaligus tetap menjaga perkembangan budaya cosplay agar tidak terhambat.\r\n\r\nDalam proses ini, pemerintah juga melibatkan berbagai pihak, termasuk cosplayer profesional seperti Enako yang dikenal sebagai salah satu figur penting dalam industri cosplay Jepang. Ia bahkan ditunjuk sebagai bagian dari inisiatif “Cool Japan” untuk membantu menjembatani komunikasi antara pemerintah dan komunitas cosplay.\r\n\r\nMenanggapi isu tersebut, Enako menyatakan bahwa masih banyak kesalahpahaman yang beredar terkait aturan baru ini. Ia menegaskan bahwa tujuan utama dari pembahasan ini adalah untuk melindungi hak cipta tanpa merusak budaya cosplay yang sudah berkembang. Ia juga berharap aktivitas non-profit seperti unggahan di media sosial tetap dapat berjalan seperti biasa.\r\n\r\nSelain itu, Enako juga mengungkapkan bahwa dalam praktik profesional, ia selalu berhati-hati terhadap hak cipta. Jika tampil dalam acara komersial, ia cenderung menggunakan kostum original atau memastikan telah mendapatkan izin resmi dari pemegang hak cipta.\r\n\r\nHingga saat ini, aturan tersebut masih dalam tahap diskusi dan belum diresmikan. Banyak pihak berharap kebijakan yang dihasilkan nantinya dapat menciptakan keseimbangan antara perlindungan kreator dan kebebasan berekspresi bagi para cosplayer.', 'Pemerintah Japan mengusulkan peninjauan aturan hak cipta terkait cosplay untuk mengurangi ambiguitas hukum. Cosplayer terkenal Enako turut memberikan tanggapan terkait isu ini.', '1775396369_69d2661153567.jpg', 8, 1, '2026-04-05 20:39:29', 1, 0, 'published'),
(20, 'LiSA Rilis MV Baru “DECOTORA15”, Bagian dari Album Terbaru', 'lisa-rilis-mv-baru-decotora15', 'Penyanyi populer Jepang LiSA kembali merilis karya terbaru melalui music video berjudul “DECOTORA15”. Lagu ini resmi dirilis pada awal April 2026 bersamaan dengan video musiknya yang langsung menarik perhatian penggemar.\r\n\r\n“DECOTORA15” menjadi salah satu lagu dalam album ketujuh LiSA yang berjudul LACE UP, yang dijadwalkan rilis pada 15 April 2026. Perilisan ini menandai kelanjutan perjalanan karier LiSA sebagai salah satu penyanyi J-Pop paling berpengaruh, terutama di kalangan penggemar anime.\r\n\r\nMusic video yang dirilis menampilkan konsep visual yang kuat dan khas, dengan gaya yang enerjik serta penuh warna. Judul “DECOTORA” sendiri terinspirasi dari truk dekorasi khas Jepang yang dikenal dengan lampu mencolok dan desain unik, sehingga memberikan nuansa visual yang berbeda dari karya sebelumnya.\r\n\r\nSebagai artis yang dikenal luas melalui lagu-lagu anime seperti “Gurenge”, LiSA terus menunjukkan konsistensinya dalam menghadirkan karya yang menarik baik dari segi musik maupun visual.\r\n\r\nPerilisan MV ini juga menjadi bagian dari perayaan perjalanan karier LiSA yang telah mencapai berbagai pencapaian besar di industri musik Jepang. Dengan hadirnya “DECOTORA15”, LiSA kembali memperkuat posisinya sebagai salah satu ikon J-Pop modern.', 'Penyanyi J-Pop LiSA merilis music video terbaru berjudul “DECOTORA15” yang menjadi bagian dari album ketujuhnya, LACE UP, yang dijadwalkan rilis pada April 2026.', '1775405013_69d287d57a0fd.png', 2, 1, '2026-04-05 23:03:33', 2, 0, 'published'),
(21, 'Fakta Menarik Yoru, War Devil di Chainsaw Man', 'fakta-menarik-yoru', 'Karakter Yoru menjadi salah satu tokoh yang menarik perhatian dalam seri Chainsaw Man. Yoru dikenal sebagai War Devil, salah satu iblis yang merepresentasikan konsep perang, yang membuatnya memiliki kekuatan besar dan berbahaya.\r\n\r\nYoru pertama kali muncul dengan mengambil alih tubuh seorang manusia, yaitu Asa Mitaka. Hubungan antara Yoru dan Asa menjadi salah satu aspek menarik dalam cerita, karena keduanya harus berbagi tubuh dan bekerja sama meskipun memiliki tujuan yang berbeda.\r\n\r\nSebagai War Devil, Yoru memiliki kemampuan unik untuk mengubah objek menjadi senjata. Kekuatan ini bergantung pada rasa kepemilikan atau keterikatan emosional terhadap objek tersebut. Semakin kuat ikatan tersebut, semakin kuat pula senjata yang dihasilkan. \r\n\r\nMenariknya, Yoru memiliki tujuan besar untuk mengalahkan Chainsaw Man. Hal ini membuatnya terlibat langsung dalam konflik utama cerita dan menambah kompleksitas alur yang sudah penuh dengan intrik.\r\n\r\nSelain kekuatannya, kepribadian Yoru juga menjadi daya tarik tersendiri. Ia digambarkan sebagai sosok yang serius, dingin, dan memiliki ambisi kuat, namun terkadang menunjukkan sisi yang tidak terduga ketika berinteraksi dengan Asa.\r\n\r\nDengan kombinasi kekuatan unik, latar belakang misterius, dan hubungan karakter yang kompleks, Yoru menjadi salah satu karakter yang paling menarik dalam perkembangan cerita Chainsaw Man.', 'Karakter Yoru dalam Chainsaw Man menjadi sorotan karena perannya sebagai War Devil. Ia memiliki kekuatan unik dan hubungan penting dengan karakter utama.', '1775406175_69d28c5f7ab5e.webp', 13, 1, '2026-04-05 23:22:55', 1, 0, 'published');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `slug`, `created_at`) VALUES
(2, 'J-Pop & Idols', 'jpop-idols', '2026-04-04 02:44:09'),
(3, 'Movies & TV Shows', 'movie-tvshow', '2026-04-04 02:44:09'),
(4, 'Games', 'games', '2026-04-04 02:44:09'),
(5, 'Travel & Places', 'travel-places', '2026-04-04 02:44:09'),
(6, 'Events', 'event', '2026-04-04 02:44:09'),
(7, 'Figure & Merch', 'figure-merch', '2026-04-04 02:44:09'),
(8, 'Cosplay', 'cosplay', '2026-04-04 02:44:09'),
(9, 'Food & Culinary', 'food-culinary', '2026-04-04 02:44:09'),
(10, 'Japanese Culture', 'culture', '2026-04-04 02:44:09'),
(13, 'Anime & Manga', 'anime-manga', '2026-04-05 13:56:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@nekoverse.com', '2026-04-04 02:44:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_penulis` (`id_penulis`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `artikel_ibfk_2` FOREIGN KEY (`id_penulis`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
