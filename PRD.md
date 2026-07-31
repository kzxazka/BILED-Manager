# Product Requirement Document (PRD)

## Project Name
**BILED Manager (Local Workshop ERP Light)**

## Objective
A local-first, mobile-optimized Web Application designed for a custom BILED retrofit workshop. The application helps the business owner independently manage inventory, track custom retrofit projects, and monitor net profit & operational expenses without complex manual accounting.

## Target User & Environment
- **User:** Workshop Owner (Non-technical user, primary access via Smartphone/Mobile Browser).
- **Environment:** Local Network (Localhost server running on PC/Laptop, accessed by smartphone via Wi-Fi IP / PWA).
- **Delivery Mode:** Empty/Blank System (Dynamic setup; zero hardcoded business data).

---

## Core Features & Requirements

### 1. Master Data Management (Owner Configurable)
- **Categories:** Dynamic CRUD for item categories (e.g., Lenses, Shrouds, Demon Eyes, Wiring Harness, Consumables).
- **Products & Stock:** CRUD for inventory items with attributes:
  - Item Name, SKU/Code (optional), Category.
  - HPP (Cost Price) & Retail Price.
  - Current Stock & Minimum Stock Alert Threshold.
- **Service Rates:** Preset labor/installation charges (e.g., Headlamp Opening, Full Retrofit Labor).

### 2. Retrofit Project & Transaction Engine
- **New Order Intake:**
  - Customer Info (Name, Phone, Vehicle License Plate).
  - Multi-item Picker (Deducts inventory stock automatically upon confirmation).
  - Custom Labor Cost input / preset selection.
  - Total Price & Payment Status (Paid / DP / Unpaid).
- **Financial Calculation Logic:**
  - $\text{Gross Income} = \text{Total Material Selling Price} + \text{Labor Fee}$
  - $\text{Total Material HPP} = \sum (\text{Item Quantity} \times \text{Item Cost Price})$
  - $\text{Net Profit per Project} = \text{Gross Income} - \text{Total Material HPP}$

### 3. Expense Tracking (Outcome)
- Record non-inventory operational expenses (e.g., Electricity, Tool Replacements, Shop Rent, Maintenance).
- Categorized expense logging with date filter.

### 4. Mobile-First Financial Dashboard
- Real-time summary metrics (Daily/Monthly): Total Revenue, Total HPP, Total Expenses, Net Profit.
- Low stock warning banner.
- Recent Project History with status indicators.

### 5. Utility & Maintenance
- **System Purge / Reset Data:** Option in settings to flush demo/test data back to clean slate.

---

## Non-Functional Requirements
- **Responsive UI:** Mobile-first design optimized for touch/thumb interactions.
- **Performance:** Lightweight frontend, low latency on local Wi-Fi.
- **Data Persistence:** Relational database supporting strict transaction integrity (ACID).