# PHASE 02 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Bu fazda sadece veri ve backend mantığı kurulacak.
UI tarafına müdahale edilmeyecek.

---

## 🗄️ DATABASE

users tablosuna şu alanlar eklenecek:

plan ENUM('free','pro') default 'free'
plan_expire_date DATETIME nullable
is_verified BOOLEAN default false
onboarding_completed BOOLEAN default false

---

## ⚙️ MODEL UPDATE

User modeline:

- plan kontrol helper
- isPro() fonksiyonu

örnek:

public function isPro()
{
    return $this->plan === 'pro';
}

---

## 🧩 MIDDLEWARE

Yeni middleware:

checkPlan

kullanım:

->middleware('checkPlan:pro')

---

## 🧠 MIDDLEWARE MANTIĞI

- kullanıcı giriş yapmış mı kontrol et
- planı kontrol et
- uygun değilse:
  - redirect veya hata dön

---

## 🔁 FLOW

- kullanıcı giriş yapar
- request sırasında plan kontrol edilir
- ilgili alanlara erişim izni verilir/verilmez

---

## ⚠️ DİKKAT

- mevcut auth sistemi bozulmamalı
- kullanıcı login flow etkilenmemeli
- migration güvenli yapılmalı

---

## 🔧 TEST SENARYOLARI

- yeni kullanıcı oluştur → plan free mi?
- plan manuel değiştir → sistem algılıyor mu?
- middleware doğru çalışıyor mu?