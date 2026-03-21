# PHASE 03 — IMPLEMENTATION

## 🧠 GENEL YAKLAŞIM

Bu fazda:
- backend limit kontrolü
- frontend kilitleme UI
birlikte çalışacak.

---

## 🔢 LINK LIMIT

### Backend:

Link ekleme sırasında:

if ($user->plan === 'free' && $user->links()->count() >= 5) {
    return error('Free plan limiti doldu');
}

---

## 🧩 FEATURE CHECK HELPER

User modeline ekle:

public function canAccess($feature)
{
    if ($this->plan === 'pro') return true;

    $restricted = [
        'product',
        'custom_theme',
        'custom_css',
        'verified'
    ];

    return !in_array($feature, $restricted);
}

---

## 🎨 FRONTEND (KRİTİK)

### Kilitli UI

- blur efekti
- 🔒 icon
- hover tooltip

---

### Tooltip mesaj:

“Bu özellik Pro plan ile aktif edilir”

---

## 🧠 KULLANIM ÖRNEĞİ

@if(!$user->canAccess('product'))
   disabled + lock UI
@endif

---

## ⚠️ BACKEND GÜVENLİK

Frontend kilitleme yeterli değil.

- Controller içinde de kontrol yapılmalı
- API seviyesinde erişim engellenmeli

---

## 🔁 FLOW

1. kullanıcı feature’a tıklar
2. plan kontrol edilir
3. free ise:
   - işlem yapılmaz
   - uyarı gösterilir

---

## 🔧 TEST SENARYOLARI

- Free kullanıcı 6. link ekleyebilir mi? (hayır)
- Free kullanıcı ürün ekleyebilir mi? (hayır)
- Pro kullanıcı her şeyi yapabiliyor mu? (evet)
- UI kilitli mi? (evet)