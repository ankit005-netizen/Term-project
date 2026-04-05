CREATE DATABASE IF NOT EXISTS reloop_marketplace;
USE reloop_marketplace;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  city VARCHAR(100) NOT NULL,
  province VARCHAR(100) NOT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seller_id INT NOT NULL,
  category_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  item_condition VARCHAR(50) NOT NULL,
  stock INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (seller_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status VARCHAR(50) NOT NULL DEFAULT 'Placed',
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO categories (category_name) VALUES
('Electronics'), ('Books'), ('Vinyl'), ('Clothing'), ('Collectibles');

INSERT INTO users (first_name, last_name, username, email, password_hash, address, city, province, is_admin) VALUES
('Admin', 'User', 'admin', 'admin@reloop.test', '$2y$10$Vzv6T8HwLxYqUoM7bWZgoOkYj4eLwK9C3HdV2eL7Vj4P.9Wj7AcQK', '1 College Ave', 'Sault Ste. Marie', 'Ontario', 1),
('Maya', 'Chen', 'mayachen', 'maya@reloop.test', '$2y$10$qzV7C7g2f23u3fQ2.DD0UuM4eV4eKjP5KQvKiySzUqWkL2m0m8sEq', '25 Queen St', 'Toronto', 'Ontario', 0),
('Noah', 'Grant', 'noahgrant', 'noah@reloop.test', '$2y$10$A3QvP0zD0hp4Wl7a6V5W3ec8z5t0rM8O3MB9xQ5L7A3lV9e1D5k7C', '18 Bay Rd', 'Ottawa', 'Ontario', 0);

INSERT INTO products (seller_id, category_id, name, description, price, image_url, item_condition, stock) VALUES
(2, 1, 'Sony WH-1000XM4 Headphones', 'Noise-cancelling headphones in very good condition with carrying case.', 229.99, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80', 'Very Good', 2),
(2, 2, 'Data Structures Textbook', 'Clean pages and minor cover wear, good for first-year computer science courses.', 34.50, 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=900&q=80', 'Good', 3),
(3, 3, 'Fleetwood Mac Vinyl', 'Classic album on vinyl with strong playback and original sleeve.', 29.00, 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=900&q=80', 'Good', 1),
(3, 4, 'Vintage Denim Jacket', 'Lightly worn jacket, medium size, retro wash and sturdy stitching.', 45.00, 'https://images.unsplash.com/photo-1523398002811-999ca8dec234?auto=format&fit=crop&w=900&q=80', 'Very Good', 1),
(2, 5, 'Retro Game Collectible Figure', 'Display-ready collectible with original packaging and stand.', 55.75, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80', 'Like New', 4),
(3, 1, 'Mechanical Keyboard', 'Hot-swappable keyboard with tactile switches and RGB lighting.', 68.00, 'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?auto=format&fit=crop&w=900&q=80', 'Excellent', 2);
