CREATE TABLE books (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(255),
    publication DATE,
    quantity INT
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255)
);