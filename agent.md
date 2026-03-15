# agent.md
## Türkçe Tasarım Editörü Refactor Görev Dosyası

Bu dosya, mevcut tasarım editöründeki hataları düzeltmek, gereksiz yapıları kaldırmak, canlı önizlemeyi tamamen anlık hale getirmek ve editörü daha sade / stabil / profesyonel bir yapıya dönüştürmek için hazırlanmıştır.

---

# 1. Ana Hedef

Mevcut tasarım editörü aşağıdaki sorunlara sahiptir:

- bazı ayarlar canlı önizlemeye yansımıyor
- bazı alanlar sadece UI üzerinde değişiyor gibi görünüyor ama preview değişmiyor
- arka plan tipleri birbirine karışıyor
- gereksiz sekmeler ve tekrar eden ayarlar var
- bazı layout’larda desteklenmeyen alanlar görünmeye devam ediyor
- bazı grid / picker / radius / buton alanları görsel olarak bozuk
- sistemin bazı bölümlerinde aynı anda birden fazla stil / css / renderer aktif kalıyor

Bu çalışma sonunda sistem:

- tamamen Türkçe olacak
- tüm ayarlar anlık canlı önizlemeye yansıyacak
- arka plan sistemi tek aktif mod mantığı ile çalışacak
- gereksiz “Özel Tasarım” sekmesi kaldırılacak
- font, renk, buton, arka plan, tema alanları net şekilde ayrılacak
- editör tek bir merkezi tasarım state’i ile çalışacak

---

# 2. En Kritik Kural

## Tasarım editöründe yapılan her ayar anlık olarak canlı görünümde güncellenmelidir.

Buna dahil olan tüm alanlar:

- header düzeni
- avatar boyutu
- tema seçimi
- font seçimi
- font boyutu
- arka plan tipi
- arka plan rengi
- gradyan renkleri
- gradyan yönü
- gradyan açısı
- görsel arka plan
- video arka plan
- video blur
- video karartma
- animasyon türü
- animasyon renkleri
- tüm metin renkleri
- buton varyantı
- buton radius
- buton border style
- buton border width
- buton hover renkleri

Hiçbir ayar yalnızca panelde değişmiş gibi görünmemelidir.
Canlı önizleme editör state’ini gerçek zamanlı dinlemelidir.

---

# 3. Header Düzeni Sorunları

## 3.1 Sol Hizalı düzen + Avatar Boyutu

Sorun:
- Header düzeni “Sola Hizalı” seçildiğinde `Profil Görseli (Avatar) > Görsel Boyutu` alanı seçim yapıyor gibi görünse de canlı önizlemede değişiklik olmuyor.

İstenen çözüm:
- Eğer sol hizalı düzen avatar boyutu değişimini teknik olarak destekliyorsa, bu alan düzgün çalışmalı ve preview anlık güncellenmeli.
- Eğer desteklemiyorsa, `Sola Hizalı` düzen aktifken `Görsel Boyutu` alanı tamamen gizlenmeli.

Uygulama notu:
- Layout-aware conditional rendering yapılmalı.
- Desteklenmeyen kontrol, kullanıcıya gösterilmemeli.

---

## 3.2 Hero Kapak + Varsayılan Avatar Boyutu

Sorun:
- Hero Kapak seçildiğinde avatar boyutu otomatik olarak “Dev” geliyor.
- Sonrasında diğer boyutlar seçilse bile canlı önizleme düzgün güncellenmiyor.

İstenen çözüm:
- Hero Kapak seçildiğinde varsayılan avatar boyutu `Orta` olmalı.
- Boyut alanı çalışır durumda olmalı.
- Kullanıcı `Küçük / Orta / Büyük / Dev` arasında geçince preview anlık değişmeli.

Uygulama notu:
- Header layout değişiminde avatarSize normalize edilmeli.
- Preview component state ile aynı kaynaktan beslenmeli.

---

# 4. Tema Sistemi

Sorun:
- “Hazır Tema” seçildiğinde sayfa aşağı boş bir alana kayıyor.
- Üst taraftaki “Özel Tasarım” sekmesi gereksiz.
- Hazır tema seçimi sadece görünsel seçim değil, canlı önizlemeye anında uygulanmalı.

İstenen çözüm:
- “Hazır Tema” bölümü sadece hazır renk kombinasyonları / stil presetleri sunmalı.
- Tema kartına tıklanması hiçbir scroll / anchor / sekme atlaması tetiklememeli.
- Seçilen tema anında preview’a uygulanmalı.
- `Özel Tasarım` sekmesi tamamen kaldırılmalı.

Uygulama notu:
- Tema seçici navigation değil, saf preset selector gibi çalışmalı.
- Preset theme ile manuel ayarlar aynı tasarım state’i üzerinde çalışmalı.

