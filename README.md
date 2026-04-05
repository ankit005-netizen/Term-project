# ReLoop Marketplace - Full Term Project

A full-stack online second-hand marketplace platform built with HTML5, CSS, Bootstrap, JavaScript, PHP, and MySQL.


## Student Information
- **Student Name:** Ankit
- **Student Number:** 5143548
- **Course:** [COSC-2956-W02]
- **Instructor:** []
- **GitHub Repository:** [Paste GitHub Link]
- **Demo Video:** [Paste YouTube or Google Drive Link]

## Included features
- User registration and login/logout
- Secure passwords with `password_hash()` and `password_verify()`
- Product browsing by category
- Product detail pages
- Cart management with sessions
- Checkout and order placement
- Order history
- Admin dashboard
- Admin product add/edit/delete
- Admin view all orders
- Admin view all users
- Search and filter by keyword/category
- Responsive design using Bootstrap
- Client-side validation using JavaScript
- Server-side validation using PHP
- Prepared statements to reduce SQL injection risk

## Pages included
- index.php
- products.php
- product.php
- cart.php
- checkout.php
- login.php
- register.php
- logout.php
- order_history.php
- seller/add_product.php
- admin/dashboard.php
- admin/products.php
- admin/add_product.php
- admin/edit_product.php
- admin/delete_product.php
- admin/orders.php
- admin/users.php

## Setup
1. Copy the project folder into `htdocs`.
2. Create a database named `reloop_marketplace`.
3. Import `sql/schema.sql` using phpMyAdmin.
4. Update credentials in `db/conn.php` if needed.
5. Open `http://localhost/ReLoop_Full_Marketplace/`.

## Default admin login
- Email: admin@reloop.test
- Password: Admin123!

## Suggested submission
- Upload source code + SQL file
- Include the report and presentation in the final submission package
- Record a short demo video showing register, login, browsing, cart, checkout, and admin features
