# Technical Design & System Architecture

## Architecture Overview
- **Pattern:** MVC (Model-View-Controller) / REST API with Single Page/Mobile-First Views.
- **Deployment:** Local Server (Laravel / Node.js) exposed via local IP (e.g., `192.168.x.x:8000`).
- **PWA Capabilities:** Web App Manifest + Service Worker enabled for "Add to Home Screen" experience on mobile.

---

## Entity Relationship Diagram (Database Schema)

### `categories`
| Field | Type | Constraint |
|---|---|---|
| id | BigInt | Primary Key, Auto Increment |
| name | String | Not Null |
| created_at / updated_at | Timestamp | Default CURRENT_TIMESTAMP |

### `products`
| Field | Type | Constraint |
|---|---|---|
| id | BigInt | Primary Key, Auto Increment |
| category_id | BigInt | Foreign Key -> categories.id |
| name | String | Not Null |
| hpp_price | Decimal(12,2) | Not Null (Cost Price) |
| sell_price | Decimal(12,2) | Not Null (Retail Price) |
| stock | Integer | Default 0 |
| min_stock | Integer | Default 2 |
| created_at / updated_at | Timestamp | Default CURRENT_TIMESTAMP |

### `services` (Preset Labor Rates)
| Field | Type | Constraint |
|---|---|---|
| id | BigInt | Primary Key, Auto Increment |
| name | String | Not Null |
| base_price | Decimal(12,2) | Not Null |

### `projects` (Transactions)
| Field | Type | Constraint |
|---|---|---|
| id | BigInt | Primary Key, Auto Increment |
| invoice_code | String | Unique, Not Null |
| customer_name | String | Not Null |
| license_plate | String | Nullable |
| labor_fee | Decimal(12,2) | Default 0.00 |
| total_amount | Decimal(12,2) | Not Null (Calculated) |
| total_hpp | Decimal(12,2) | Not Null (Calculated) |
| net_profit | Decimal(12,2) | Not Null (Calculated) |
| status | Enum | ['pending', 'completed', 'cancelled'] |
| created_at / updated_at | Timestamp | Default CURRENT_TIMESTAMP |

### `project_items`
| Field | Type | Constraint |
|---|---|---|
| id | BigInt | Primary Key, Auto Increment |
| project_id | BigInt | Foreign Key -> projects.id (Cascade Delete) |
| product_id | BigInt | Foreign Key -> products.id |
| quantity | Integer | Not Null |
| hpp_at_sale | Decimal(12,2) | Not Null |
| sell_price_at_sale | Decimal(12,2) | Not Null |
| subtotal | Decimal(12,2) | Not Null |

### `expenses`
| Field | Type | Constraint |
|---|---|---|
| id | BigInt | Primary Key, Auto Increment |
| description | String | Not Null |
| amount | Decimal(12,2) | Not Null |
| expense_date | Date | Not Null |
| created_at / updated_at | Timestamp | Default CURRENT_TIMESTAMP |

---

## UI/UX & Mobile Component Design

### Color Palette
- **Primary:** Dark Charcoal (`#1E1E24`) - Clean workshop feel.
- **Accent:** Neon Cyan / Amber (`#00F0FF` / `#FFB703`) - Fits the BILED / Headlamp vibe.
- **Success:** Emerald Green (`#10B981`) - Profits & completed tasks.
- **Danger:** Crimson Red (`#EF4444`) - Expenses & low stock.

### Mobile Navigation Layout
- **Bottom Navigation Bar (Fixed):**
  - 🏠 Dashboard
  - 🛠️ Project Baru
  - 📦 Stok & Bahan
  - 💸 Pengeluaran
  - ⚙️ Pengaturan / Master

### Touch Guidelines
- Minimum touch target size: 48x48px for easy thumb tapping.
- Use Modal Popups / Bottom Sheets for adding items dynamically during project creation.