# TASK.md

## Proje
BYOO.PRO – Tasarım Sekmesi Geliştirme Görevi

## Görev Özeti
Mevcut Laravel tabanlı panel yapısı korunarak, yalnızca **Tasarım sekmesi** daha gelişmiş bir görsel düzenleme alanına dönüştürülecektir. Amaç, kullanıcıların profil sayfasının görünümünü daha detaylı şekilde yönetebilmesi, yaptığı değişiklikleri **anlık canlı önizleme** ile görebilmesi ve son hali onayladıktan sonra **Kaydet** ile kalıcı hale getirebilmesidir.

Bu görev, mevcut paneli baştan tasarlama görevi değildir. Sadece mevcut yapı içinde Tasarım sekmesi genişletilecek ve güçlendirilecektir.

---

# 1. KAPSAM

Bu görev yalnızca aşağıdaki alanları kapsar:
- Tasarım sekmesi içeriği
- canlı önizleme davranışı
- header / hero alanı varyasyonları
- tema seçimi
- arka plan ayarları
- buton stilleri
- renk yönetimi
- draft state + kaydet akışı

Bu görev aşağıdakileri kapsamaz:
- tüm panelin yeniden tasarlanması
- dashboard redesign
- analizler sayfasının yeniden ele alınması
- sidebar yapısının değiştirilmesi
- mevcut genel admin layout’un kırılması
- tüm ürün mimarisinin yeniden kurulması

---

# 2. DAHA ÖNCE YAPILANLAR / TEKRAR YAPILMAYACAKLAR

Aşağıdaki işler mevcut sistemde zaten vardır veya temel olarak kurulmuştur; bu görev kapsamında bunlar sıfırdan yapılmayacaktır:

- Laravel tabanlı admin panel altyapısı
- kullanıcı giriş / kayıt sistemi
- temel kullanıcı paneli
- Tasarım sekmesinin ilk versiyonu
- hazır tema kartlarının temel mantığı
- sağ tarafta önizleme alanı mantığı
- deploy ve repo altyapısı
- sunucu ve domain kurulumları

Bu nedenle hedef:
- sistemi yeniden kurmak değil
- mevcut Tasarım sekmesini ürün seviyesinde iyileştirmektir

---

# 3. ANA HEDEF

Kullanıcı, Tasarım sekmesinde yaptığı değişiklikleri anında görebilmeli; ancak bu değişiklikler veritabanına hemen yazılmamalıdır.

Beklenen akış:
1. Kullanıcı tasarım ayarlarını değiştirir
2. Sağdaki önizleme alanı anlık güncellenir
3. Değişiklikler geçici taslak state içinde tutulur
4. Kullanıcı son hali beğenirse “Kaydet” butonuna basar
5. Ancak bu aşamada kalıcı kayıt yapılır

---

# 4. TASARIM SEKME YAPISI

Tasarım sekmesi kendi içinde alt sekmelere ayrılacaktır.

## Alt sekmeler:
- Header
- Tema
- Arka Plan
- Butonlar
- Renkler

Bu sekmeler mevcut Tasarım ekranı içinde çalışacak, yeni bir bağımsız modül gibi davranmayacak.

---

# 5. HEADER MODÜLÜ – DİNAMİK ÜST ALAN

Header alanı sadece profil fotoğrafı değiştirilen basit bir bölüm değildir. Kullanıcının profil sayfasındaki üst alanın genel görünümünü ve yerleşimini belirleyen modül olacaktır.

## Header modülünde desteklenecek ana özellikler:
- profil görseli yükleme/değiştirme
- avatar boyutu
- avatar çerçeve tipi
- avatar konumu
- isim göster/gizle
- kullanıcı adı göster/gizle
- açıklama / bio göster-gizle
- başlık hizası
- başlık fontu
- başlık rengi
- başlık boyutu
- header layout seçimi
- hero benzeri üst alan varyasyonları

## Header / Hero layout varyasyonları
İlk sürümde en az aşağıdaki preset yapılar desteklenecek:
- klasik merkez hizalı avatar + isim
- minimal header
- geniş hero alanı + avatar
- kartlı üst alan
- sol hizalı profil düzeni
- sade metin ağırlıklı üst alan

## Davranış
Kullanıcı header tipi değiştirdiğinde:
- önizleme alanı anında güncellenmeli
- profil bloğunun yerleşimi değişmeli
- isim / kullanıcı adı / açıklama alanları seçilen layout’a göre yeniden hizalanmalı

---

# 6. TEMA SEKME ÖZELLİKLERİ

