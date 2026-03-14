# IMPLEMENTATION.md

## Proje
BYOO.PRO – Tasarım Sekmesi Canlı Düzenleme Implementasyonu

## Doküman Amacı
Bu doküman, mevcut Laravel tabanlı admin panel yapısı korunarak Tasarım sekmesinin daha gelişmiş, modüler ve canlı önizleme destekli bir düzenleyiciye dönüştürülmesi için teknik uygulama planını açıklar.

Bu implementasyonun ana hedefi, mevcut paneli bozmadan yalnızca tasarım yönetimi modülünü güçlendirmektir.

---

# 1. MEVCUT DURUM

Sistemde şu anda:
- çalışan bir Laravel panel yapısı mevcut
- kullanıcı bazlı tasarım ayarlarının ilk mantığı mevcut
- hazır tema kartları bulunuyor
- sağ tarafta önizleme alanı bulunuyor
- temel tasarım düzenleme deneyimi var

Ancak şu eksikler mevcut:
- tasarım ayarları modüler değil
- header alanı fazla sınırlı
- canlı önizleme davranışı tam ürün seviyesinde değil
- değişiklikler için gelişmiş draft/save akışı yok
- üst alan / hero varyasyonları desteklenmiyor
- buton ve arka plan özelleştirmeleri yeterince derin değil

---

# 2. ANA TEKNİK YAKLAŞIM

## Temel ilke
Kalıcı veri ile düzenleme verisi ayrılmalıdır.

### İki katmanlı state yaklaşımı:
1. Persisted state
   - veritabanında kayıtlı olan gerçek ayarlar
2. Draft state
   - kullanıcının form üzerinde o anda değiştirdiği ama henüz kaydetmediği ayarlar

Bu modülün tüm canlı davranışı draft state üzerinden çalışmalıdır.

---

# 3. FRONTEND MİMARİSİ

## Önerilen yaklaşım
Mevcut Laravel blade altyapısı korunacağı için en düşük kırılma riski olan çözüm tercih edilmelidir.

### Uygun seçenek:
- Alpine.js tabanlı local state
- backend’e save sırasında toplu submit

Gerekirse:
- Livewire + Alpine hibrit yapı kullanılabilir
Ancak küçük bir modül için tüm frontend yapısının değiştirilmesi önerilmez.

---

# 4. STATE YAPISI

## Örnek draft state yapısı
```js
draftDesign = {
  header: {
    layout: 'centered-classic',
    profile_image: null,
    avatar_size: 'md',
    avatar_frame: 'soft-ring',
    avatar_position: 'top-center',
    show_name: true,
    show_username: true,
    show_bio: true,
    title_text: '',
    title_font: 'Inter',
    title_color: '#111111',
    title_size: 'xl',
    hero_enabled: false,
    hero_style: 'none'
  },
  theme: {
    preset: 'minimal',
    custom_theme: false
  },
  background: {
    type: 'solid',
    solid_color: '#ffffff',
    gradient_from: '#6D28D9',
    gradient_to: '#EC4899',
    pattern: null,
    image: null,
    blur: 0,
    overlay: 0
  },
  buttons: {
    style: 'solid',
    radius: 16,
    button_color: '#111111',
    text_color: '#ffffff',
    border_color: '#111111',
    no_border: false,
    text_align: 'center'
  },
  colors: {
    primary: '#111111',
    secondary: '#666666',
    accent: '#22c55e',
    text: '#111111',
    muted_text: '#6b7280'
  }
}