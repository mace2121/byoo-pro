# PHASE 07 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Kullanıcı ilk giriş yaptığında:
👉 onboarding overlay başlar

---

## 🗄️ DATABASE

users tablosunda zaten var:

onboarding_completed BOOLEAN

---

## 🔁 FLOW

1. kullanıcı giriş yapar
2. onboarding_completed kontrol edilir

if (!$user->onboarding_completed) {
   onboarding başlat
}

---

## 🎯 ONBOARDING ADIMLARI

1. Sidebar tanıtımı
2. Link ekleme butonu
3. Tasarım editörü
4. Preview alanı
5. Sidebar toggle

---

## 🎨 FRONTEND

### Kullanılacak kütüphane:

- intro.js veya
- shepherd.js

---

## 🧩 UI DAVRANIŞI

- ekran karartılır (overlay)
- ilgili alan highlight edilir
- açıklama gösterilir

---

## 🧠 BUTONLAR

- “İleri”
- “Geri”
- “Turu Atla”
- “Tamamla”

---

## ✅ TAMAMLAMA

kullanıcı bitirince:

$user->onboarding_completed = true;

---

## ⚠️ DİKKAT

- sadece ilk girişte çalışmalı
- performans etkilememeli
- mobilde düzgün çalışmalı

---

## 🔧 TEST

- yeni kullanıcı onboarding görüyor mu?
- skip çalışıyor mu?
- tamamlayınca tekrar açılıyor mu? (açılmamalı)