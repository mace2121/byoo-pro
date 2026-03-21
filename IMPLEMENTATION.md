# BYOO.PRO v2 Beta – Technical Implementation

## 1. Block Builder System

### Purpose
Convert the profile page into a modular block system.

### Database

blocks table

id  
user_id  
type (link | product)  
title  
description  
image  
url  
button_type  
button_link  
position  
created_at  
updated_at

---

### Block Types

link

title  
url  
icon

product

title  
description  
image  
price (optional)  
button_type  
button_link

---

### Rendering Logic

Profile page will loop through blocks ordered by position.

Example:

foreach($blocks as $block){
 renderBlock($block)
}

---

## 2. Product Blocks

### Fields

title  
description  
image  
price  
button_type  
button_link

### Button Types

- whatsapp
- external_link

---

### Product Display

Product card includes:

image  
title  
description  
button

---

## 3. WhatsApp Redirect System

### Format

https://wa.me/{phone}?text={message}

### Example

https://wa.me/905xxxxxxxxx?text=Merhaba ürün hakkında bilgi almak istiyorum

---

### Laravel Helper

generateWhatsAppLink($phone,$message)

---

## 4. Drag & Drop Block Ordering

### UI

Use:

SortableJS

Users can drag blocks.

---

### Backend

Update block position field.

Example API

POST /blocks/reorder

Payload

[
 {id:1,position:1},
 {id:2,position:2}
]

---

## 5. Smart Link Preview

### Process

When user adds link:

1. fetch page
2. parse metadata
3. extract:

title  
favicon  
og:image

---

### Storage

link_previews table

id  
url  
title  
favicon  
image

Cache previews to avoid repeated requests.

---

## 6. Verified Profile Badge

### Database

users table

verified boolean

---

### UI

Display badge next to username.

Example

Mahsum Çetintaş ✔

---

### Admin Panel

Admin can toggle verification.

---

## 7. Rendering Order

Profile page rendering order:

1 profile header  
2 verified badge  
3 blocks list

---

## Future Ready

Block system allows adding:

- image blocks
- video blocks
- shop blocks
- payment blocks