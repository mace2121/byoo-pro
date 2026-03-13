# AGENT.md

## Proje Kimliği
Bu proje, BYOO.PRO isimli Laravel tabanlı bio link / mini profil / bağlantı yönetim platformudur.

Agent’ın görevi, mevcut çalışan Laravel sistemini sıfırdan dağıtmadan; hataları gidererek, arayüzü profesyonelleştirerek, Türkçeleştirerek ve yeni yönetim özellikleri ekleyerek ürünü üretim seviyesine yaklaştırmaktır.

---

# 1. TEMEL ÇALIŞMA KURALLARI

## 1.1 Sıfırdan Başlama Yok
Bu projede yaklaşım:
- var olan sistemi koru
- çalışan parçaları bozma
- sadece gerekli alanları iyileştir
- mevcut deploy ve repo yapısını yeniden kurmaya çalışma

## 1.2 Önce Var Olanı Kontrol Et
Her geliştirmeden önce:
- ilgili dosya zaten var mı?
- aynı iş daha önce yapıldı mı?
- mevcut kod iyileştirilebilir mi?
- yeni dosya açmadan mevcut yapı genişletilebilir mi?

## 1.3 Tekrar Eden İş Yapma
Aşağıdaki işler önceki aşamalarda yapıldı ve yeniden yapılmayacak:
- sunucu temel kurulumları
- domain / SSL ayarları
- Traefik temel kurulumu
- Docker tabanlı servis ayağa kaldırma
- GitHub repo oluşturma
- temel deploy mantığı
- Laravel uygulamasını ayağa kaldırma

Agent bu alanlarda yeniden kurulum önermemeli; yalnızca ihtiyaç varsa bakım veya iyileştirme önermelidir.

---

# 2. ÖNCELİK STRATEJİSİ

Agent aşağıdaki sırayı izlemeli:

1. Kırık / hata veren modülleri düzelt
2. İngilizce kalan alanları temizle
3. Dashboard ve panel deneyimini iyileştir
4. Canlı önizleme ve tema editörünü geliştir
5. Link ikon sistemini geliştir
6. Süper admin ve raporlama alanlarını ekle

---

# 3. TASARIM YAKLAŞIMI

## 3.1 Hedef Görünüm
Panel görünümü:
- Laravel starter kit gibi görünmemeli
- modern SaaS panel hissi vermeli
- temiz, profesyonel, düzenli olmalı
- aşırı renkli değil kontrollü güçlü görünmeli

## 3.2 UI İlkeleri
- boş alan kullanımı dengeli olmalı
- kartlar tutarlı olmalı
- tüm butonlar aynı tasarım diline sahip olmalı
- istatistik kartları sade ama güçlü görünmeli
- form alanları okunaklı ve modern olmalı
- canlı önizleme admin panelin doğal parçası gibi durmalı

## 3.3 Önizleme Yaklaşımı
Telefon mockup kullanılmayacak.
Onun yerine:
- admin arayüzüne uyumlu preview container
- masaüstü panel içinde doğal duran canlı görünüm
- gerçek link kartlarını gösteren alan
kullanılacak.

---

# 4. DİL KURALI

Bu projenin kullanıcıya dönük tüm alanları Türkçe olmalıdır.

Agent:
- İngilizce metin bırakmamalı
- yeni eklediği metinleri Türkçe yazmalı
- teknik kavramları kullanıcıya sade Türkçe ile sunmalı
- terminolojiyi tutarlı kullanmalı

Örnek tercih:
- Dashboard yerine “Panel” veya “Genel Bakış”
- Settings yerine “Ayarlar”
- Save yerine “Kaydet”
- Update yerine “Güncelle”

---

# 5. KOD YAZIM KURALI

## 5.1 Mevcut Yapıya Saygı
- mevcut klasör düzenine uygun çalış
- gereksiz yeni mimari kurma
- controller’ları aşırı şişirme
- tekrar eden mantığı service katmanına al

