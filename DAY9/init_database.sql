-- Tạo CSDL
CREATE DATABASE IF NOT EXISTS tech_factory;
USE tech_factory;

-- Bảng products
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(100),
    unit_price DECIMAL(10,2),
    stock_quantity INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng orders
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_date DATE,
    customer_name VARCHAR(100),
    note TEXT
);

-- Bảng order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    price_at_order_time DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
