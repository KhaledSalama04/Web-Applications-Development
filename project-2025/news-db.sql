
CREATE DATABASE news_db; 


CREATE TABLE IF NOT EXISTS users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, email, password, role)
VALUES ('Khaled', 'khaledsalama49@gmail.com', '$2y$10$6gMsBwpGc8WZMEugWGOC2Ow1PSjVDqxUBWG3v9VMuvtRMSXwxQKHq', 'admin');

'$2y$10$6gMsBwpGc8WZMEugWGOC2Ow1PSjVDqxUBWG3v9VMuvtRMSXwxQKHq' = "04092004"  //  هذه كلمة مرور مشفرة وانا المسؤول خالد اكرم سيد سلامة 

CREATE TABLE IF NOT EXISTS categories (
    category_id INT(11) NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO categories (category_name) VALUES
('Sports'),
('Politics'),
('Technology'),
('Entertainment');



CREATE TABLE IF NOT EXISTS articles (
    article_id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    category_id INT(11),
    author_id INT(11),
    published_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (article_id),
    CONSTRAINT fk_arti_categ  FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_arti_users  FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS comments (
    comment_id INT(11) NOT NULL AUTO_INCREMENT,
    article_id INT(11),
    user_id INT(11),
    comment_text TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (comment_id),
    CONSTRAINT fk_comment_arti  FOREIGN KEY (article_id) REFERENCES articles(article_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_comment_user  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
