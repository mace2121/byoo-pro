# Design Editor Architecture.md
## Türkçe Tasarım Editörü Sistem Mimarisi

Bu doküman mevcut tasarım editörünü profesyonel, hızlı, stabil ve anlık çalışan bir canlı builder sistemine dönüştürmek için hazırlanmıştır.

Sistem, Türkçe arayüzlü bir profil / bio sayfası düzenleme editörüdür.

---

# 1. Ana Amaç

Editör kullanıcıya aşağıdaki alanları düzenleme imkanı sunar:

- Header
- Font
- Tema
- Arka Plan
- Renk
- Butonlar

Bu sistemin temel prensibi şudur:

## Kullanıcı editörde ne değiştirirse değiştirsin canlı görünüm anında güncellenmelidir.

Bu nedenle sistem:
- tek yönlü veri akışı
- merkezi tasarım state’i
- gerçek zamanlı preview render
mantığı ile çalışmalıdır.

---

# 2. Yüksek Seviye Mimari

Sistem 3 ana katmandan oluşur:

1. Editor Panel
2. Design State
3. Live Preview

Veri akışı:

Editor Control  
→ Design State Update  
→ Live Preview Apply

Bu akış tek yönlü olmalıdır.

Preview hiçbir zaman bağımsız tahmini değerler kullanmamalıdır.
Her zaman merkezi state’i dinlemelidir.

---

# 3. Merkezi Tasarım State’i

Tüm tasarım kararları tek bir nesne içinde tutulmalıdır.

Örnek mimari:

- header
- typography
- theme
- background
- colors
- buttons

Bu state aşağıdaki gibi bölümlenmelidir:

## 3.1 Header
- layout
- avatarSize

## 3.2 Typography
- fontFamily
- fontSizePreset

## 3.3 Theme
- selectedPreset

## 3.4 Background
- activeType
- config

## 3.5 Colors
- title
- username
- bio
- buttonBg
- buttonText
- buttonBorder
- buttonIcon
- hoverBg
- hoverText
- hoverBorder
- hoverIcon

## 3.6 Buttons
- variant
- radius
- borderStyle
- borderWidth

---

# 4. Türkçe Arayüz Kuralı

Kullanıcıya görünen tüm editör alanları Türkçe olmalıdır.

Bu kural şu alanları kapsar:
- menü başlıkları
- form alanı label’ları
- dropdown seçenekleri
- buton varyant isimleri
- yardımcı metinler
- boş durum mesajları
- hata mesajları

Örnek kullanıcı arayüzü metinleri:
- Header
- Font
- Tema
- Arka Plan
- Renk
- Butonlar
- Görsel Boyutu
- Karartma Yoğunluğu
- Bulanıklık
- Köşe Yuvarlaklığı
- Kenarlık Stili

Not:
Teknik key’ler İngilizce tutulabilir ancak UI Türkçe olmalıdır.

---

# 5. Canlı Önizleme Katmanı

Preview sistemi merkezi state’i dinlemeli ve sadece gerekli değişiklikleri uygulamalıdır.

Örnek akış:
- kullanıcı font değiştirir
- state.font güncellenir
- typography engine çalışır
- preview’daki tüm metinler güncellenir

Aynı mantık:
- butonlar
- renkler
- arka plan
- hover state
- radius
alanları için de geçerli olmalıdır.

Preview’da “kaydetmeden görünmez” gibi bir davranış olmamalıdır.

---

# 6. CSS Variable Tabanlı Stil Sistemi

Stil değişikliklerinin büyük bölümü CSS variable sistemi üzerinden uygulanmalıdır.

Örnek değişken grupları:
- font family
- font size
- metin renkleri
- button renkleri
- hover renkleri
- radius
- border style
- border width

Bunun avantajları:
- hızlı güncelleme
- tekrar render ihtiyacını azaltma
- sade stil katmanı
- merkezi kontrol

---

# 7. Header Mimarisi

