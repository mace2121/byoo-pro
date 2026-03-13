# byoo.pro Implementation Plan

## MVP Architecture

Laravel Monolith

Modules:

Auth
Profiles
Links
Public Page
Analytics

---

# Migration Sırası

1 users (default)

2 profiles

3 links

4 profile_views

5 click_logs

6 plans

7 subscriptions

---

# Auth

Laravel Breeze veya custom auth

username zorunlu olacak.

email unique olacak.

---

# Profil

User → Profile relation

1 user
1 profile

username unique olacak.

---

# Link Yönetimi

User → Links relation

1 user
N links

Link order column kullanılacak.

---

# Public Profil

Route:

/{username}

Controller:

ProfileController@show

Query:

profile by username

---

# Click Tracking

Route:

/l/{link_id}

Logic:

click log oluştur
redirect

---

# Dashboard

Controller:

DashboardController

Stats:

links count
click count
profile views

---

# Admin

middleware:

is_admin

Admin routes:

/admin/users
/admin/stats

---

# SaaS Plan

plans table

id
name
max_links
max_views
features

subscriptions

user_id
plan_id
status

---

# Performance

cache public profiles

optimize queries
