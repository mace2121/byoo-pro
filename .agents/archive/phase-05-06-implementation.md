# PHASE 05-06 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Bu faz:
- admin panel UI
- backend yönetim sistemi
ikisini birlikte içerir.

---

## 🗄️ DATABASE

Ekstra tablo gerekmez (users tablosu yeterli)

---

## 🧩 ADMIN KONTROL

- is_admin middleware oluştur
- sadece admin erişebilmeli

---

## 👤 USER MANAGEMENT

### Liste
- id
- username
- email
- plan
- verified
- created_at

---

### Detay Sayfası

- kullanıcı bilgileri
- plan değiştir butonu
- verified toggle

---

### Plan Güncelleme

controller:

$user->plan = 'pro';
$user->plan_expire_date = now()->addMonth();

---

### Verified

$user->is_verified = true;

---

## 📊 DASHBOARD

### Kartlar:

- toplam kullanıcı:
User::count()

- pro kullanıcı:
User::where('plan','pro')->count()

- free kullanıcı:
User::where('plan','free')->count()

---

### 💰 Gelir

$proCount * 5

---

## 🎨 FRONTEND

### Dashboard UI
- 4 kart:
  - toplam kullanıcı
  - pro kullanıcı
  - free kullanıcı
  - gelir

---

### User Table
- basit ve hızlı
- pagination eklenmeli

---

## 🔁 FLOW

1. admin giriş yapar
2. dashboard açılır
3. kullanıcıları görür
4. kullanıcıyı düzenler

---

## ⚠️ DİKKAT

- sadece admin erişebilmeli
- yanlışlıkla plan değişmemeli
- güvenlik kontrolü olmalı

---

## 🔧 TEST

- admin dışı kullanıcı erişebilir mi? (hayır)
- plan değiştirince sistem güncelleniyor mu?
- verified çalışıyor mu?
- dashboard verileri doğru mu?