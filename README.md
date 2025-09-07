# Ecommerce_Store(PHP OOP + MVC)

This is a mini **E-Commerce Store** project built with **PHP (OOP & MVC architecture)**.  
It includes features for **customers** (shopping, cart, checkout, orders) and **admin** (manage products, users, and orders).  
A good starting point for learning **E-commerce development** in PHP without frameworks.

---

## Project Structure

```

Ecommerce\_Store/
│
├── Admin/                     # Admin Panel
│   ├── controllers/           # Admin controllers
│   ├── models/                # Admin models
│   ├── views/                 # Admin views
│   └── index.php              # Admin entry point (/store/admin)
│
├── Customer/                  # Customer Panel
│   ├── controllers/           # Customer controllers
│   ├── models/                # Customer models
│   ├── views/                 # Customer views
│   
│
├── core/                      # Core MVC (Controller, Model, Database, Session)
│
├── public/                    # Public assets (CSS, JS, images)
├── index.php              # Customer entry point (/store/)
│
└── README.md                  # Project documentation

````

---

## Features

### Customer
- Register & Login
- Browse products
- Add to cart
- Checkout & Place orders
- View order history

### Admin
- Manage Products (CRUD)
- Manage Users
- View and Update Orders (status: pending, processing, shipped, completed, cancelled)
- Dashboard with recent orders

---

## Database Schema (Main Tables)

- **users** – stores customer & admin accounts  
- **categories** – product categories (e.g., Electronics)  
- **products** – product info (name, price, stock, image, category_id)  
- **orders** – stores order details (user_id, total_amount, status, created_at)  
- **order_items** – products in each order (order_id, product_id, quantity, price)  
- **payments** – payment details for orders  
- **shipping** – shipping info for orders  

---

## Installation

1. Clone the repo:
   ```bash
   git clone https://github.com/HuzaifaaM007/Ecommerce_Store.git
````

2. Place the project inside `htdocs` (for XAMPP) or your web server’s root.


3. Configure the database connection:
   Edit `core/Database.php` and set your **DB credentials**:

   ```php
   private $host = "localhost";
   private $username = "root";
   private $password = "";
   private $dbname = "ecommerce_store";
   ```

4. Start Apache & MySQL in XAMPP.

6. Access the project in browser:

   * Customer: `http://localhost/Ecommerce_Store/`
   * Admin: `http://localhost/Ecommerce_Store/Admin/`

---

## Technologies Used

* PHP (OOP, MVC)
* MySQL
* HTML, TailwindCSS
* XAMPP / Apache

---

## Author

Developed by *Huzaifa Murtaza* as a **Mini E-Commerce Store project in PHP**.

```

```

