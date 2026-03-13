# byoo.pro - Agent Context

## Proje Tanımı

byoo.pro, Linktree mantığında çalışan bir SaaS platformudur.

Kullanıcılar:

- kayıt olur
- profil oluşturur
- link ekler
- tek bir sayfa üzerinden linklerini paylaşır

Örnek profil:

byoo.pro/kullaniciadi

---

# Sunucu Ortamı

Provider: Hostinger VDS  
OS: Ubuntu

Domain:
byoo.pro  
www.byoo.pro

Sunucu mimarisi:

Internet
→ Traefik (Docker SSL reverse proxy)
→ byoo-proxy container
→ Laravel Application (port 8081)

---

# Container Yapısı

Traefik:
- SSL termination
- Let's Encrypt
- entrypoints: 80 / 443

byoo-proxy:
- nginx container
- Traefik tarafından yönlendiriliyor

Laravel:
- Host üzerinde
- port: 8081

---

# Laravel Ortamı

Laravel Version:
12.x

Laravel Path:
/var/www/byoo/app

Laravel Serve Port:
8081

---

# Git Repository

GitHub repo:

https://github.com/mace2121/byoo-pro

Git deploy mantığı:

Local development
→ git commit
→ git push

Server:

cd /var/www/byoo/app
git pull origin main

composer install --no-dev
php artisan optimize

---

# Antigravity Kullanımı

Antigravity yalnızca development ortamında kullanılacaktır.

Production server üzerinde AI agent çalıştırılmtayacaktır.

Workspace root:
Laravel project root

---

# İlk Hedef (MVP)

Minimum çalışan sistem:

1. Auth sistemi
2. Kullanıcı profili
3. Link ekleme
4. Public profil sayfası
5. Click tracking
6. Basit dashboard

---

# Route Yapısı

Public profil route:

/{username}

Dashboard route:

/dashboard

Admin route:

/admin

---

# Database Temel Yapı

users
profiles
links
profile_views
click_logs
plans
subscriptions

---

# Temel Modüller

Auth
Profile management
Link management
Public profile page
Analytics
Admin
Plans / Subscriptions

---

# Kodlama Kuralları

- Kod sade ve modüler olacak
- Gereksiz package kullanılmayacak
- Migration ile ilerle
- Büyük değişiklikten önce plan üret
- Commit öncesi review yapılmalı
- .env commit edilmez

---

# UI Kuralları

Frontend:

Blade + Tailwind

Tasarım:

minimal
mobile-first
fast loading

---

# Performans Kuralları

- N+1 query önlenmeli
- index kullanılmalı
- cache stratejisi uygulanmalı
- click loglar optimize edilmeli

---

# Güvenlik

CSRF
XSS
SQL Injection
Rate limit
Auth middleware

---

# Fazlar

Faz 1
Auth + Profiles + Links

Faz 2
Analytics

Faz 3
SaaS Plans

Faz 4
Custom domains
