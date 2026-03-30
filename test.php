<?php
/**
 * Page de test pour diagnostiquer les problèmes
 */

echo "<h1>Test IranWar</h1>";

// Test 1: PHP fonctionne
echo "<p>✅ PHP fonctionne</p>";

// Définir ROOT_PATH (comme dans index.php)
define('ROOT_PATH', __DIR__);

// Test 2: Configuration
require_once ROOT_PATH . '/config/config.php';
echo "<p>✅ Config chargée</p>";
echo "<p>DB_HOST: " . DB_HOST . "</p>";
echo "<p>DB_NAME: " . DB_NAME . "</p>";
echo "<p>DB_USER: " . DB_USER . "</p>";

// Test 3: Connexion BDD
echo "<h2>Test connexion BDD...</h2>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    echo "<p>✅ Connexion BDD réussie!</p>";
    
    // Test 4: Tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Tables: " . implode(", ", $tables) . "</p>";
    
    // Test 5: Articles
    $count = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    echo "<p>Nombre d'articles: $count</p>";
    
} catch (PDOException $e) {
    echo "<p>❌ Erreur BDD: " . $e->getMessage() . "</p>";
}

echo "<hr><p><a href='/'>Retour accueil</a></p>";
