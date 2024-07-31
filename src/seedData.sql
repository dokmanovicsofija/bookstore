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

INSERT INTO Author (firstName, lastName) VALUES ('Sofija', 'Dokmanovic');
INSERT INTO Author (firstName, lastName) VALUES ('Djordje', 'Janjic');

INSERT INTO Book (title, year, authorId) VALUES ('First Book', 2000, 1);
INSERT INTO Book (title, year, authorId) VALUES ('Second Book', 2005, 1);
INSERT INTO Book (title, year, authorId) VALUES ('Third Book', 2010, 2);
