-- ====================================
-- IranWar Database Schema
-- Site d'informations sur la guerre en Iran
-- ====================================
DROP DATABASE IF EXISTS iranwar_db;

-- Création de la base de données
CREATE DATABASE iranwar_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE iranwar_db;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL COMMENT 'Nom complet',
    username VARCHAR(100) DEFAULT 'Anonyme',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email de connexion',
    password VARCHAR(255) NOT NULL COMMENT 'Mot de passe hashé (bcrypt)',
    avatar VARCHAR(255) DEFAULT NULL COMMENT 'Photo de profil',
    role ENUM('admin', 'redacteur') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL COMMENT 'Nom de la catégorie',
    description TEXT DEFAULT NULL
);

CREATE TABLE statuts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(30) NOT NULL ,
    description VARCHAR(100) DEFAULT NULL
);
-- ====================================
-- TABLE: articles (Articles/Actualités)
-- ====================================
CREATE TABLE articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    category_id INT UNSIGNED DEFAULT NULL,
    author_id INT UNSIGNED DEFAULT NULL,
    views INT UNSIGNED DEFAULT 0 COMMENT 'Nombre de vues',
    published_at DATETIME DEFAULT NULL COMMENT 'Date de publication',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Articles et actualités du site';

-- ====================================
-- TABLE: media (Médiathèque)
-- ====================================
CREATE TABLE media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL ,
    alt_text VARCHAR(255) DEFAULT NULL,
    article_id INT UNSIGNED DEFAULT NULL,

    FOREIGN KEY (article_id) REFERENCES articles (id) ON DELETE SET NULL
);

CREATE TABLE articles_statuts(
   id_1 INT UNSIGNED,
   id_2 INT UNSIGNED,
   date_ DATETIME,
   PRIMARY KEY(id_1, id_2),
   FOREIGN KEY(id_1) REFERENCES statuts(id),
   FOREIGN KEY(id_2) REFERENCES articles(id)
);



-- ====================================
-- DONNÉES INITIALES
-- ====================================

-- Administrateur par défaut
-- Email: admin@iranwar.info
-- Mot de passe: admin123
INSERT INTO users (name, username, email, password) VALUES 
('Administrateur Sedera', 'Sedou', 'admin@iranwar.info', '$2y$10$xLxAo0cffy8KGLFmJXHxKetTGr3dijKXgbmYlOH7XzPzKjLfjhGtG');

-- ====================================
-- Catégories par défaut
-- ====================================
INSERT INTO categories (libelle, description) VALUES 
('Actualites', 'Dernieres nouvelles et developpements sur le conflit'),
('Analyses', 'Analyses approfondies des evenements et de la situation'),
('Reportages', 'Reportages de terrain et temoignages'),
('Geopolitique', 'Contexte geopolitique et relations internationales'),
('Humanitaire', 'Situation humanitaire et aide aux populations');

-- ====================================
-- Statuts par défaut
-- ====================================
INSERT INTO statuts (libelle, description) VALUES 
('Draft', 'Article en cours de redaction'),
('Published', 'Article visible sur le site'),
('Archived', 'Article retire du site mais conserve');

