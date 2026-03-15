# Design Editor File Structure.md
## Türkçe Tasarım Editörü Dosya Yapısı ve Sorumluluk Haritası

Bu doküman mevcut sisteme yeni bir tasarım editörü mimarisi uygularken hangi klasörlerin, dosyaların ve modüllerin hangi işi yapacağını tanımlar.

Amaç:
- mevcut sistemi bozmadan düzenli genişleme
- tasarım editörünü modüler hale getirme
- tüm canlı önizleme mantığını tek bir standartta toplama
- tüm editör ayarlarını Türkçe kullanıcı arayüzüyle sunma

---

# 1. Ana Kural

## Kullanıcıya görünen tüm editör ayarları Türkçe olacaktır.

Bu kural şu alanlar için geçerlidir:
- bölüm başlıkları
- form label’ları
- seçenek metinleri
- durum mesajları
- yardım metinleri
- tooltip içerikleri

Teknik dosya isimleri İngilizce olabilir.
Ancak panel dili Türkçe olmalıdır.

---

# 2. Önerilen Klasör Yapısı

Aşağıdaki yapı mevcut sisteme uyarlanabilir. Gerekiyorsa mevcut proje yapısına isimler adapte edilebilir, ancak sorumluluk dağılımı korunmalıdır.

src/
editor/
state/
designState.js
stateManager.js
designDefaults.js

components/
HeaderEditor.jsx
FontEditor.jsx
ThemeEditor.jsx
BackgroundEditor.jsx
ColorEditor.jsx
ButtonEditor.jsx
SectionAnchorMenu.jsx
SharedColorPicker.jsx
SharedSlider.jsx
SharedSelect.jsx

preview/
PreviewRenderer.jsx
BackgroundRenderer.jsx
ProfileHeader.jsx
ProfileTextBlock.jsx
LinkButtons.jsx
PreviewShell.jsx

engines/
backgroundEngine.js
gradientEngine.js
videoEngine.js
animationEngine.js
typographyEngine.js
themeEngine.js
buttonEngine.js
colorEngine.js

utils/
applyCSSVariables.js
cleanupBackgroundLayers.js
loadGoogleFont.js
normalizeDesignState.js
scrollToSection.js

styles/
editor.css
preview.css
variables.css
backgrounds.css
buttons.css
typography.css

constants/
fontOptions.js
themePresets.js
buttonVariants.js
backgroundTypes.js
uiLabels.js

---

# 3. State Dosyaları

## 3.1 `designState.js`
Görevi:
- merkezi tasarım state’ini tutmak

İçerik:
- header ayarları
- font ayarları
- theme ayarları
- background ayarları
- renk ayarları
- buton ayarları

Bu dosya preview ve editor için ana veri kaynağı olmalıdır.

---

## 3.2 `designDefaults.js`
Görevi:
- varsayılan tasarım değerlerini tanımlamak
- yeni kullanıcı / reset / yeni tema uygulaması gibi durumlarda başlangıç değerlerini sağlamak

Örnek içerikler:
- varsayılan font = Inter
- varsayılan font boyutu = Orta
- varsayılan header = Klasik Merkez
- varsayılan arka plan = Renk
- varsayılan button varyant = Solid

---

## 3.3 `stateManager.js`
Görevi:
- editor kontrollerinden gelen değişiklikleri güvenli şekilde state’e uygulamak
- değişiklik sonrası preview güncellemeyi tetiklemek
- gerekirse normalize / guard kurallarını çalıştırmak

Burada şu mantık bulunmalıdır:
- updateState(path, value)
- batchUpdate(values)
- resetSection(sectionName)
- applyThemePreset(preset)

---

# 4. Editor Component Dosyaları

## 4.1 `HeaderEditor.jsx`
Görevi:
- Header düzeni seçimi
- Profil görseli ayarları
- avatar boyutu kontrolleri
- layout’a bağlı alanların gösterimi / gizlenmesi

İçerik örnekleri:
- Header Düzeni
- Profil Görseli
- Görsel Boyutu

Kural:
- Sol hizalı desteklemiyorsa avatar size alanını gizlemelidir
- Hero seçildiğinde varsayılan avatar boyutu `Orta` olmalıdır

---

## 4.2 `FontEditor.jsx`
Görevi:
- Google Font seçimi
- Font boyutu seçimi

Kullanıcıya görünen Türkçe alanlar:
- Font Ailesi
- Yazı Boyutu

Font seçenekleri:
- Inter
- Roboto
- Oswald
- Poppins
- Bai Jamjure
- Playfair Display
- Montserrat

Font size seçenekleri:
- Küçük
- Orta
- Büyük
- Çok Büyük

---

## 4.3 `ThemeEditor.jsx`
Görevi:
- Hazır temaları göstermek
- tema preset seçimini uygulamak

