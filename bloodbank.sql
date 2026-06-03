CREATE DATABASE IF NOT EXISTS bloodbank CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bloodbank;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS blood_requests;
DROP TABLE IF EXISTS receivers;
DROP TABLE IF EXISTS donors;
DROP TABLE IF EXISTS blood_stock;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admin;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    question1 VARCHAR(255) NOT NULL,
    answer1 VARCHAR(255) NOT NULL,
    question2 VARCHAR(255) NOT NULL,
    answer2 VARCHAR(255) NOT NULL,
    question3 VARCHAR(255) NOT NULL,
    answer3 VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    question1 VARCHAR(255) NOT NULL,
    answer1 VARCHAR(255) NOT NULL,
    question2 VARCHAR(255) NOT NULL,
    answer2 VARCHAR(255) NOT NULL,
    question3 VARCHAR(255) NOT NULL,
    answer3 VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(50) NOT NULL,
    donate_date DATE NOT NULL,
    blood_group VARCHAR(10) NOT NULL,
    CONSTRAINT chk_donor_blood_group CHECK (blood_group IN ('A+','A-','B+','B-','AB+','AB-','O+','O-')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE receivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(50) NOT NULL,
    receive_date DATE NOT NULL,
    blood_group VARCHAR(10) NOT NULL,
    CONSTRAINT chk_receiver_blood_group CHECK (blood_group IN ('A+','A-','B+','B-','AB+','AB-','O+','O-')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE blood_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blood_group VARCHAR(10) NOT NULL UNIQUE,
    units INT NOT NULL DEFAULT 0,
    CONSTRAINT chk_stock_units CHECK (units >= 0)
);

CREATE TABLE blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    patient_name VARCHAR(100) NOT NULL,
    blood_group VARCHAR(10) NOT NULL,
    units INT NOT NULL,
    reason TEXT NOT NULL,
    CONSTRAINT chk_request_blood_group CHECK (blood_group IN ('A+','A-','B+','B-','AB+','AB-','O+','O-')),
    CONSTRAINT chk_request_units CHECK (units >= 1 AND units <= 10),
    status ENUM('Pending', 'Approved', 'Cancelled') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Default admin login:
-- username: admin
-- password: admin123
-- Security answers: red, busan, momo
INSERT INTO admin (username, password, question1, answer1, question2, answer2, question3, answer3) VALUES
('admin', '$2y$12$lefmv4hmRYO7qAg8aJyXJ.Baw.9SdxCEW5rZLUVp8BuC.cOpTkjZu',
 'What is your favorite color?', '$2y$12$tVYqmCKzxBcF5QgzIq.XnuFFWaKE4TzWc2xv/J3Qb/bq4nLIqWCn2',
 'What city do you live in?', '$2y$12$YV2bxVrUbQUFlzXPxaRvxurbTlUpJPmQj7b0FmqtdpTsOvIVUSKze',
 'What is your favorite food?', '$2y$12$YORpDKWL1w2vyf/tTVSpteG0DDlbhJrR0IdJr8ot37e/6LDg1chlm');

INSERT INTO blood_stock (blood_group, units) VALUES
('A+', 5), ('A-', 2), ('B+', 3), ('B-', 1),
('AB+', 4), ('AB-', 2), ('O+', 6), ('O-', 1);

INSERT INTO donors (name, contact, donate_date, blood_group) VALUES
('Abishek Karki', '01081767120', '2026-05-20', 'O+'),
('Dhungel ROhan', '9123456780', '2026-05-18', 'A+'),
('Dahal Sajan', '9988776655', '2026-05-15', 'B+');

INSERT INTO receivers (name, contact, receive_date, blood_group) VALUES
('Diwash Shrestha', '01011112222', '2026-05-21', 'A+'),
('Santosh Khadka', '01033334444', '2026-05-22', 'O+');
