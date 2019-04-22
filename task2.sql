CREATE DATABASE library;
USE library;
SET NAMES utf8;

CREATE TABLE books (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE authors (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE relations (
    books_id INT(11) NOT NULL,
    authors_id INT(11) NOT NULL,
    FOREIGN KEY (books_id) REFERENCES books(id),
    FOREIGN KEY (authors_id) REFERENCES authors(id)
);

-- Запрос, который выведет авторов, написавших меньше 7 книг

SELECT authors.name, count(authors_id) AS number_of_books FROM authors 
LEFT JOIN relations ON relations.authors_id = authors.id 
GROUP BY authors.name 
HAVING number_of_books <= 7