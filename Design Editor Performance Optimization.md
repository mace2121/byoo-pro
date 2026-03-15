# Design Editor Performance Optimization.md
## Türkçe Tasarım Editörü Performans ve Stabilite Optimizasyon Rehberi

Bu doküman, mevcut tasarım editörünü yalnızca görsel olarak değil teknik olarak da güçlü hale getirmek için hazırlanmıştır.

Amaç:
- canlı görünüm gecikmesini azaltmak
- gereksiz render’ları önlemek
- arka plan katman çakışmalarını temizlemek
- video / animasyon / blur gibi ağır alanları optimize etmek
- CSS çakışmalarını azaltmak
- mevcut sistem üzerinde refactor yaparken performans kaybını engellemek

---

# 1. Ana Performans Kuralı

## Canlı önizleme anlık çalışmalı ama her değişiklikte tüm sistemi baştan render etmemelidir.

Bunun yerine sistem:
- yalnızca değişen alanı güncellemeli
- gerekli katmanı yeniden uygulamalı
- gereksiz DOM işlemlerinden kaçınmalıdır

Örnek:
- kullanıcı sadece buton radius değiştiriyorsa tüm background sistemi yeniden kurulmaz
- kullanıcı sadece font değiştiriyorsa video background yeniden yüklenmez

---

# 2. Performans Sorunlarının Ana Kaynakları

Mevcut benzer editörlerde yavaşlığa en sık neden olan başlıklar:

- aynı anda birden fazla background katmanının kalması
- gereksiz tam render
- ağır blur kullanımı
- video her değişimde yeniden oluşturulması
- animasyonların temizlenmemesi
- çok fazla inline style güncellemesi
- dağınık CSS nedeniyle style override karmaşası
- UI state ve preview state’in farklı yerlerde tutulması

Bu nedenle performans çalışması sadece “hızlandırma” değil, “mimari temizleme” olarak ele alınmalıdır.

---

# 3. Merkezi State = Performans Kazancı

Tüm editör ayarları tek merkezde tutulduğunda:
- değişimin ne olduğu kolay anlaşılır
- sadece ilgili engine tetiklenir
- gereksiz render azalır
- debug kolaylaşır

Örnek yaklaşım:
- update type = `font.family`
- renderer sadece typography katmanını günceller

Bu yapı yoksa editör her değişiklikte komple yenilenir ve lag oluşur.

---

# 4. Kısmi Güncelleme Stratejisi

Sistem “full rerender” yerine “partial update” kullanmalıdır.

## 4.1 Typography değişirse
Güncellenecekler:
- font family
- font size
- text ölçekleri

Güncellenmeyecekler:
- background
- video
- animasyon
- button layout

## 4.2 Button değişirse
Güncellenecekler:
- buton sınıfları
- radius
- border
- hover token’ları

Güncellenmeyecekler:
- header
- background
- video mount yapısı

## 4.3 Background değişirse
Sadece background katmanı temizlenip yeniden kurulmalıdır.

---

# 5. Background Cleanup Performansı

Arka plan sistemi performansın en kritik noktasıdır.

## Zorunlu kural:
Yeni background seçildiğinde eski katman tamamen kaldırılmalıdır.

Temizlenmesi gerekenler:
- önceki background image inline style
- önceki gradient style
- önceki video elementi
- önceki overlay katmanı
- önceki animasyon DOM / canvas / svg katmanı
- önceki blur filtresi
- önceki background class’ları

Bu yapılmazsa:
- CSS çakışır
- GPU yük artar
- preview yavaşlar
- beklenmeyen görsel karışımlar oluşur

---

# 6. CSS Variable Kullanımı ile Hız Kazanımı

Mümkün olduğunca şu alanlar CSS variable ile uygulanmalıdır:
- metin renkleri
- buton renkleri
- hover renkleri
- radius
- border style
- border width
- font family
- font size token’ları

Avantajlar:
- çok hızlı stil güncellemesi
- daha az DOM manipulation
- daha az React/Vue rerender ihtiyacı
- sade debug süreci

---

# 7. Inline Style Aşırılığını Önleme

