<?php
/**
 * Debug login - À supprimer après utilisation
 */
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/config/database.php';

echo "<h1>Debug Login</h1>";

// 1. Connexion BDD
$db = Database::getInstance();
echo "<p>✅ Connexion BDD OK</p>";

// 2. Récupérer l'utilisateur
$email = 'admin@iranwar.info';
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

if ($user) {
    echo "<h2>Utilisateur trouvé:</h2>";
    echo "<pre>";
    echo "ID: " . $user['id'] . "\n";
    echo "Name: " . $user['name'] . "\n";
    echo "Email: " . $user['email'] . "\n";
    echo "Password hash: " . $user['password'] . "\n";
    echo "Hash length: " . strlen($user['password']) . " caractères\n";
    echo "</pre>";
    
    // 3. Tester password_verify
    $testPassword = 'admin123';
    echo "<h2>Test password_verify:</h2>";
    
    $result = password_verify($testPassword, $user['password']);
    if ($result) {
        echo "<p style='color:green'>✅ password_verify('admin123') = TRUE</p>";
    } else {
        echo "<p style='color:red'>❌ password_verify('admin123') = FALSE</p>";
    }
    
    // 4. Générer le bon hash
    echo "<h2>Hash correct pour 'admin123':</h2>";
    $correctHash = password_hash('admin123', PASSWORD_DEFAULT);
    echo "<pre>$correctHash</pre>";
    
    // 5. SQL pour corriger
    echo "<h2>Commande SQL pour corriger:</h2>";
    echo "<pre style='background:#f0f0f0;padding:10px;'>";
    echo "UPDATE users SET password = '" . $correctHash . "' WHERE email = 'admin@iranwar.info';";
    echo "</pre>";
    
} else {
    echo "<p style='color:red'>❌ Utilisateur non trouvé avec email: $email</p>";
    
    // Lister tous les users
    $allUsers = $db->query("SELECT id, name, email FROM users")->fetchAll();
    echo "<h2>Utilisateurs dans la BDD:</h2>";
    echo "<pre>" . print_r($allUsers, true) . "</pre>";
}