## 5.2 Temiz Kod
- sade isimlendirme
- açıklayıcı method adları
- tek sorumluluk prensibi
- bileşen bazlı arayüz mantığı

## 5.3 Güvenlik
- upload path kontrol edilmeli
- custom css alanı sanitize edilmeli
- rol kontrolü net yapılmalı
- kullanıcılar birbirinin verisine erişememeli

---

# 6. HATA YÖNETİMİ YAKLAŞIMI

Agent hata çözümünde şu sırayı izlemeli:
1. log dosyasını oku
2. gerçek sebebi bul
3. geçici bastırma yerine kök nedeni çöz
4. boş veri durumunu ayrıca ele al
5. kullanıcıya temiz hata / boş durum deneyimi sun

Özellikle:
- Analizler sayfasındaki 500 error öncelikli konudur
- Profil resmi kırık link sorunu ikinci kritik konudur

---

# 7. MODÜL BAZLI SORUMLULUKLAR

## 7.1 Dashboard
Agent:
- placeholder alanları kaldırmalı
- gerçek veriyle çalışan kart sistemi kurmalı
- kullanıcı ve admin için farklı dashboard deneyimi tasarlamalı

## 7.2 Tema Editörü
Agent:
- canlı önizlemeyi güçlendirmeli
- arka plan, blur, renk ve kart stilini desteklemeli
- telefon mockup kullanmamalı

## 7.3 Link Yönetimi
Agent:
- URL’ye göre otomatik ikon önermeli
- kullanıcıya manuel ikon değiştirme imkanı sunmalı
- link formunu daha kullanışlı hale getirmeli

## 7.4 Marka
Agent:
- sistem logosunu panelde görünür kılmalı
- favicon’u sistem logosuyla eşleştirmeli
- auth ve panel alanlarında marka bütünlüğü sağlamalı

## 7.5 Süper Admin
Agent:
- süper admin rolünü net ayırmalı
- kullanıcı listesi, istatistik ve sistem özeti ekranlarını planlamalı
- yönetim ekranlarını sonradan büyüyebilecek şekilde kurgulamalı

---

# 8. YAPILMAMASI GEREKENLER

Agent aşağıdakileri yapmamalıdır:

- her sorunda “projeyi baştan yazalım” yaklaşımı
- daha önce kurulan deploy yapısını yeniden kurmak
- sadece görsel iyileştirme yapıp mantık hatalarını bırakmak
- hardcoded İngilizce metin eklemek
- mockup uğruna kullanım kolaylığını düşürmek
- rol yapısını belirsiz bırakmak
- kullanıcı paneli ile admin panelini aynılaştırmak

---

# 9. ÇALIŞMA BİÇİMİ

Her iş kalemi için şu format izlenmeli:

1. Mevcut durumu incele
2. Aynı iş daha önce yapıldı mı kontrol et
3. En küçük etkili değişiklikle iyileştir
4. UI ve backend birlikte düşün
5. Türkçeleştirmeyi unutma
6. Test et
7. Sonra bir sonraki adıma geç

---

# 10. BAŞARI KRİTERİ

Agent başarılı kabul edilir eğer:

- sistem daha stabil hale gelirse
- 500 hata ortadan kalkarsa
- tüm panel Türkçeleşirse
- kullanıcı dashboard anlamlı hale gelirse
- admin dashboard gerçek yönetim paneli gibi olursa
- canlı önizleme doğal ve kullanışlı çalışırsa
- link ikon sistemi kullanıcı dostu hale gelirse
- sistem logosu ve favicon tutarlı şekilde görünürse
- daha önce yapılan kurulum işleri tekrar edilmeden ilerlenirse

---

# 11. KISA YÖNERGE

Bu proje için ana motto:

**“Çalışanı bozmadan geliştir, tekrar yapma, tamamen Türkçeleştir, starter kit hissini sil, ürünü gerçek SaaS paneline dönüştür.”**