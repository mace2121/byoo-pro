# PHASE 10 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Bu faz:
👉 platforma dönüşüm fazıdır

Amaç:
- kullanıcı üretir
- diğer kullanıcı kullanır

---

## 🗄️ DATABASE

### themes table

- id
- name
- slug
- user_id (oluşturan)
- is_premium (boolean)
- is_active (boolean)
- is_approved (boolean)
- preview_image
- config_json
- created_at
- updated_at

---

## 🧩 THEME CONFIG

config_json içinde:

- renkler
- font
- button style
- background
- custom css

---

## 👤 USER THEME

users tablosuna:

- theme_id

---

## 🧠 THEME TYPES

### FREE
- herkes kullanabilir

### PRO
- sadece pro kullanıcı

### USER THEME
- kullanıcı üretir
- marketplace’e gönderir

---

## 🛠️ USER FLOW

### Tema Oluşturma

1. kullanıcı tasarım yapar
2. “tema olarak kaydet” butonuna basar
3. isim girer
4. sistem theme olarak kaydeder

---

### Marketplace’e Gönderme

- kullanıcı “yayınla” der
- is_approved = false

---

### Admin Onay

- admin temayı inceler
- onaylarsa:
  is_approved = true

---

## 🛍️ MARKETPLACE PAGE

### Liste:

- tema kartları
- preview görsel
- tema adı
- creator

---

### Filtre:

- free
- pro
- topluluk temaları

---

## 🎨 THEME PREVIEW

- küçük demo görünüm
- canlı preview (opsiyonel)

---

## 🔁 THEME APPLY

kullanıcı tema seçer:

$user->theme_id = X

---

## 🔒 ERİŞİM KONTROLÜ

### Free kullanıcı:
- sadece free temalar

### Pro kullanıcı:
- tüm temalar

---

## ⚠️ DİKKAT

- kötü tema sistemi bozmamalı
- config güvenli parse edilmeli
- performans korunmalı

---

## 🔧 TEST

- kullanıcı tema oluşturabiliyor mu?
- marketplace listeleniyor mu?
- admin onay sistemi çalışıyor mu?
- tema uygulanıyor mu?