# PHASE 02 — USER PLAN SYSTEM

## 🎯 AMAÇ
Kullanıcıları FREE ve PRO olarak ayıran temel plan altyapısını kurmak.

---

## ✅ YAPILACAKLAR

- users tablosuna plan alanı ekle (free / pro)
- plan_expire_date alanı ekle
- is_verified alanı ekle
- onboarding_completed alanı ekle
- plan kontrol mantığını oluştur
- middleware altyapısını hazırla (checkPlan)

---

## ❌ YAPILMAYACAKLAR

- UI tarafında kilitleme (phase 03)
- Pro satın alma sistemi (phase 04)
- Admin panel entegrasyonu (phase 05)
- Özellik kısıtlamaları (phase 03)

---

## 🔗 DEPENDENCIES

- Auth sistemi çalışıyor olmalı (phase 01)
- users tablosu mevcut olmalı

---

## ✅ ACCEPTANCE CRITERIA

- Yeni kullanıcı default olarak FREE plan ile oluşturulmalı
- Kullanıcı planı sistemde okunabiliyor olmalı
- Middleware ile plan kontrolü yapılabiliyor olmalı
- is_verified alanı çalışır durumda olmalı
- onboarding alanı kayıt edilebilir olmalı

---

## 🚀 TESLİM

- Plan sistemi backend olarak hazır olmalı
- Diğer fazların kullanabileceği sağlam bir altyapı kurulmuş olmalı