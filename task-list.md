# byoo.pro Task List

## Faz 0 - Altyapı

✔ Hostinger VDS kuruldu  
✔ Laravel kuruldu  
✔ Domain yayında  
✔ Traefik SSL aktif  
✔ Docker proxy yapılandırıldı  
✔ Git deploy sistemi kuruldu  

---

# Faz 1 - Authentication

- kullanıcı kayıt
- kullanıcı giriş
- şifre reset
- email doğrulama
- username validation

---

# Faz 2 - Profil Sistemi

profiles migration

alanlar:

id
user_id
username
avatar
bio
theme
is_active

profil düzenleme ekranı

---

# Faz 3 - Link Sistemi

links tablosu

id
user_id
title
url
icon
order
is_active
clicks

işlevler:

link ekle
link düzenle
link sil
drag-drop sıralama

---

# Faz 4 - Public Profil

route:

/{username}

gösterilecek:

avatar
bio
link listesi

responsive layout

---

# Faz 5 - Click Tracking

click_logs tablosu

alanlar:

link_id
ip
device
country
created_at

redirect sistemi

---

# Faz 6 - Dashboard

dashboard

gösterilecek:

toplam click
toplam link
profil görüntülenme

---

# Faz 7 - Admin

admin middleware

admin panel:

kullanıcı listesi
kullanıcı pasif et
istatistik

---

# Faz 8 - SaaS Plan

plans tablosu

free
pro
business

subscriptions tablosu

limit sistemi

---

# Faz 9 - SEO

meta tags
og tags
favicon

---

# Faz 10 - Tema Sistemi

minimal
dark
neon
Glass
Midnight
Sunset
Aurora
Forest
Cyber
Obsidian