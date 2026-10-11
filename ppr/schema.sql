CREATE DATABASE IF NOT EXISTS pawpathrole CHARACTER SET utf8mb4;
USE pawpathrole;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(60) NOT NULL,
  last_name VARCHAR(60) NOT NULL,
  username VARCHAR(30) NOT NULL UNIQUE,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE pets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL,
  species ENUM('cat','dog','rabbit','other') NOT NULL,
  size ENUM('small','medium','large') NOT NULL DEFAULT 'medium',
  age_years DECIMAL(3,1) NOT NULL DEFAULT 1,
  age VARCHAR(30) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  story TEXT NOT NULL,
  image VARCHAR(200) DEFAULT NULL,
  status ENUM('available','pending','adopted') DEFAULT 'available'
);
CREATE TABLE adoption_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_id INT NOT NULL, user_id INT NOT NULL, message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pet_id) REFERENCES pets(id), FOREIGN KEY (user_id) REFERENCES users(id)
);
INSERT INTO pets (name,species,age,gender,story,image) VALUES
('Milo','cat','2 years old','Male','Milo was rescued and brought to the shelter after being found alone outdoors. He is a gentle and affectionate cat who is now looking for a safe and loving forever home.','milo.jpeg'),
('Kodai','dog','3 years old','Male','Kodai was surrendered by a family unable to provide for proper care. He is a friendly and playful dog who enjoys being around people and is now looking for a loving furever home.','Koda.png');

CREATE TABLE stories (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(100) NOT NULL, image VARCHAR(200), body TEXT NOT NULL);
CREATE TABLE feedbacks (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(80) NOT NULL, ago VARCHAR(30) DEFAULT 'just now', stars TINYINT DEFAULT 5, avatar VARCHAR(200), text TEXT NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
-- Tip: leave these empty to use the built-in sample stories/feedback from includes/data.php
