# TASK.md

## Proje
BYOO.PRO – Laravel tabanlı bio link / mini profil platformu

## Amaç
Mevcut sistemi, üretime uygun, tamamen Türkçeleştirilmiş, görsel olarak güçlü, kullanıcı ve süper admin rolleri net ayrılmış, canlı önizleme destekli modern bir SaaS platformuna dönüştürmek.

---

# 1. DAHA ÖNCE TAMAMLANAN / TEKRAR YAPILMAYACAK İŞLER

Bu maddeler yeniden yapılmayacak, sadece korunacak ve gerekiyorsa iyileştirilecektir:

- Sunucu temel kurulumu yapıldı
- Domain yönlendirmesi çalışıyor
- Traefik / HTTPS yapısı kuruldu
- Docker tabanlı servis altyapısı çalışır durumda
- GitHub reposu oluşturuldu:
  - https://github.com/mace2121/byoo-pro
- Git deploy akışı kuruldu
- Proje sunucuda ayağa kaldırıldı
- Laravel tabanlı sistem temel olarak çalışıyor
- Kullanıcı kayıt / giriş altyapısı mevcut
- Temel panel yapısı mevcut
- Tema mantığı için ilk altyapı düşünülmüş durumda
- Sistem şu anda “çalışıyor”, ancak arayüz, akış ve bazı modüller revize edilecek

> Not: Bu aşamada hedef sıfırdan kurulum değil, mevcut sistemi yeniden yapılandırmak ve profesyonel hale getirmektir.

---

# 2. KRİTİK HATALAR

## 2.1 Analizler Sayfası 500 Hatası
- Analizler sayfasındaki 500 error tespit edilecek
- Log kayıtları incelenecek
- Route / controller / query / view kaynaklı hata netleştirilecek
- Hata giderilecek
- Boş veri durumunda sayfa kırılmayacak
- Hatalı veri olduğunda kullanıcı dostu fallback gösterilecek

## 2.2 Profil Görseli / Kırık Link Problemleri
- Kullanıcı profil fotoğrafı yükleyince oluşan kırık görsel linkleri düzeltilecek
- Storage link, disk config, asset path ve upload mantığı kontrol edilecek
- Varsayılan profil görseli fallback olarak eklenecek

---

# 3. PANEL YAPISI – YENİDEN TASARIM

## 3.1 Kullanıcı Dashboard
Mevcut starter kit görünümü kaldırılacak veya büyük ölçüde özelleştirilecek.

### Yeni kullanıcı dashboard alanları:
- Genel bakış kartları
  - Toplam link sayısı
  - Toplam görüntülenme
  - Toplam tıklanma
  - Aktif tema
- Son eklenen linkler
- En çok tıklanan linkler
- Profil durumu
- Tema özeti
- Hızlı işlemler
  - Yeni link ekle
  - Tema düzenle
  - Profil bilgilerini güncelle
  - Analizleri görüntüle

## 3.2 Yönetici / Süper Admin Dashboard
Süper admin alanı oluşturulacak.

### Görebileceği veriler:
- Toplam kullanıcı sayısı
- Aktif / pasif kullanıcılar
- Bugün oluşturulan hesaplar
- Toplam link sayısı
- En çok kullanılan temalar
- En çok trafik alan kullanıcılar
- Sistem genel istatistikleri
- Son kayıt olan kullanıcılar
- Hızlı yönetim bağlantıları

---

# 4. TEMA DÜZENLEME DENEYİMİ

## 4.1 Canlı Önizleme
- Kullanıcının tema değişiklikleri panel içinde canlı önizlenebilmeli
- Telefon mockup kaldırılacak
- Önizleme alanı, Laravel admin panele uyumlu modern bir “preview panel” olarak tasarlanacak
- Sağ veya sol tarafta masaüstü benzeri canlı görünüm olacak
- Değişiklikler anlık yansıyacak

## 4.2 Özelleştirme Alanları
Kullanıcı aşağıdaki ayarları düzenleyebilmeli:
- Tema seçimi
- Ana renk
- Yardımcı renk
- Arka plan rengi
- Arka plan görseli
- Arka plan bulanıklığı
- Kart köşe yuvarlaklığı
- Yazı rengi
- Buton stili
- Link kartı stili
- Font seçimi (ileri faz)
- Özel CSS alanı

## 4.3 Arka Plan Yönetimi
- Görsel yükleme
- Görsel konumlandırma
- Opaklık / blur ayarı
- Overlay desteği

---

# 5. LİNK YÖNETİMİ GELİŞTİRMELERİ

## 5.1 Otomatik İkon Algılama
Bağlantı tipine göre sistem otomatik ikon önermeli:
- Instagram → Instagram ikonu
- WhatsApp → WhatsApp ikonu
- YouTube → YouTube ikonu
- TikTok → TikTok ikonu
- X / Twitter → X ikonu
- Telegram → Telegram ikonu
- Facebook → Facebook ikonu
- LinkedIn → LinkedIn ikonu
- Website / generic → zincir / globe ikonu

## 5.2 Manuel İkon Seçimi
- Kullanıcı isterse otomatik ikonu değiştirebilmeli
- Panelde ikon seçici olmalı
- İkon kütüphanesi düzenli şekilde gösterilmeli
- Seçilen ikon link kartında görünmeli