Kural:
- `Özel Tasarım` sekmesi olmayacak
- tema tıklaması scroll / anchor tetiklemeyecek
- sadece preset uygulayacak

---

## 4.4 `BackgroundEditor.jsx`
Görevi:
- arka plan türü seçimi
- arka plan alt ayarlarının gösterimi
- tek aktif background mantığını yönetmek

Alt bölümler:
- Renk
- Gradyan
- Görsel
- Video
- Animasyon

Ek kural:
- kart grid’i 5 kartı aynı satırda göstermelidir

---

## 4.5 `ColorEditor.jsx`
Görevi:
- arka plan hariç tüm renk token’larını yönetmek

Türkçe alanlar:
- Ana Başlık
- Kullanıcı Adı
- Biyografi
- Buton Arka Plan
- Buton Metni
- Buton Kenarlık
- Buton İkon
- Buton Arka Plan Hover
- Buton Metni Hover
- Buton Kenarlık Hover
- Buton İkon Hover

Kurallar:
- Glass seçiliyse `Buton Arka Plan` alanı gizlenir
- Offset gölge rengi `Buton Kenarlık` ile kontrol edilir

---

## 4.6 `ButtonEditor.jsx`
Görevi:
- buton varyantı
- köşe yuvarlaklığı
- border style
- border width

Türkçe alanlar:
- Görünüm Varyantı
- Köşe Yuvarlaklığı
- Kenarlık Stili
- Kenarlık Kalınlığı

Kurallar:
- Radius slider ile çalışır
- Offset seçiliyse border style alanı pasif olur

---

## 4.7 `SectionAnchorMenu.jsx`
Görevi:
- editör içi tek sayfa bölüm navigasyonu

Menü öğeleri:
- Header
- Font
- Tema
- Arka Plan
- Renk
- Butonlar

Kural:
- menü tıklaması ilgili bölüme yumuşak kaydırma yapabilir
- fakat tema kartı gibi seçim öğeleri asla scroll tetiklememelidir

---

# 5. Shared UI Component Dosyaları

## 5.1 `SharedColorPicker.jsx`
Görevi:
- tüm renk alanlarında ortak color picker yapısı sunmak

Kural:
- picker görünümü yuvarlak olmalı
- daire içine düzgün oturmalı
- dikdörtgen görünüm olmamalı

---

## 5.2 `SharedSlider.jsx`
Görevi:
- radius
- blur
- karartma yoğunluğu
- border kalınlığı
- açı
gibi değerlerde ortak slider yapısı sağlamak

---

## 5.3 `SharedSelect.jsx`
Görevi:
- ortak dropdown / seçim alanlarını standartlaştırmak

---

# 6. Preview Dosyaları

## 6.1 `PreviewRenderer.jsx`
Görevi:
- ana canlı görünüm güncelleme koordinatörü olmak

Sorumlulukları:
- CSS variable güncellemek
- typography engine çağırmak
- background engine çağırmak
- button engine çağırmak
- text renklerini uygulamak

Bu dosya preview’ın beyni olmalıdır.

---

## 6.2 `BackgroundRenderer.jsx`
Görevi:
- aktif arka plan tipini preview içinde doğru render etmek

Kural:
- aynı anda sadece tek arka plan tipini render etmeli

---

## 6.3 `ProfileHeader.jsx`
Görevi:
- profil adı
- kullanıcı adı
- avatar
- hero / merkez / sol hizalı düzen
alanlarını render etmek

---

## 6.4 `ProfileTextBlock.jsx`
Görevi:
- biyografi ve yardımcı metin alanlarını render etmek

---

## 6.5 `LinkButtons.jsx`
Görevi:
- tüm link butonlarını ortak bir sistemle render etmek
- varyant, radius, border, icon ve hover stillerini uygulamak

---

## 6.6 `PreviewShell.jsx`
Görevi:
- mobil preview kabuğu / container / layout alanını oluşturmak

---

# 7. Engine Dosyaları

## 7.1 `backgroundEngine.js`
Görevi:
- aktif background type’a göre doğru alt motoru çağırmak
- önceki background katmanlarını temizlemek

Mantık:
- remove previous
- apply next

---

## 7.2 `gradientEngine.js`
Görevi:
- 2 renk + açı + yön verisinden gradient üretmek

Eski CSS input sistemi burada kullanılmamalıdır.

---

## 7.3 `videoEngine.js`
Görevi:
- video arka planını preview içinde kurmak
- loop / autoplay / muted mantığını yönetmek
- blur / overlay uygulamak

---

## 7.4 `animationEngine.js`
Görevi:
- animasyon presetlerini uygulamak
- animasyon renklerini işlemek
- gerekirse canvas / css animasyon katmanını başlatmak

---

