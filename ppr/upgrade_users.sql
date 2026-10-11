-- Run once in phpMyAdmin (SQL tab) if you already imported the old schema.sql
USE pawpathrole;
ALTER TABLE users
  DROP COLUMN name,
  ADD COLUMN first_name VARCHAR(60) NOT NULL DEFAULT '' AFTER id,
  ADD COLUMN last_name  VARCHAR(60) NOT NULL DEFAULT '' AFTER first_name,
  ADD COLUMN username   VARCHAR(30) NULL UNIQUE AFTER last_name,
  ADD COLUMN phone      VARCHAR(20) NULL AFTER email;
