<?php
define('DEBUG_MODE', true);

// Configuration de la base de données (compatible Docker)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'iranwar_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

// Configuration du site
define('SITE_NAME', 'IranWar Info');
define('SITE_DESCRIPTION', 'Site d\'informations sur la guerre en Iran - Actualités, analyses et reportages');
define('SITE_KEYWORDS', 'Iran, guerre, conflit, actualités, informations, moyen-orient, géopolitique');
define('SITE_URL', getenv('SITE_URL') ?: 'http://localhost:83');
define('SITE_AUTHOR', 'IranWar Team');

// Chemins
define('CONTROLLERS_PATH', ROOT_PATH . '/app/controllers/');
define('MODELS_PATH', ROOT_PATH . '/app/models/');
define('VIEWS_PATH', ROOT_PATH . '/app/views/');
define('PUBLIC_PATH', ROOT_PATH . '/public/');
define('UPLOADS_PATH', ROOT_PATH . '/public/uploads/');

// Configuration par défaut du routeur
define('DEFAULT_CONTROLLER', 'Home');
define('DEFAULT_ACTION', 'index');

// Configuration des uploads
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Fuseau horaire
date_default_timezone_set('Europe/Paris');

// Gestion des erreurs selon le mode
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
