
---

# `AGENT.md`

```md
# AGENT.md

## Proje Bağlamı
Bu görev, BYOO.PRO projesinde yalnızca **Tasarım sekmesini** geliştirmek içindir. Amaç, mevcut Laravel admin panel düzenini bozmadan; kullanıcıya daha güçlü bir tasarım editörü deneyimi sunmaktır.

Bu görev, tüm panel redesign görevi değildir.

---

# 1. ANA GÖREV

Agent’ın görevi:
- mevcut Tasarım sekmesini incelemek
- mevcut panel iskeletini korumak
- tasarım alanını alt sekmeli hale getirmek
- canlı önizleme + sonradan kaydetme akışını kurmak
- header/hero alanını varyasyonlu hale getirmek
- yalnızca hedef modülde iyileştirme yapmaktır

---

# 2. EN KRİTİK KURAL

## Mevcut panel yapısı korunacak
Agent:
- sidebar yapısını bozmayacak
- sayfa iskeletini tamamen değiştirmeyecek
- tüm yönetim panelini yeniden tasarlamayacak
- sadece Tasarım sekmesini geliştirecek

Buradaki amaç:
- başka bir ürünü birebir kopyalamak değil
- gelişmiş tasarım düzenleme davranışlarını mevcut sisteme uyarlamaktır

---

# 3. TEMEL DAVRANIŞ HEDEFLERİ

Agent aşağıdaki davranışları sisteme kazandırmalıdır:

1. Tasarım alanı alt sekmelere ayrılmalı
   - Header
   - Tema
   - Arka Plan
   - Butonlar
   - Renkler

2. Kullanıcı yaptığı değişiklikleri anlık görmeli

3. Bu değişiklikler veritabanına anında yazılmamalı

4. Kullanıcı son görünümü beğenince Kaydet ile kalıcı hale getirmeli

5. Header alanı sabit tek tip olmamalı; farklı layout/hero varyasyonları desteklenmeli

---

# 4. HEADER / HERO YAKLAŞIMI

Agent şu noktayı temel kabul etmelidir:

Header alanı yalnızca “profil fotoğrafı + isim” alanı değildir. Bu modül, profil sayfasının üst bölümünün bütün görsel yerleşimini yönetir.

## Agent’ın desteklemesi gereken yapılar:
- avatar yükleme / değiştirme
- avatar boyutu
- avatar frame tipi
- avatar konumu
- isim görünürlüğü
- kullanıcı adı görünürlüğü
- bio görünürlüğü
- başlık renk/font/boyut
- header layout presetleri
- hero benzeri geniş üst alan yapıları

## Minimum header layout presetleri:
- centered-classic
- minimal-stack
- hero-cover
- card-header
- left-aligned-profile
- compact-header

Agent bu modülü basit bir form alanı gibi değil, ayrı bir üst alan yerleşim sistemi olarak ele almalıdır.

---

# 5. KORUNMASI GEREKENLER

Agent aşağıdakileri mümkün olduğunca korumalıdır:
- mevcut tasarım sekmesinin sayfa içindeki konumu
- mevcut admin layout yapısı
- mevcut tema preset mantığı
- mevcut bileşenlerden yararlanılabiliyorsa onları kullanma yaklaşımı
- mevcut veri yapısına uyumluluk

---

# 6. ÖNERİLEN TEKNİK YAKLAŞIM

## Öncelikli çözüm
Eğer mevcut yapı Blade tabanlıysa:
- Alpine.js ile draft state
- save sırasında backend submit
en uygun çözümdür.

## Agent şunu yapmamalı:
- küçük modül için tüm frontend stack’i değiştirmek
- React/Vue geçişi önermek
- mevcut çalışan blade yapısını gereksiz yere kırmak

---

# 7. MODÜL BAZLI SORUMLULUKLAR

## 7.1 Header
Agent:
- üst alan varyasyonlarını eklemeli
- header preview’ını anlık güncellemeli
- toggle ve preset mantığını net kurmalı

## 7.2 Tema
Agent:
- mevcut presetleri korumalı
- seçim davranışını iyileştirmeli
- custom override mantığını desteklemeli

## 7.3 Arka Plan
Agent:
- solid / gradient / pattern / image tiplerini desteklemeli
- overlay / blur mantığını kurmalı

## 7.4 Butonlar
Agent:
- preset button stilleri sunmalı
- radius, border, align ve renk ayarlarını canlı önizlemeli

## 7.5 Renkler
Agent:
- genel renk kontrolünü merkezi hale getirmeli
- seçilen renkleri ilgili preview alanlarına bağlamalı

---

# 8. CANLI ÖNİZLEME YAKLAŞIMI

Agent preview sisteminde şu kurala uymalı:
- preview önce draft state’i okur
- persisted state yalnızca başlangıç referansı olur
- save yapılmadan DB güncellenmez

Bu görevde autosave istenmiyor.

---

# 9. UI İLKELERİ

Agent şu tasarım ilkelerine uymalı:
- seçili seçenekler belirgin olmalı
- ayar grupları birbirinden net ayrılmalı
- preview alanı sade ama etkili olmalı
- kullanıcı hangi değişikliğin neyi etkilediğini anlamalı
- Tasarım sekmesi kalabalık değil, modüler görünmeli

---

# 10. YAPILMAMASI GEREKENLER

Agent aşağıdakileri yapmamalıdır:
- tüm paneli baştan tasarlamak
- sadece referans ürüne benzetmek için mevcut UI’ı bozmak
- tüm değişiklikleri otomatik kaydetmek
- header modülünü sadece avatar değiştirme alanına indirgemek
- mevcut sistemin tema mantığını tamamen çöpe atmak

---

# 11. ÇALIŞMA SIRASI

Agent aşağıdaki sıraya göre ilerlemelidir:

1. mevcut Tasarım sekmesini incele
2. state ayrımını planla
3. alt sekmeli yapı kur
4. preview panelini draft state’e bağla
5. Header/Hero modülünü ekle
6. Tema modülünü geliştir
7. Arka plan modülünü ekle
8. Butonlar modülünü ekle
9. Renkler modülünü ekle
10. save akışını tamamla

---

# 12. BAŞARI TANIMI

Agent başarılı sayılırsa:
- Tasarım sekmesi belirgin biçimde güçlenmiş olur
- Header alanı varyasyonlu hale gelir
- Kullanıcı anlık sonucu görür
- değişiklikler sadece Kaydet sonrası kalıcı olur
- mevcut panel düzeni korunur
- sistem gelecekte daha da büyütülebilecek modüler bir yapıya kavuşur

---

# 13. KISA YÖNERGE

Bu görev için ana motto:

**“Mevcut paneli bozmadan, Tasarım sekmesini canlı önizlemeli ve varyasyonlu bir görsel editöre dönüştür.”**