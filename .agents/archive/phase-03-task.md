# PHASE 03 — FREE vs PRO LIMIT SYSTEM

## 🎯 AMAÇ
FREE ve PRO kullanıcılar arasında özellik farkını oluşturmak ve FREE kullanıcıyı Pro’ya yönlendiren kilitli sistem kurmak.

---

## ✅ YAPILACAKLAR

- Free kullanıcı için link limiti (max 5)
- Pro olmayan kullanıcılar için:
  - ürün ekleme kapatılacak
  - gelişmiş tema ayarları kapatılacak
  - custom CSS kapatılacak
  - verified özelliği kapalı olacak
- Kilitli özellik UI (🔒 icon + tooltip)
- Backend’de limit kontrolü

---

## ❌ YAPILMAYACAKLAR

- WhatsApp ödeme (phase 04)
- Admin panel yönetimi (phase 05)
- Analytics sistemi (phase 08)
- Custom domain (phase 09)

---

## 🔗 DEPENDENCIES

- Plan sistemi hazır olmalı (phase 02)
- Auth sistemi çalışıyor olmalı (phase 01)

---

## ✅ ACCEPTANCE CRITERIA

- Free kullanıcı 5’ten fazla link ekleyemez
- Pro kullanıcı sınırsız ekleyebilir
- Kilitli özellikler UI’da görünür ama kullanılamaz
- Tooltip ile “Pro plan gerekli” mesajı gösterilir
- Backend tarafında da kontrol vardır (hacklenemez)

---

## 🚀 TESLİM

- Sistem Free vs Pro ayrımı yapabiliyor olmalı
- Kullanıcı Pro’ya geçmeye teşvik edilmeli