Her kontrol için yeni inline style üretmek yerine:
- ortak class
- CSS variable
- sınırlı style injection
kullanılmalıdır.

Özellikle:
- button hover
- radius
- renk geçişleri
- metin renkleri
alanlarında CSS variable tercih edilmelidir.

---

# 8. Video Background Optimizasyonu

Video arka plan yanlış uygulanırsa editörü ağırlaştırır.

## Kurallar:

### 8.1 Video yeniden oluşturulmamalı
Kullanıcı sadece blur veya overlay değiştiriyorsa video elementi silinip yeniden yaratılmamalıdır.
Sadece ilgili stil katmanları güncellenmelidir.

### 8.2 Uygun video özellikleri kullanılmalı
- autoplay
- muted
- loop
- playsinline

### 8.3 Blur dikkatli kullanılmalı
Aşırı blur değeri GPU yükünü artırır.
Blur değerleri makul sınırda tutulmalıdır.

### 8.4 Overlay ayrı katman olmalı
Karartma yoğunluğu video üzerine ayrı bir overlay katmanıyla verilmelidir.
Video’nun kendisine fazla filter bindirmemek daha sağlıklıdır.

### 8.5 Video container tek olmalı
Preview içinde aynı anda tek video background container bulunmalıdır.

---

# 9. Animasyon Performansı

Animasyon arka plan sistemi sürekli çalışan bir katmandır.
Bu nedenle kontrolsüz kurulum ciddi performans kaybı yaratır.

## Kurallar:

### 9.1 Aynı anda tek animasyon
Bir animasyon seçildiğinde diğer animasyon katmanı tamamen kaldırılmalıdır.

### 9.2 Hafif preset mantığı
İlk versiyonda çok ağır partikül simülasyonları yerine hafif css / svg / canvas tabanlı presetler kullanılmalıdır.

### 9.3 RequestAnimationFrame kontrolü
Canvas tabanlı animasyon varsa gereksiz tekrar kurulumdan kaçınılmalı, animasyon loop’u tek instance olarak yönetilmelidir.

### 9.4 Tab görünürlüğü optimizasyonu
Mümkünse görünmeyen / pasif durumda animasyon yoğunluğu azaltılmalıdır.

---

# 10. Gradient Performansı

Gradient alanı hafif görünse de sürekli string yeniden üretmek gereksiz olabilir.

İyi yaklaşım:
- color1
- color2
- angle
değişince tek bir gradient string üret
- bunu CSS variable veya tek background style olarak uygula

Eski sistemdeki manuel CSS input yaklaşımı kaldırılmalıdır.
Bu hem UX’i hem performansı bozar.

---

# 11. Button Performansı

Butonlar preview’daki en sık güncellenen parçalardan biridir.

Optimizasyon kuralları:
- tüm button stilleri ortak class + variable sistemiyle çalışmalı
- her butona tek tek ayrı karmaşık style basılmamalı
- varyant değişince class değişmeli
- radius değişince variable değişmeli
- hover renkleri tek merkezi token setinden gelmeli

Offset varyantında:
- box-shadow rengi border token’dan alınmalı
- farklı bir bağımsız renk sistemi üretilmemeli

---

# 12. Font Yükleme Optimizasyonu

Google Font yükleme sistemi dikkatli tasarlanmalıdır.

## Kurallar:
- aynı font link’i tekrar tekrar head içine eklenmemeli
- seçilen font önceden yüklüyse tekrar çağrılmamalı
- font değişimi sonrası yalnızca typography katmanı güncellenmeli

Ek öneri:
- kullanılan font listesi sınırlı tutulduğu için preload / ön hazırlık stratejisi değerlendirilebilir

---

# 13. Scroll ve Anchor Optimizasyonu

Mevcut hatalardan biri tema tıklanınca sayfanın aşağı boş alana kaymasıdır.

Bu tip davranışlar:
- yanlış anchor
- form submit
- default button behavior
- hash navigation
kaynaklı olabilir.

Çözüm:
- tema kartları gerçek navigation elemanı gibi davranmamalı
- gerekiyorsa `preventDefault`
- section scroll sadece menü navigasyonunda kullanılmalı