---

# 5. Menü Sıralaması ve Türkçe Yapı

Sistem tamamen Türkçe olacaktır.

Önerilen menü sırası:
1. Header
2. Font
3. Tema
4. Arka Plan
5. Renk
6. Butonlar

Not:
- Menüde “Butonlar” bölümünden önce mutlaka `Font` alanı gelmeli.
- Kullanıcı menüden ilgili bölüme tıklayınca editör tek sayfa içinde ilgili bölüme gitmeli.

---

# 6. Font Alanı

Mevcut durum:
- Font alanı eski “Özel Tasarım” sekmesindeydi.
- Bu sekme kaldırıldığı için font alanı bağımsız bölüm olarak eklenmeli.

İstenen çözüm:
- Ayrı bir `Font` bölümü oluşturulmalı.
- Google Fonts kullanılmalı.
- Aşağıdaki fontlar seçenek olarak gelmeli:

  - Inter
  - Roboto
  - Oswald
  - Poppins
  - Bai Jamjure
  - Playfair Display
  - Montserrat

Not:
- “Montserat” değil, doğru isimle `Montserrat` kullanılmalı.

Font uygulama kuralı:
- Seçilen font sayfadaki tüm metinlere uygulanmalı:
  - profil ismi
  - kullanıcı adı
  - biyografi
  - link / buton metinleri
  - diğer tüm text alanları

Ek istek:
- `Font Size` alanı olmalı.
- Seçenekler:
  - Küçük
  - Orta
  - Büyük
  - Çok Büyük

Font size da genel tipografi sistemini etkilemeli.

---

# 7. Arka Plan Düzeni

Sistemde arka plan türleri:
- Renk
- Gradyan
- Görsel
- Video
- Animasyon

## 7.1 Arka plan seçim kartları

Sorun:
- 5 kart aynı satırda görünmesi gerekirken bazı kartlar aşağı kayıyor.

İstenen çözüm:
- `Renk / Gradyan / Görsel / Video / Animasyon` kartlarının tamamı aynı satırda görünmeli.

---

## 7.2 Tek aktif arka plan modu

Çok kritik sorun:
- Kullanıcı arka plan türünü değiştirince önceki türün css / renderer / class / effect katmanları sistemde kalıyor.
- Aynı anda hem renk hem animasyon vb. uygulanabiliyor.

İstenen çözüm:
- Aynı anda sadece bir adet `activeBackgroundType` aktif olabilir.
- Yeni arka plan seçildiğinde önceki arka plan tipine ait tüm kod / css / class / effect / DOM / video / canvas katmanları temizlenmeli.

Bu kural tüm background modları için zorunludur.

---

# 8. Arka Plan Renk Seçici Görünümü

Sorun:
- Renk picker alanı dikdörtgen duruyor.
- Animasyon renk seçicilerinde de yuvarlak alan düzgün hizalanmamış.

İstenen çözüm:
- Renk seçiciler tam daire formunda olmalı.
- İçerik daire içine düzgün oturmalı.
- Padding / clipping / overflow düzenlenmeli.

---

# 9. Gradyan Alanı

Sorun:
- Mevcut gradyan bölümünde CSS gradient inputu ve hazır gradient listesi bulunuyor.
- Bu yapı kullanıcı dostu değil.

İstenen çözüm:
- Manuel CSS gradient inputu kaldırılmalı.
- 2 adet renk seçici olmalı.
- Kullanıcı bu renkleri seçince sistem gradyanı otomatik oluşturmalı.
- Kullanıcı ayrıca:
  - yön
  - açı
  ayarlayabilmeli.

Beklenen davranış:
- Her değişiklik preview’a anlık yansımalı.

---

# 10. Video Arka Plan

İstenen yapı:
- Kullanıcı video yüklediğinde video otomatik arka plan olmalı.
- Canlı önizlemede gerçek video görünmeli.
- Sadece input tarafında değil, preview tarafında da mount edilmeli.

Ayrıca aşağıdaki kontroller preview’da anlık çalışmalı:
- Karartma Yoğunluğu
- Bulanıklık (Blur)

---

# 11. Animasyon Arka Plan

Durum:
- Animasyon seçildiğinde hazır animasyon seçenekleri görünüyor.
- Seçilen animasyon preview’da çıkıyor.

Düzeltme:
- Bu çalışma korunmalı ama görsel bozukluklar düzeltilmeli.
- Animasyon renk seçicileri tam dairesel ve hizalı görünmeli.

Ek kural:
- Animasyon modu aktif olduğunda diğer background modlarına ait stil katmanları temizlenmeli.

---