Header sisteminde 3 düzen bulunur:
- Klasik Merkez
- Sol Hizalı
- Hero Kapak

Kurallar:

## 7.1 Sol Hizalı
Eğer avatar size değişimi bu düzende desteklenmiyorsa ilgili alan UI’dan gizlenmelidir.

## 7.2 Hero Kapak
Hero düzen seçildiğinde varsayılan avatar boyutu `Orta` olmalıdır.
Avatar boyutu değişirse preview bunu anlık göstermelidir.

## 7.3 Layout-aware settings
Bazı alanlar sadece desteklenen layout’larda görünmelidir.
Desteklenmeyen ayar kullanıcıya gösterilmemelidir.

---

# 8. Tema Sistemi

Tema sistemi sadece preset kombinasyonlar sunmalıdır.

Eski yapıdaki “Özel Tasarım” sekmesi kaldırılmalıdır.

Tema seçiminin görevleri:
- renk kombinasyonu uygulamak
- gerekiyorsa varsayılan button / text renkleri atamak
- canlı önizlemeyi anında güncellemek

Tema kartı tıklaması:
- scroll tetiklememeli
- anchor tetiklememeli
- sekme atlatmamalı
- yalnızca preset uygulamalıdır

Tema sistemi manuel ayarlarla kavga etmemelidir.
Preset uygulaması sonrasında kullanıcı arka plan / renk / buton ayarlarını elle değiştirebilmelidir.

---

# 9. Font Sistemi

Font bölümü bağımsız bir editör alanı olmalıdır.

Desteklenen Google Font aileleri:
- Inter
- Roboto
- Oswald
- Poppins
- Bai Jamjure
- Playfair Display
- Montserrat

Font seçimi sayfadaki tüm metinlere etki etmelidir:
- profil adı
- kullanıcı adı
- biyografi
- link metinleri
- diğer metin alanları

Font size presetleri:
- Küçük
- Orta
- Büyük
- Çok Büyük

Font size sistemi global text scale mantığı ile çalışmalıdır.

---

# 10. Arka Plan Motoru

Arka plan sistemi bu editörün en kritik parçalarından biridir.

Desteklenen türler:
- Renk
- Gradyan
- Görsel
- Video
- Animasyon

## En kritik kural:
Aynı anda yalnızca 1 arka plan tipi aktif olabilir.

Bu nedenle sistem şu şekilde çalışmalıdır:
- kullanıcı yeni tür seçer
- önceki arka plan tipine ait tüm kalıntılar temizlenir
- yeni arka plan tipi uygulanır

Temizlenecek katman örnekleri:
- inline style
- css class
- overlay
- blur katmanı
- video elementi
- canvas / svg animasyon
- özel renderer node’ları

---

# 11. Arka Plan Türleri

## 11.1 Renk
Tek renk arka plan.
Renk seçimi anında preview’a yansımalıdır.

## 11.2 Gradyan
Kullanıcı CSS yazmamalıdır.
İki renk seçici bulunmalıdır.
Ek alanlar:
- yön
- açı

Sistem gradient string’i otomatik üretmelidir.

## 11.3 Görsel
Yüklenen görsel preview arka planına uygulanmalıdır.

## 11.4 Video
Yüklenen video preview’da gerçek video olarak görünmelidir.
Destek alanları:
- blur
- karartma yoğunluğu

## 11.5 Animasyon
Hazır animasyon presetleri olmalıdır.
Animasyon seçimi preview’a anlık uygulanmalıdır.

---

# 12. Arka Plan Kart Grid Yapısı

Renk / Gradyan / Görsel / Video / Animasyon kartları aynı satırda görünmelidir.

Grid sistemi:
- sabit kolon
- eşit kart yüksekliği
- taşma önleme
- gereksiz wrap engelleme
mantığı ile tasarlanmalıdır.

---

# 13. Renk Menüsü Mimarisi

Arka plan dışındaki tüm renk yönetimi `Renk` menüsünde toplanmalıdır.

