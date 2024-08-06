CREATE DATABASE IF NOT EXISTS bookstore;

USE bookstore;

CREATE TABLE IF NOT EXISTS Author (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      firstName VARCHAR(100) NOT NULL,
                                      lastName VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS Book (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    title VARCHAR(100) NOT NULL,
                                    year INT,
                                    authorId INT,
                                    FOREIGN KEY (authorId) REFERENCES Author(id)
);

INSERT INTO Author (firstName, lastName) VALUES
                                             ('John', 'Smith'),
                                             ('Jane', 'Doe'),
                                             ('Emily', 'Jones'),
                                             ('Michael', 'Taylor'),
                                             ('Sarah', 'Brown'),
                                             ('David', 'Wilson'),
                                             ('Laura', 'Johnson'),
                                             ('Chris', 'Lee'),
                                             ('Anna', 'Martin'),
                                             ('James', 'Thompson'),
                                             ('Linda', 'White'),
                                             ('Robert', 'Clark'),
                                             ('Jessica', 'Rodriguez'),
                                             ('Daniel', 'Lewis'),
                                             ('Megan', 'Walker'),
                                             ('Matthew', 'Hall'),
                                             ('Amanda', 'Allen'),
                                             ('Joshua', 'Young'),
                                             ('Rachel', 'Harris'),
                                             ('Nicholas', 'Nelson');

DELIMITER $$

CREATE PROCEDURE insert_books()
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE book_title VARCHAR(100);

    WHILE i < 20000 DO
            SET book_title = CONCAT('Book Title ', i + 1);
            INSERT INTO Book (title, year, authorId) VALUES (book_title, FLOOR(RAND() * (2024 - 1900 + 1) + 1900), (i % 20) + 1);
            SET i = i + 1;
        END WHILE;
END $$

DELIMITER ;

CALL insert_books();

DROP PROCEDURE IF EXISTS insert_books;