Tema sekmesi mevcut tema sistemini koruyarak genişletilecektir.

## Desteklenecek davranışlar:
- hazır tema kartları
- seçili tema vurgusu
- özel tema mantığı
- tema kartına tıklayınca anlık önizleme
- tema ile birlikte bazı varsayılan renk ve buton presetlerinin gelmesi

## Not
Mevcut tema kartları silinmeyecek, gerekirse geliştirilerek korunacaktır.

---

# 7. ARKA PLAN SEKME ÖZELLİKLERİ

Kullanıcı arka planı daha özgürce özelleştirebilmelidir.

## İlk sürümde desteklenecek alanlar:
- düz renk arka plan
- gradient arka plan
- pattern / yüzey seçimi
- arka plan görseli yükleme
- overlay yoğunluğu
- blur / yumuşatma etkisi

## İleri düzey ama opsiyonel alanlar:
- arka plan hizalama
- cover / contain seçenekleri
- ayrı masaüstü / mobil varyasyonları

---

# 8. BUTONLAR SEKME ÖZELLİKLERİ

Link kartları / butonları için gelişmiş stil yönetimi eklenecektir.

## Stil presetleri:
- Solid
- Glass
- Outline
- Offset

## Ayarlar:
- köşe yuvarlaklığı
- buton arka plan rengi
- metin rengi
- border rengi
- border açık / kapalı
- metin hizası
- gölge yoğunluğu (opsiyonel)
- ikon-metin aralığı (opsiyonel)

## Beklenen davranış
Kullanıcı bu ayarlarda değişiklik yaptığında link önizlemeleri anında değişmelidir.

---

# 9. RENKLER SEKME ÖZELLİKLERİ

Genel renk sistemi ayrı bir kontrol alanı olarak yönetilecektir.

## Alanlar:
- ana renk
- yardımcı renk
- accent rengi
- metin rengi
- ikincil metin rengi
- buton rengi
- border rengi

## Davranış
Renk seçildiğinde:
- önizleme anlık değişmeli
- ilgili bileşenler otomatik uyumlu görünmeli

---

# 10. CANLI ÖNİZLEME

## Temel kurallar
- Önizleme alanı mevcut panel içinde kalmalı
- Panel layout bozulmamalı
- Önizleme admin panele uyumlu görünmeli
- Telefon mockup zorunlu değildir
- Önizleme gerçek ürün hissi veren bir “preview container” olarak kurgulanmalıdır

## Önizlemede anlık değişecek alanlar:
- header / hero görünümü
- avatar yapısı
- isim / kullanıcı adı / bio
- arka plan tipi
- tema seçimi
- buton stili
- renk sistemi
- hizalama
- radius
- border / shadow yapısı

---

# 11. KAYDET AKIŞI

## Zorunlu işleyiş
- Kullanıcı ayar değiştirir
- Değişiklikler geçici state’te tutulur
- Veritabanına anında yazılmaz
- Kullanıcı “Kaydet” dediğinde tek seferde kayıt yapılır

## Geri bildirim
- Kaydet sonrası başarı bildirimi gösterilmeli
- Kaydedilmemiş değişiklik varsa buton aktif hale gelebilir
- Hatalı alanlarda kullanıcı yönlendirilmeli

---

# 12. TEKNİK VERİ GRUPLARI

Ayarlar mantıksal olarak şu başlıklarda ele alınmalıdır:
- header_settings
- theme_settings
- background_settings
- button_settings
- color_settings

Bunlar ister JSON ister ayrı kolonlarla saklansın, kod tarafında grup yapısı korunmalıdır.

---

# 13. ÖNCELİK SIRASI

## Faz 1
- Taslak state + canlı önizleme altyapısı
- Header sekmesi
- Tema sekmesi

## Faz 2
- Arka Plan sekmesi
- Butonlar sekmesi
- Renkler sekmesi

## Faz 3
- hero varyasyonlarının artırılması
- görsel arka plan detayları
- gelişmiş overlay / blur kontrolleri
- kaydedilmemiş değişiklik uyarıları

---

# 14. TAMAMLAMA KRİTERLERİ

Bu görev tamamlanmış sayılırsa:
- Tasarım sekmesi alt sekmelere ayrılmış olur
- Header alanı dinamik / varyasyonlu hale gelir
- Kullanıcı değişiklikleri anlık görür
- Değişiklikler Kaydet’e kadar kalıcı olmaz
- Mevcut panel düzeni bozulmaz
- Tasarım sekmesi belirgin şekilde daha profesyonel ve güçlü hale gelir