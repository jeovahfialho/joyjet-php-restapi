CREATE DATABASE IF NOT EXISTS joyjet_users;
GRANT ALL PRIVILEGES ON *.* TO 'joyjet'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
USE joyjet_users;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL
);

INSERT INTO users (username, email) VALUES ('user1', 'user1@example.com');
INSERT INTO users (username, email) VALUES ('user2', 'user2@example.com');
-- Adicione mais registros conforme necessário.
