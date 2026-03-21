# PHASE 04 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Ödeme sistemi olmadığı için:
👉 WhatsApp funnel kullanılacak

---

## 💬 WHATSAPP LINK

format:

https://wa.me/905XXXXXXXXX?text=Merhaba, Pro üyelik almak istiyorum. Kullanıcı adım: {{username}}

---

## 🧩 BACKEND

- Auth user bilgisi alınır
- username mesaj içine inject edilir

örnek:

$message = "Merhaba, Pro üyelik almak istiyorum. Kullanıcı adım: " . $user->username;

---

## 🎨 FRONTEND

### CTA Butonları

- “Pro’ya Geç”
- “Tüm özellikleri aç”

---

### Konumlar:

- dashboard üst banner
- kilitli feature alanı
- pricing kartı

---

## 🧠 KİLİTLİ FEATURE CTA

örnek:

🔒 Bu özellik Pro plan ile aktif edilir  
👉 [Pro’ya Geç]

---

## 📦 PRO AVANTAJ LİSTESİ

kısa ve net:

- sınırsız link
- ürün ekleme
- özel tema
- verified rozet
- analizler

---

## 🔁 FLOW

1. kullanıcı kilitli alana girer
2. CTA görür
3. butona basar
4. WhatsApp açılır
5. mesaj hazır gider

---

## ⚠️ DİKKAT

- numara doğru olmalı
- mesaj encode edilmeli (url safe)
- mobilde sorunsuz çalışmalı

---

## 🔧 TEST

- butona basınca WhatsApp açılıyor mu?
- mesaj doğru mu?
- username doğru geliyor mu?