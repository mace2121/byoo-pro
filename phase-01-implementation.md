# PHASE 01 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Mevcut auth sistemi korunacak, sadece:
- UI modernize edilecek
- Google login eklenecek

---

## 🖥️ FRONTEND

### Login/Register UI
- split screen layout
- sol taraf: görsel / branding
- sağ taraf: form

### Kullanılacak yapı:
- Tailwind CSS
- component bazlı yapı

---

## 🔐 BACKEND

### Google Login

Laravel Socialite kullanılacak:

composer require laravel/socialite

.env:
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

---

## 🗄️ DATABASE

users tablosuna ek:

google_id (nullable)
provider (nullable)
avatar (nullable)

---

## 🔁 FLOW

### Google login:
1. kullanıcı Google’a yönlendirilir
2. geri dönüş alınır
3. kullanıcı varsa giriş yapılır
4. yoksa yeni kullanıcı oluşturulur

---

## 🌐 ROUTES

/login
/register
/auth/google
/auth/google/callback

---

## ⚠️ DİKKAT

- mevcut auth kırılmamalı
- kullanıcı session sistemi bozulmamalı
- hatalı login durumları handle edilmeli

---

## 🎨 UI NOTLARI

- inputlar modern olmalı
- butonlar net CTA içermeli
- mobil uyumlu olmalı