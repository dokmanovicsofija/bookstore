CREATE TABLE IF NOT EXISTS
    Author (id INT AUTO_INCREMENT PRIMARY KEY,
            firstName VARCHAR(100) NOT NULL,
            lastName VARCHAR(100) NOT NULL);

CREATE TABLE IF NOT EXISTS
    Book (id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        year INT,
        authorId INT,
        FOREIGN KEY (authorId) REFERENCES Author(id));