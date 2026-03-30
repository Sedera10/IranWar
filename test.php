<?php
/**
 * Page de diagnostic des articles et catégories
 */

echo "<h1>Diagnostic IranWar</h1>";

// Définir ROOT_PATH
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/config/config.php';

echo "<p>✅ Config chargée</p>";

// Connexion BDD
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $db = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "<p>✅ Connexion BDD réussie!</p>";
} catch (PDOException $e) {
    die("<p>❌ Erreur BDD: " . $e->getMessage() . "</p>");
}

// Vérifier les articles
echo "<h2>Articles dans la base :</h2>";
$stmt = $db->query("SELECT a.*, c.libelle as category_name FROM articles a LEFT JOIN categories c ON a.category_id = c.id");
$articles = $stmt->fetchAll();

if (empty($articles)) {
    echo "<p style='color:red'>❌ Aucun article trouvé</p>";
} else {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Titre</th><th>Catégorie</th><th>published_at</th><th>Visible?</th></tr>";
    foreach ($articles as $a) {
        $visible = $a['published_at'] ? '✅ Oui' : '❌ Non (published_at NULL)';
        echo "<tr>";
        echo "<td>{$a['id']}</td>";
        echo "<td>" . htmlspecialchars($a['title']) . "</td>";
        echo "<td>" . ($a['category_name'] ?? '-') . " (ID: " . ($a['category_id'] ?? 'NULL') . ")</td>";
        echo "<td>" . ($a['published_at'] ?? '<b style=\"color:red\">NULL</b>') . "</td>";
        echo "<td>$visible</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Vérifier les catégories
echo "<h2>Catégories :</h2>";
$stmt = $db->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

if (empty($categories)) {
    echo "<p style='color:red'>❌ Aucune catégorie - Exécutez le script SQL dans database.sql</p>";
} else {
    echo "<ul>";
    foreach ($categories as $c) {
        echo "<li><a href='" . SITE_URL . "/articles/category/{$c['id']}'>ID {$c['id']}: {$c['libelle']}</a></li>";
    }
    echo "</ul>";
}

// Vérifier les statuts
echo "<h2>Statuts :</h2>";
$stmt = $db->query("SELECT * FROM statuts");
$statuts = $stmt->fetchAll();

if (empty($statuts)) {
    echo "<p style='color:red'>❌ Aucun statut - Exécutez le script SQL dans database.sql</p>";
} else {
    echo "<ul>";
    foreach ($statuts as $s) {
        echo "<li>ID {$s['id']}: {$s['libelle']}</li>";
    }
    echo "</ul>";
}

// Solution
echo "<h2>🔧 Solution pour publier les articles :</h2>";
echo "<p>Les articles ne s'affichent que si <code>published_at</code> n'est pas NULL.</p>";

if (isset($_GET['fix'])) {
    $db->exec("UPDATE articles SET published_at = NOW() WHERE published_at IS NULL");
    echo "<p style='color:green'>✅ Tous les articles ont été publiés!</p>";
    echo "<p><a href='test.php'>Rafraîchir</a> | <a href='" . SITE_URL . "'>Voir le site</a></p>";
} else {
    echo "<p><a href='test.php?fix=1' style='background:green;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Publier tous les articles maintenant</a></p>";
}

echo "<h2>🔗 Liens de test :</h2>";
echo "<ul>";
echo "<li><a href='" . SITE_URL . "'>Page d'accueil</a></li>";
echo "<li><a href='" . SITE_URL . "/articles'>Tous les articles</a></li>";
if (!empty($categories)) {
    foreach ($categories as $c) {
        echo "<li><a href='" . SITE_URL . "/articles/category/{$c['id']}'>Catégorie: {$c['libelle']}</a></li>";
    }
}
echo "</ul>";
