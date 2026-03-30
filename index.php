<?php
/**
 * Point d'entrée principal - IranWar Info
 * Site d'informations sur la guerre en Iran
 */
// Définir le chemin racine
define('ROOT_PATH', __DIR__);
// Charger la configuration
require_once ROOT_PATH . '/config/config.php';
// Charger l'autoloader
require_once ROOT_PATH . '/core/Autoloader.php';

// Initialiser l'autoloader
Autoloader::register();

// Charger et démarrer l'application
require_once ROOT_PATH . '/core/App.php';

$app = new App();
$app->run();