USE Vadim200609007;
-- drop tables because i created them before and there was some troubles 
DROP TABLE IF EXISTS content;
DROP TABLE IF EXISTS users;

-- users table
CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255) NOT NULL DEFAULT 'default.jpg',
    `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- creating content table with foreig key
CREATE TABLE `content` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `user_id` INT NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- insert a default user
INSERT INTO `users` (`username`, `email`, `password`, `image`) 
VALUES ('admin', 'admin@example.com', '$2y$10$YOUR_HASHED_PASSWORD', 'default.jpg');

-- insert default content with the new user_id
INSERT INTO `content` (`title`, `body`, `user_id`) VALUES
('hI there to!', 1);

SELECT * FROM users;
SELECT * FROM content;