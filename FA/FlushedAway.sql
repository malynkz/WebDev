-- Script SQL per creare il database e la tabella utenti
CREATE DATABASE IF NOT EXISTS flushed_away;
USE flushed_away;

-- Tabella utenti: ogni utente ha username univoco, password hashata, e record personale
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    highscore INT DEFAULT 0
);