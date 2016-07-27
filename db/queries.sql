CREATE DATABASE shop;

CREATE TABLE items (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) UNIQUE ,
  description TEXT,
  category VARCHAR(255),
  price DECIMAL,
  stock INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  surname VARCHAR(255),
  mail VARCHAR(255),
  password VARCHAR(255),
  address TEXT,
  is_admin BOOLEAN,
  PRIMARY KEY (id)
);

CREATE TABLE orders (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  status INT NOT NULL,
  sum DECIMAL,
  date DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE messages (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  admin_id INT NOT NULL,
  text TEXT,
  date DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (admin_id) REFERENCES users(id)
);

CREATE TABLE photos (
  id INT NOT NULL AUTO_INCREMENT,
  item_id INT NOT NULL,
  link TEXT,
  PRIMARY KEY (id),
  FOREIGN KEY (item_id) REFERENCES items (id)
);

CREATE TABLE item_order (
  id INT NOT NULL AUTO_INCREMENT,
  item_id INT NOT NULL,
  amount INT NOT NULL,
  order_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (item_id) REFERENCES items(id),
  FOREIGN KEY (order_id) REFERENCES orders(id)
);

ALTER DATABASE shop CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE items CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE users CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE item_order CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE messages CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE orders CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE photos CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;

UPDATE `items` SET name='nowa_nazwa' WHERE id='zmienna';

DELETE FROM items WHERE id='zmienna';

SELECT * FROM items WHERE category='zmienna'