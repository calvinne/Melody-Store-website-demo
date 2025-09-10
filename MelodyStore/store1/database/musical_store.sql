CREATE DATABASE musical_store;
USE musical_store;

-- Users table
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

-- Products table
CREATE TABLE products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category_id INT(11),
    image VARCHAR(255),
    stock INT(11) DEFAULT 0,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Cart table
CREATE TABLE cart (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    product_id INT(11),
    quantity INT(11) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Wishlist table
CREATE TABLE wishlist (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    product_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Orders table
CREATE TABLE orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order items table
CREATE TABLE order_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11),
    product_id INT(11),
    quantity INT(11) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Guitars', 'Acoustic, electric and bass guitars'),
('Keyboards', 'Pianos, synthesizers and MIDI controllers'),
('Drums', 'Drum sets and percussion instruments'),
('Wind Instruments', 'Flutes, saxophones and trumpets'),
('String Instruments', 'Violins, cellos and orchestral strings'),
('Accessories', 'Cases, stands, strings and other accessories');

-- Insert sample products
INSERT INTO products (name, description, price, category_id, image, stock, featured) VALUES
('Fender Stratocaster', 'American Professional II electric guitar with maple neck', 1499.99, 1, 'guitar1.jpg', 10, 1),
('Yamaha FG800', 'Solid top acoustic guitar with natural finish', 229.99, 1, 'guitar2.jpg', 15, 1),
('Roland FP-30X', 'Digital piano with 88 weighted keys and Bluetooth', 699.99, 2, 'piano1.jpg', 8, 0),
('Ludwig Breakbeats', '4-piece kidney-shaped drum set with hardware', 499.99, 3, 'drums1.jpg', 5, 1),
('Selmer SAS280', 'La Voix II professional alto saxophone', 3299.99, 4, 'saxophone1.jpg', 3, 0),
('Yamaha Violin', '4/4 full size student violin outfit with bow and case', 199.99, 5, 'violin1.jpg', 12, 0),
('Guitar Stand', 'Adjustable guitar stand for electric and acoustic guitars', 24.99, 6, 'accessory1.jpg', 25, 0),
('Drum Sticks', '5A hickory wood drum sticks, pair', 12.99, 6, 'accessory2.jpg', 50, 0);