Alanlar:
- Ana Başlık
- Kullanıcı Adı
- Biyografi
- Buton Arka Plan
- Buton Metni
- Buton Kenarlık
- Buton İkon

Hover alanları:
- Buton Arka Plan Hover
- Buton Metni Hover
- Buton Kenarlık Hover
- Buton İkon Hover

Kurallar:
- Glass varyantında `Buton Arka Plan` alanı gizlenmeli
- Offset varyantında box-shadow rengi border rengine bağlanmalı

Bu merkezi renk yapısı sayesinde kullanıcı renkleri tek yerden kontrol eder.

---

# 14. Buton Mimarisi

Buton varyantları:
- Solid
- Outline
- Glass
- Offset

Preview’daki tüm link kartları ortak button component mantığı ile render edilmelidir.

## 14.1 Radius
Radius slider ile kontrol edilmelidir.
Preset kart sistemi kaldırılmalıdır.

## 14.2 Border Style
Ayrı alan olmalıdır.
Kullanıcı:
- border türü
- border kalınlığı
seçebilmelidir.

Offset seçiliyken bu alan pasif olmalıdır.

## 14.3 Hover sistemi
Hover renkleri normal renklerden ayrı token olarak tutulmalıdır.

---

# 15. Component İzolasyonu

Her editör alanı ayrı component olabilir ancak hepsi aynı global state üzerinden çalışmalıdır.

Örnek editör componentleri:
- HeaderEditor
- FontEditor
- ThemeEditor
- BackgroundEditor
- ColorEditor
- ButtonEditor

Örnek preview componentleri:
- ProfileHeader
- ProfileMeta
- LinkList
- BackgroundRenderer

Her component kendi sorumluluk alanını bilmeli fakat tasarım verisini aynı kaynaktan almalıdır.

---

# 16. Uygulama Katmanları

Önerilen uygulama katmanları:

## 16.1 UI Katmanı
Form alanları, seçiciler, slider’lar

## 16.2 State Katmanı
Merkezi tasarım state’i ve update fonksiyonları

## 16.3 Engine Katmanı
- typography engine
- background engine
- gradient engine
- video engine
- animation engine
- button engine

## 16.4 Preview Katmanı
Preview render ve uygulama mantığı

---

# 17. Koşullu Gösterim Kuralları

Bazı alanlar belirli seçimlerde gizlenmeli / pasif olmalıdır.

Örnekler:
- Sol hizalı desteklemiyorsa avatar boyutu gizlenir
- Glass seçiliyse button arka plan rengi gizlenir
- Offset seçiliyse border style alanı pasif olur

Bu kurallar UI ve preview mantığında birlikte uygulanmalıdır.

---

# 18. Hata Önleme İlkeleri

Sistemde şu tip hatalar engellenmelidir:
- UI state değişti ama preview değişmedi
- eski arka plan katmanı kaldı
- tema seçimi scroll yaptırdı
- görünmeyen alanın değeri preview’ı bozdu
- birden fazla background renderer aynı anda çalıştı
- slider hareket etti ama değer uygulanmadı

Bu nedenle tüm güncellemeler:
- tek state üzerinden
- kontrollü update helper ile
- normalize edilmiş değerlerle
çalışmalıdır.

---

# 19. Geleceğe Açık Yapı

Bu mimari ileride şu özellikleri kolay eklemeyi sağlar:
- link drag & drop
- blok sistemi
- özel widget’lar
- analytics preview
- custom css
- yeni animasyon paketleri
- responsive preview modları

Bu nedenle yapı kısa vadeli değil, genişlemeye uygun kurulmalıdır.

---

# 20. Sonuç

Bu mimari uygulandığında editör şu hale gelir:
- daha sade
- tamamen Türkçe
- anlık çalışan
- stabil
- tek state mantığına sahip
- arka planları temiz yöneten
- profesyonel bir canlı builder

Bu doküman teknik geliştirme başlamadan önce referans mimari olarak kullanılmalıdır.