<?php

namespace App\Support;

class IconCatalog
{
    public static function popular(): array
    {
        return [
            self::item('fab fa-instagram', 'Instagram', 'Sosyal medya, reels ve profil linkleri', 'instagram sosyal medya reels profil'),
            self::item('fab fa-twitter', 'Twitter / X', 'Tweet, X ve profil baglantilari', 'twitter x sosyal medya kus tweet'),
            self::item('fab fa-youtube', 'YouTube', 'Kanal, shorts ve video baglantilari', 'youtube kanal video shorts'),
            self::item('fab fa-tiktok', 'TikTok', 'Video ve profil paylasimlari', 'tiktok video sosyal medya'),
            self::item('fab fa-whatsapp', 'WhatsApp', 'Mesaj, destek ve siparis linkleri', 'whatsapp mesaj iletisim destek'),
            self::item('fab fa-linkedin', 'LinkedIn', 'CV, kariyer ve profesyonel profil', 'linkedin kariyer cv is profesyonel'),
            self::item('fab fa-github', 'GitHub', 'Kod, repo ve yazilim projeleri', 'github repo kod yazilim gelistirme'),
            self::item('fab fa-telegram', 'Telegram', 'Kanal, grup ve mesajlasma', 'telegram kanal grup mesaj'),
            self::item('fab fa-facebook', 'Facebook', 'Sayfa, grup ve sosyal medya', 'facebook sayfa grup sosyal medya'),
            self::item('fab fa-spotify', 'Spotify', 'Muzik, podcast ve playlist', 'spotify muzik podcast calisma listesi'),
            self::item('fab fa-discord', 'Discord', 'Topluluk ve sunucu daveti', 'discord topluluk sunucu gamer'),
            self::item('fab fa-twitch', 'Twitch', 'Canli yayin ve yayinci linkleri', 'twitch yayin canli stream'),
            self::item('fab fa-pinterest', 'Pinterest', 'Panolar ve ilham koleksiyonlari', 'pinterest pano tasarim ilham'),
            self::item('fab fa-snapchat', 'Snapchat', 'Hikaye ve sosyal medya profili', 'snapchat hikaye sosyal medya'),
            self::item('fab fa-reddit', 'Reddit', 'Topluluk, konu ve forum linkleri', 'reddit topluluk forum konu'),
            self::item('fab fa-medium', 'Medium', 'Yazi ve blog makaleleri', 'medium yazi blog makale'),
            self::item('fab fa-behance', 'Behance', 'Portfolyo ve tasarim sunumlari', 'behance portfolyo tasarim'),
            self::item('fab fa-dribbble', 'Dribbble', 'UI ve grafik tasarim paylasimlari', 'dribbble tasarim ui grafik'),
            self::item('fab fa-figma', 'Figma', 'Arayuz ve prototip dosyalari', 'figma arayuz prototip tasarim'),
            self::item('fab fa-gitlab', 'GitLab', 'Yazilim depolari ve CI akisleri', 'gitlab repo kod devops'),
            self::item('fab fa-stack-overflow', 'Stack Overflow', 'Yazilim soru cevap toplulugu', 'stack overflow soru cevap yazilim'),
            self::item('fab fa-soundcloud', 'SoundCloud', 'Ses ve muzik paylasimlari', 'soundcloud ses muzik audio'),
            self::item('fab fa-paypal', 'PayPal', 'Odeme ve tahsilat linkleri', 'paypal odeme para tahsilat'),
            self::item('fab fa-amazon', 'Amazon', 'Pazar yeri ve urun baglantilari', 'amazon pazar yeri urun magaza'),
            self::item('fab fa-google', 'Google', 'Servis, dokuman ve harita linkleri', 'google servis arama dokuman'),
            self::item('fab fa-apple', 'Apple', 'App Store ve ekosistem linkleri', 'apple app store ios mac'),
            self::item('fab fa-slack', 'Slack', 'Ekip ici iletisim ve topluluk', 'slack ekip iletisim is'),
            self::item('fab fa-skype', 'Skype', 'Arama ve gorusme linkleri', 'skype arama gorusme toplanti'),
            self::item('fab fa-chrome', 'Chrome', 'Tarayici, uzanti ve web uygulamalari', 'chrome tarayici web uzanti'),
            self::item('fab fa-firefox-browser', 'Firefox', 'Tarayici ve web sayfasi baglantilari', 'firefox tarayici web'),
            self::item('fas fa-link', 'Link', 'Genel baglanti ve yonlendirme', 'link baglanti url web'),
            self::item('fas fa-globe', 'Web Sitesi', 'Kurumsal veya kisisel web sayfasi', 'web sitesi site internet'),
            self::item('fas fa-envelope', 'E-posta', 'Mail ve iletisim adresleri', 'eposta email mail iletisim'),
            self::item('fas fa-phone', 'Telefon', 'Arama ve telefon ile ulasim', 'telefon arama iletisim'),
            self::item('fas fa-message', 'Mesaj', 'DM, form veya sohbet baglantilari', 'mesaj dm sohbet chat'),
            self::item('fas fa-paper-plane', 'Gonder', 'Form gonderme ve iletme aksiyonu', 'gonder ilet form paper plane'),
            self::item('fas fa-location-dot', 'Konum', 'Harita ve lokasyon baglantisi', 'konum lokasyon harita adres'),
            self::item('fas fa-map-location-dot', 'Harita', 'Adres ve rota baglantilari', 'harita rota adres lokasyon'),
            self::item('fas fa-calendar-days', 'Takvim', 'Etkinlik ve randevu linkleri', 'takvim etkinlik randevu'),
            self::item('fas fa-clock', 'Saat', 'Zaman, sure ve program akislari', 'saat zaman sure program'),
            self::item('fas fa-camera', 'Kamera', 'Foto cekim ve kamera icerigi', 'kamera fotograf cekim'),
            self::item('fas fa-image', 'Gorsel', 'Gorsel galeri ve medya baglantilari', 'gorsel resim fotograf galeri'),
            self::item('fas fa-video', 'Video', 'Video oynatma ve medya icerigi', 'video medya izleme'),
            self::item('fas fa-film', 'Film', 'Sinema ve video koleksiyonlari', 'film sinema video'),
            self::item('fas fa-music', 'Muzik', 'Muzik ve dinleme icerikleri', 'muzik sarki audio'),
            self::item('fas fa-headphones', 'Kulaklik', 'Muzik, podcast ve audio', 'kulaklik muzik podcast audio'),
            self::item('fas fa-microphone', 'Mikrofon', 'Kayit ve ses icerikleri', 'mikrofon kayit ses podcast'),
            self::item('fas fa-radio', 'Yayin', 'Canli ses ve radyo icerikleri', 'radyo yayin ses canli'),
            self::item('fas fa-book-open', 'Kitap', 'Dokuman, ebook ve kaynaklar', 'kitap dokuman ebook kaynak'),
            self::item('fas fa-graduation-cap', 'Egitim', 'Kurs ve egitim materyalleri', 'egitim kurs okul ogrenme'),
            self::item('fas fa-briefcase', 'Is', 'Is, hizmet ve profesyonel profiller', 'is hizmet profesyonel'),
            self::item('fas fa-building', 'Sirket', 'Firma ve kurumsal sayfalar', 'sirket firma kurumsal'),
            self::item('fas fa-store', 'Magaza', 'Satis ve vitrin sayfalari', 'magaza satis vitrin dukkan'),
            self::item('fas fa-cart-shopping', 'Sepet', 'Alisveris ve satin alma', 'sepet alisveris satin al'),
            self::item('fas fa-bag-shopping', 'Alisveris', 'Urun ve katalog baglantilari', 'alisveris urun katalog'),
            self::item('fas fa-box-open', 'Kutu', 'Paket ve urun teslimatlari', 'kutu paket urun teslimat'),
            self::item('fas fa-gift', 'Hediye', 'Kampanya ve promosyon linkleri', 'hediye promosyon kampanya'),
            self::item('fas fa-star', 'Yildiz', 'One cikan ve favori icerikler', 'yildiz favori populer one cikan'),
            self::item('fas fa-heart', 'Kalp', 'Begeni ve sevilen icerikler', 'kalp begeni favori'),
            self::item('fas fa-thumbs-up', 'Begeni', 'Onay ve tavsiye icerikleri', 'begeni like onay tavsiye'),
            self::item('fas fa-trophy', 'Odul', 'Basari, odul ve kazanimlar', 'odul basari kupa'),
            self::item('fas fa-gem', 'Premium', 'Ozel, premium ve ust seviye icerikler', 'premium ozel luks'),
            self::item('fas fa-bolt', 'Hizli', 'Hizli erisim ve guclu vurgu', 'hizli bolt enerji'),
            self::item('fas fa-lightbulb', 'Fikir', 'Ilham, fikir ve icgoru icerikleri', 'fikir ilham ipucu'),
            self::item('fas fa-rocket', 'Lansman', 'Yeni urun ve baslangic duyurulari', 'roket lansman baslangic startup'),
            self::item('fas fa-code', 'Kod', 'Kod, API ve gelistirme linkleri', 'kod yazilim api gelistirme'),
            self::item('fas fa-laptop-code', 'Yazilim', 'Yazilim urunleri ve projeler', 'laptop kod yazilim bilgisayar'),
            self::item('fas fa-desktop', 'Masaustu', 'Uygulama ve panel ekranlari', 'masaustu bilgisayar ekran'),
            self::item('fas fa-mobile-screen', 'Mobil', 'Mobil uygulama ve cihaz baglantilari', 'mobil telefon cihaz'),
            self::item('fas fa-tablet-screen-button', 'Tablet', 'Tablet ve orta ekran icerikleri', 'tablet cihaz ekran'),
            self::item('fas fa-gamepad', 'Oyun', 'Oyun topluluklari ve urunleri', 'oyun game gamer'),
            self::item('fas fa-palette', 'Tasarim', 'Renk, marka ve tasarim sayfalari', 'tasarim renk marka'),
            self::item('fas fa-pen', 'Yazi', 'Yazi, not ve icerik baglantilari', 'yazi not icerik kalem'),
            self::item('fas fa-pen-ruler', 'UI Tasarim', 'Cizim, arayuz ve prototipler', 'ui tasarim cizim cetvel'),
            self::item('fas fa-pencil', 'Duzenle', 'Duzenleme ve metin icerikleri', 'duzenle metin kalem'),
            self::item('fas fa-scissors', 'Klip', 'Kurgu ve kesim icerikleri', 'makas kurgu kesim'),
            self::item('fas fa-wrench', 'Arac', 'Servis ve teknik destek baglantilari', 'arac servis teknik destek'),
            self::item('fas fa-hammer', 'Yapi', 'Insaat, uretim ve el isi linkleri', 'cekic yapi uretim el isi'),
            self::item('fas fa-gear', 'Ayar', 'Ayar, konfig ve sistem linkleri', 'ayar config sistem'),
            self::item('fas fa-shield-halved', 'Guvenlik', 'Guvenlik, dogrulama ve koruma', 'guvenlik dogrulama koruma'),
            self::item('fas fa-lock', 'Kilit', 'Gizli veya ozel icerikler', 'kilit gizli ozel sifre'),
            self::item('fas fa-key', 'Anahtar', 'Erisim, lisans ve aktivasyon', 'anahtar lisans erisim'),
            self::item('fas fa-user', 'Kisi', 'Kisisel profil ve bireysel tanitim', 'kisi bireysel profil'),
            self::item('fas fa-users', 'Topluluk', 'Ekip, topluluk ve uyelikler', 'topluluk ekip uyelik grup'),
            self::item('fas fa-id-card', 'Kart', 'Dijital kartvizit ve tanitim', 'kart kartvizit tanitim'),
            self::item('fas fa-address-card', 'Profil', 'Profil ve kimlik karti icerikleri', 'profil kimlik kart'),
            self::item('fas fa-qrcode', 'QR Kod', 'QR yonlendirme ve tarama baglantilari', 'qr kod tarama'),
            self::item('fas fa-barcode', 'Barkod', 'Urun kodu ve takip sistemleri', 'barkod urun takip'),
            self::item('fas fa-magnifying-glass', 'Arama', 'Arama, kesif ve filtreleme', 'arama bul kesif'),
            self::item('fas fa-chart-line', 'Grafik', 'Buyume ve performans raporlari', 'grafik buyume performans'),
            self::item('fas fa-chart-pie', 'Pasta Grafik', 'Dagilim ve analiz raporlari', 'pasta grafik analiz rapor'),
            self::item('fas fa-chart-column', 'Istatistik', 'Rapor, KPI ve sayisal veriler', 'istatistik rapor veri grafik'),
            self::item('fas fa-bullhorn', 'Duyuru', 'Duyuru, kampanya ve haberler', 'duyuru kampanya haber'),
            self::item('fas fa-bell', 'Bildirim', 'Hatirlatma ve bildirimler', 'bildirim alarm hatirlatma'),
            self::item('fas fa-wallet', 'Cuzdan', 'Odeme ve bakiye baglantilari', 'cuzdan odeme bakiye'),
            self::item('fas fa-credit-card', 'Kart Odeme', 'Kart ile tahsilat ve abonelik', 'kart odeme abonelik'),
            self::item('fas fa-money-bill-wave', 'Para', 'Tahsilat ve fiyat odakli linkler', 'para fiyat tahsilat'),
            self::item('fas fa-tags', 'Etiket', 'Indirim, kampanya ve kategori', 'etiket indirim kampanya kategori'),
            self::item('fas fa-truck', 'Teslimat', 'Kargo ve teslimat baglantilari', 'teslimat kargo lojistik'),
            self::item('fas fa-house', 'Ev', 'Ana sayfa ve temel yonlendirme', 'ev ana sayfa home'),
        ];
    }

    public static function normalizeClass(?string $icon): ?string
    {
        $icon = trim((string) $icon);

        if ($icon === '') {
            return null;
        }

        return match ($icon) {
            'fab fa-x-twitter', 'fa-brands fa-x-twitter' => 'fab fa-twitter',
            default => $icon,
        };
    }

    protected static function item(string $value, string $label, string $hint, string $keywords): array
    {
        return [
            'value' => self::normalizeClass($value),
            'label' => $label,
            'hint' => $hint,
            'keywords' => $keywords,
        ];
    }
}