# 12. Butonlar Bölümü

## 12.1 Görünüm Varyantları

Buton varyantları:
- Solid
- Outline
- Glass
- Offset

İstenen çözüm:
- Hangi arka plan tipi seçilirse seçilsin bu varyantlar düzgün çalışmalı.
- Seçilen varyant preview’daki link kartlarına anlık uygulanmalı.

---

## 12.2 Köşe Yuvarlaklığı

Sorun:
- Mevcut yapı kart seçimi / preset gibi duruyor.
- İstenen görünüm slider bazlı.

İstenen çözüm:
- `Köşe Yuvarlaklığı` alanı slider olarak yeniden tasarlanmalı.
- Slider hareket ettikçe preview’daki butonlar anlık değişmeli.

---

## 12.3 Border Style

Yeni alan:
- `Buton Border Style`

Kullanıcı:
- border türünü
- border kalınlığını
belirleyebilmeli.

Desteklenen border türleri örneği:
- solid
- dashed
- dotted
- double

Ek kural:
- Eğer buton varyantı `offset` ise bu alan pasif / gizli / kapalı olmalı.

---

# 13. Renk Menüsü

Mevcut hata:
- Buton menüsünde buton renk alanları bulunuyor.
- Bu dağıtık yapı kafa karıştırıyor.

Yeni kural:
- Arka plan menüsü dışında sistemdeki tüm renkler `Renk` menüsünden seçilmeli.
- Buton menüsündeki renk alanları kaldırılmalı.

Renk menüsünde olması gereken alanlar:

- Ana Başlık (İsim)
- Kullanıcı Adı
- Biyografi
- Buton Arka Plan
- Buton Metni
- Buton Kenarlık
- Buton İkon

Ek hover alanları:
- Buton Arka Plan Hover
- Buton Metni Hover
- Buton Kenarlık Hover
- Buton İkon Hover

---

## 13.1 Button Arka Plan alanı kuralı

Kural:
- Eğer buton varyantı `glass` ise `Buton Arka Plan` alanı gizlenmeli.

---

## 13.2 Offset varyantında border rengi

Kural:
- Offset varyantında kullanılan box-shadow rengi, `Buton Kenarlık` alanından beslenmeli.

Örnek davranış:
`.variant-offset { box-shadow: 4px 4px 0px 0px var(--button-border); }`

Bu mantık diğer buton varyantlarının border color yapısı ile de uyumlu olmalı.

---

# 14. Tüm Editör Ayarları Türkçe Olmalı

Bu sistem Türkçe olduğu için:

- tüm editör label’ları
- dropdown seçenekleri
- menü isimleri
- section başlıkları
- tooltip / helper text’ler
- varyant isimleri kullanıcıya görünen tarafta

Türkçe olmalıdır.

Örnekler:
- Header Düzeni
- Profil Görseli
- Görsel Boyutu
- Hazır Tema
- Arka Plan
- Renk
- Butonlar
- Köşe Yuvarlaklığı
- Kenarlık Stili
- Karartma Yoğunluğu
- Bulanıklık

Not:
- İç state / teknik key isimleri İngilizce olabilir.
- Kullanıcıya görünen arayüz tamamen Türkçe olmalı.

---

# 15. Canlı Önizleme Mimari Zorunluluğu

Bu editörde yapılan her işlem şu akış ile çalışmalı:

Editor Control
→ Global Design State Güncelle
→ Live Preview Renderer Yenile / Uygula

Yani:
- UI ayrı state tutmamalı
- preview ayrı state tutmamalı
- tüm yapı tek merkezi tasarım state’ine bağlanmalı

Preview hiçbir zaman editörden kopuk olmamalıdır.

---

# 16. Temizlenecek / Kaldırılacak Sistemler

Aşağıdaki yapılar sistemden kaldırılmalı veya yeniden yazılmalı:

- Özel Tasarım sekmesi
- Eski CSS gradient input alanı
- Buton menüsündeki buton renk alanları
- Tema seçince scroll yapan eski davranış
- Önceki background modundan kalan css katmanları
- Desteklenmeyen header layout’larda görünen gereksiz kontroller

---

# 17. Beklenen Nihai Sonuç

Yeni editör şu özelliklere sahip olmalı:

- sade
- tamamen Türkçe
- tek sayfa editör
- anlık canlı önizleme
- temiz state yönetimi
- arka planlarda tek aktif mod sistemi
- tutarlı renk yönetimi
- profesyonel buton yönetimi
- kullanıcı dostu font ve tema düzeni
- CSS çakışması azaltılmış yapı

Bu görev tamamlandığında kullanıcı editörde yaptığı her değişikliği sağ tarafta / canlı görünümde anlık olarak görebilmelidir.