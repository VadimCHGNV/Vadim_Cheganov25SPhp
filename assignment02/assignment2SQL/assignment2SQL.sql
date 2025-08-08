USE Vadim200609007;
-- again dropping tables because ive created them before then i had to make some chenges 
DROP TABLE IF EXISTS app_products;
DROP TABLE IF EXISTS app_users;

CREATE TABLE app_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE app_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    image VARCHAR(255) DEFAULT 'no_image.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