## 5.3 Link Alanı Geliştirmeleri
- Başlık
- URL
- Açıklama (opsiyonel)
- İkon
- Buton stili
- Sıralama
- Aktif / pasif durumu

---

# 6. TAM TÜRKÇELEŞTİRME

## 6.1 Laravel Starter Kit İngilizce Alanların Temizlenmesi
Sistemde İngilizce kalan hiçbir alan bırakılmayacak.

### Türkçeleştirilecek alanlar:
- Giriş / kayıt / şifre sıfırlama ekranları
- Dashboard alanları
- Validation mesajları
- Buton metinleri
- Menü alanları
- Boş durum metinleri
- Bildirimler
- Profil ayarları
- Auth ekranları
- Tablo başlıkları
- Form placeholder’ları

## 6.2 Dil Standardı
- Resmi ama anlaşılır Türkçe
- Tutarlı terimler kullanılacak
- İngilizce teknik alanlar kullanıcıya gösterilmeyecek

---

# 7. MARKA UYGULAMASI

## 7.1 Sistem Logosu
- Laravel panel üst alanında sistem logosu gösterilecek
- Sol menü / auth ekranları / üst bar ile tutarlı kullanılacak

## 7.2 Favicon
- Favicon, sistem logosundan üretilecek
- Tarayıcı sekmesinde görünecek
- Light / dark uyumu kontrol edilecek

## 7.3 SaaS Marka Bütünlüğü
- Panel, giriş ekranı ve public landing page aynı marka dilini taşımalı

---

# 8. UI / UX İYİLEŞTİRMELERİ

## 8.1 Starter Kit Görünümünden Çıkış
- Varsayılan Laravel starter kit hissi azaltılacak
- Kutular, spacing, renk sistemi ve tipografi yeniden ele alınacak

## 8.2 Panel Tasarım Hedefi
- Modern SaaS görünüm
- Daha güçlü kart sistemi
- Daha iyi boşluk kullanımı
- Daha net görsel hiyerarşi
- Kullanıcı dostu form deneyimi
- Hover / active / empty state tasarımı
- Responsive ama öncelik desktop admin deneyimi

## 8.3 Ortak Bileşenler
- Kartlar
- İstatistik widget’ları
- Tablo bileşenleri
- İkon butonları
- Form alanları
- Sekmeli ayar ekranları
- Toast / bildirim sistemi

---

# 9. SÜPER ADMIN MODÜLÜ

## 9.1 Roller
- Kullanıcı
- Admin / Süper Admin

## 9.2 Süper Admin Yetkileri
- Tüm kullanıcıları görüntüleme
- Kullanıcı profillerini inceleme
- Kullanıcı istatistiklerini görüntüleme
- Kullanıcıları aktif / pasif yapma
- Tema kullanım istatistiklerini görüntüleme
- Genel sistem istatistikleri
- Gerekirse kullanıcıya müdahale araçları

---

# 10. LANDING PAGE / ANA SAYFA

Daha önce belirtilen şekilde:
- byoo.pro açıldığında Laravel starter kit görünümü değil
- Türkçe SaaS tanıtım sayfası açılmalı

### Bu sayfada bulunacak:
- Hero alanı
- Kısa değer önerisi
- Özellikler
- Tema örnekleri
- Kullanım adımları
- SSS
- Kayıt ol / giriş yap CTA alanları

> Eğer landing page kısmen yapıldıysa tekrar baştan yazılmadan mevcut yapı gözden geçirilir.

---

# 11. TEKNİK TEMİZLİK VE STANDARTLAR

- Route düzeni gözden geçirilecek
- Controller sorumlulukları sadeleştirilecek
- Gereksiz starter bileşenleri temizlenecek
- Blade / component mimarisi düzenlenecek
- Asset yapısı sadeleştirilecek
- Upload ve media path sistemi standartlaştırılacak
- Hata loglama netleştirilecek

---

# 12. ÖNCELİK SIRASI

## Faz 1 – Kritik Düzeltmeler
1. Analizler sayfası 500 hatası
2. Kırık profil görselleri
3. Türkçeleştirme eksikleri
4. Sistem logosu + favicon

## Faz 2 – Panel Dönüşümü
5. Kullanıcı dashboard redesign
6. Yönetici / süper admin dashboard
7. UI component iyileştirmeleri

## Faz 3 – Tema ve Canlı Önizleme
8. Telefon mockup kaldırılması
9. Canlı önizleme alanı
10. Tema ayarlarının genişletilmesi
11. Özel CSS desteği

## Faz 4 – Link Yönetimi
12. Otomatik ikon algılama
13. Manuel ikon seçici
14. Link düzenleme deneyimi

## Faz 5 – Yönetim ve Büyüme
15. Süper admin modülü
16. Sistem istatistik ekranları
17. Landing page final düzenlemeleri

---

# 13. TAMAMLAMA KRİTERLERİ

Bir geliştirme tamamlanmış sayılması için:
- Hata vermeden çalışmalı
- Türkçe dil standardına uymalı
- Mobil ve masaüstünde bozulmamalı
- Mevcut çalışan modülleri kırmamalı
- Panel görünümünü hissedilir şekilde iyileştirmeli
- Kullanıcı açısından sezgisel olmalı