Bu hem UX hem performans açısından önemlidir.

---

# 14. Gereksiz Re-render Önleme

Editor paneldeki her component gereksiz yere yeniden render edilmemelidir.

Öneriler:
- her bölüm kendi state slice’ını dinlemeli
- memoization / computed structure kullanılmalı
- shared componentler gereksiz prop değişimlerinden korunmalı

Özellikle:
- SharedColorPicker
- SharedSlider
- LinkButtons
- BackgroundRenderer
bölümlerinde dikkat edilmelidir.

---

# 15. Preview ve Editor Ayrımı

Editor panel ile preview alanı birbirine bağlıdır ama birbirini gereksiz yormamalıdır.

İdeal yapı:
- editör değişikliği state’e gider
- preview sadece ilgili kısmı uygular
- editor UI yeniden kurulmaz

Bu sayede büyük panellerde takılma azalır.

---

# 16. CSS Çakışmalarını Azaltma

Çakışan CSS sadece görsel hata değil, performans sorunudur.

Öneriler:
- editör stilleri ile preview stilleri ayrılmalı
- ortak isimli generic class’lardan kaçınılmalı
- bileşen class isimleri namespace’li tutulmalı

Örnek yaklaşım:
- `de-editor-*`
- `de-preview-*`
- `de-button-*`

Bu sayede mevcut sistemde başka alanlarla çakışma azalır.

---

# 17. Debounce / Throttle Kullanımı

Her kontrol için gerekmez.
Ama bazı alanlarda faydalı olabilir:

## Debounce uygun alanlar:
- manuel text input
- özel renk hex inputu varsa
- video URL alanı varsa

## Anlık kalması gereken alanlar:
- slider
- varyant seçimi
- tema seçimi
- renk seçici
- radius
- blur
- overlay

Yani kullanıcı deneyimini bozacak aşırı debounce kullanılmamalıdır.

---

# 18. Hata Toleransı ve Guard Mekanizması

Performans kadar stabilite de önemlidir.

Sistem şunları guard etmelidir:
- geçersiz video URL
- bozuk image data
- eksik gradient config
- tanımsız theme preset
- desteklenmeyen button variant
- boş font değeri

Geçersiz veri geldiğinde preview çökmemeli, varsayılan güvenli değer kullanılmalıdır.

---

# 19. Test Edilmesi Gereken Kritik Senaryolar

Performans refactor sonrası özellikle şu akışlar test edilmelidir:

1. Tema değiştir → hemen sonra font değiştir
2. Renk arka plandan animasyona geç
3. Animasyondan videoya geç
4. Videoda blur ve karartmayı peş peşe değiştir
5. Glass varyant seç → renk menüsünü kontrol et
6. Offset varyant seç → border style’ın pasifliğini kontrol et
7. Hero seç → avatar boyutu değiştir
8. Sol hizalı seç → avatar boyutunun gizlenmesini kontrol et
9. Renk picker’ları hızlıca değiştir
10. Radius slider’ı hızlıca sürükle

Bu senaryolarda:
- kasma
- çakışma
- eski katman kalması
- preview gecikmesi
olmamalıdır.

---

# 20. Mevcut Sisteme Uygulama Stratejisi

Bu proje sıfırdan değil, mevcut sistem üzerine refactor olduğu için şu sıra önerilir:

1. Önce merkezi state yapısını netleştir
2. Sonra preview renderer’ı merkezi hale getir
3. Ardından background cleanup sistemini düzelt
4. Sonra font / renk / buton alanlarını merkezi token mantığına taşı
5. En son UI görsel düzenlemeleri ve Türkçeleştirme tamamla

Yani önce mimari ve performans, sonra kozmetik düzeltme yapılmalıdır.

---

# 21. Nihai Sonuç

Bu optimizasyonlar uygulandığında editör:
- daha hızlı açılır
- daha az takılır
- canlı görünüm daha akıcı çalışır
- background değişimleri çakışmaz
- video ve animasyon sistemi daha stabil olur
- büyük ölçüde profesyonel builder hissi verir

Bu doküman teknik geliştirme sırasında performans kontrol listesi olarak kullanılmalıdır.