## 7.5 `typographyEngine.js`
Görevi:
- font ailesi ve font size presetini preview’a uygulamak
- Google Font yükleme yardımcıları ile uyumlu çalışmak

---

## 7.6 `themeEngine.js`
Görevi:
- tema presetleri seçildiğinde uygulanacak başlangıç token’larını atamak

Not:
- tema seçimi manuel ayarları gerektiğinde override etmeden dikkatli çalışmalıdır

---

## 7.7 `buttonEngine.js`
Görevi:
- buton varyantlarını
- radius
- border style
- border width
- hover token’larını
preview’a uygulamak

---

## 7.8 `colorEngine.js`
Görevi:
- metin renkleri ve button renk token’larını merkezi olarak işlemek

---

# 8. Utility Dosyaları

## 8.1 `applyCSSVariables.js`
Görevi:
- merkezi tasarım state’indeki token’ları CSS variable olarak root veya preview container’a basmak

---

## 8.2 `cleanupBackgroundLayers.js`
Görevi:
- background türü değiştiğinde önceki katmanları tamamen temizlemek

Silinecek örnekler:
- eski video elementi
- eski overlay
- eski animasyon container
- eski inline background
- eski class isimleri

---

## 8.3 `loadGoogleFont.js`
Görevi:
- ihtiyaç duyulan Google Font’u dinamik yüklemek
- tekrar tekrar aynı link’i eklememek

---

## 8.4 `normalizeDesignState.js`
Görevi:
- geçersiz veya uyumsuz kombinasyonları düzeltmek

Örnek:
- Hero seçildiğinde avatar size default = Orta
- Glass seçiliyse button background alanı hidden / ignored
- Offset seçiliyse border style alanı inactive

---

## 8.5 `scrollToSection.js`
Görevi:
- menüden bölüm geçişlerinde tek sayfa navigasyonunu yönetmek

Kural:
- sadece menü anchor davranışı için kullanılmalı
- tema kartı gibi seçim bileşenlerinde kullanılmamalı

---

# 9. Stil Dosyaları

## 9.1 `editor.css`
Görevi:
- editör panel görünümü
- Türkçe alanların hizaları
- kart yapıları
- bölüm spacing

---

## 9.2 `preview.css`
Görevi:
- canlı görünümün ana stili
- preview layout
- link listesi
- tipografi bağlamı

---

## 9.3 `variables.css`
Görevi:
- css variable tanımları
- varsayılan token yapısı

---

## 9.4 `backgrounds.css`
Görevi:
- arka plan görsel stilleri
- overlay
- animasyon katmanları
- video background yardımcı kuralları

---

## 9.5 `buttons.css`
Görevi:
- buton varyant css’leri
- hover halleri
- offset box-shadow mantığı
- border style görünümü

---

## 9.6 `typography.css`
Görevi:
- font ölçekleri
- başlık / kullanıcı adı / biyografi tipografi seviyeleri

---

# 10. Constants Dosyaları

## 10.1 `fontOptions.js`
Görevi:
- desteklenen fontların listesi

## 10.2 `themePresets.js`
Görevi:
- hazır tema presetleri
- varsayılan renk kombinasyonları

## 10.3 `buttonVariants.js`
Görevi:
- varyant tanımları
- gerekli metadata

## 10.4 `backgroundTypes.js`
Görevi:
- arka plan türlerinin merkezi tanımı

## 10.5 `uiLabels.js`
Görevi:
- Türkçe label metinlerini merkezi yönetmek
- ileride i18n gerekirse geçişi kolaylaştırmak

---

# 11. Dosya Bazlı Sorumluluk Kuralları

Bu projede şu ilkeye uyulmalıdır:

- component dosyası yalnızca kendi UI işini yapar
- business logic engine / state katmanına gider
- preview renderer merkezi koordinasyon yapar
- utility dosyaları tekrar eden yardımcı işleri yapar
- constants dosyaları sabitleri merkezi tutar

Bu ayrım korunmazsa sistem tekrar karışacaktır.

---

# 12. Silinmesi Gereken Eski Yapılar

Aşağıdaki sistemler mevcut editörden kaldırılmalı veya devre dışı bırakılmalıdır:
- Özel Tasarım sekmesi
- eski CSS gradient input yapısı
- buton menüsündeki dağınık renk alanları
- tema seçince boş alana scroll yapan davranış
- aynı anda çoklu background uygulanmasına neden olan kalıntı yapılar

---

# 13. Sonuç

Bu dosya yapısı uygulanırsa sistem:
- modüler olur
- daha kolay bakım yapılır
- canlı önizleme merkezi hale gelir
- editör daha sade olur
- Türkçe arayüz yönetimi kolaylaşır
- yeni özellik eklemek kolaylaşır

Bu yapı mevcut sistemin üzerine kontrollü refactor yapmak için temel plan olarak kullanılmalıdır.