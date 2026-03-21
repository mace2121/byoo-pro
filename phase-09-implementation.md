# PHASE 09 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Bu faz 3 ana parçadan oluşur:

1. Custom domain tamamlanması
2. Link scheduling
3. Profil share experience

Bu fazda QR özelliği YOKTUR.

---

## 🌐 CUSTOM DOMAIN

### Amaç
Kullanıcı kendi domainini sisteme bağlayabilsin.

### Gerekli Alanlar

users veya ayrı domain tablosu üzerinden yapı kurulabilir.

Önerilen domain tablosu:

- id
- user_id
- domain
- status
- verified_at
- created_at
- updated_at

### Domain Status
- pending
- active
- failed

### Mantık
- kullanıcı panelden domain girer
- sistem DNS yönlendirme bilgisini gösterir
- host bilgisi üzerinden kullanıcı eşleştirilir
- aktif domain varsa profil o domain üzerinden açılır

### Teknik Not
Laravel tarafında host kontrolü:
request()->getHost()

### UI
Kullanıcı panelinde:
- domain ekleme alanı
- DNS yönlendirme rehberi
- durum göstergesi:
  - bekliyor
  - aktif
  - hatalı

### Kısıt
Bu özellik sadece Pro kullanıcıya açık olmalı.

---

## ⏰ LINK SCHEDULING

### Amaç
Linklerin belirli tarih aralığında görünmesini sağlamak.

### Database

links tablosuna alan eklenir:

- starts_at nullable datetime
- ends_at nullable datetime

### Mantık
Bir link şu koşullarda görünür:

- starts_at boşsa hemen aktif kabul edilir
- ends_at boşsa süresiz kabul edilir
- şimdi zamanı starts_at sonrası ve ends_at öncesindeyse görünür
- süre bittiyse gizlenir

### Örnek Kullanım
- kampanya linki 3 gün görünsün
- etkinlik linki belli tarihte otomatik kapansın

### Backend
Link query tarafında sadece aktif linkler döndürülmeli.

### Panel UI
Link düzenleme alanında:
- başlangıç tarihi
- bitiş tarihi
- zamanlama bilgisi etiketi

### Kısıt
Bu özellik sadece Pro kullanıcıya açık olmalı.

---

## 🔗 PROFIL TOP AREA IMPROVEMENTS

### Sol Üst Icon
Ekran görüntüsündeki 2 numaralı alan:

- mevcut boş alan kaldırılacak
- yerine sistemin küçük brand iconu yerleştirilecek
- bu alan sabit konumda olacak
- profile theme yapısını bozmayacak

### Sağ Üst Share Button
Ekran görüntüsündeki 1 numaralı alan:

- sağ üstte share / external style icon olacak
- tıklanınca paylaşım katmanı açılacak

---

## 📤 SHARE MODAL / BOTTOM SHEET

### Davranış
- mobilde bottom sheet gibi açılabilir
- desktopta modal olabilir
- overlay ile çalışmalı
- kapatma butonu bulunmalı

### İçerik
- profil görseli
- kullanıcı adı
- profil linki

### Aksiyonlar
- Link kopyala
- X
- Facebook
- WhatsApp
- LinkedIn
- Telegram
- Email
- Messenger

### Link Üretimi
Paylaşım linkleri aktif profil URL’sine göre dinamik oluşturulmalı.

Örnek:
- subdomain kullanıyorsa onun linki
- custom domain aktifse custom domain linki

### Copy Link
- navigator.clipboard ile kopyalama
- başarılı durumda kısa toast / mesaj gösterimi

---

## 🎨 UI/UX NOTLARI

- premium ve sade görünmeli
- profil görünümünü bozmamalı
- ikonlar theme ile uyumlu olmalı
- mobil öncelikli düşünülmeli

---

## 🔒 ERİŞİM KONTROLÜ

### Free Kullanıcı
- custom domain kullanamaz
- scheduling kullanamaz

### Tüm Ziyaretçiler
- paylaş butonu ve share modal herkese açık profilde çalışabilir

---

## 🔧 TEST SENARYOLARI

### Custom Domain
- pro kullanıcı domain ekleyebiliyor mu
- host doğru kullanıcıya gidiyor mu
- domain durumu panelde doğru görünüyor mu

### Scheduling
- zamanı gelmeyen link gizli mi
- zamanı geçen link gizli mi
- aktif tarih aralığındaki link görünüyor mu

### Share
- buton açılıyor mu
- link doğru kopyalanıyor mu
- sosyal paylaşım linkleri doğru çalışıyor mu
- mobilde düzgün görünüyor mu