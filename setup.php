<?php
/**
 * Script de création de la structure MVC
 * Exécuter une seule fois: php setup.php
 */

$baseDir = __DIR__;

$directories = [
    'app/controllers',
    'app/models', 
    'app/views/layouts',
    'app/views/articles',
    'app/views/admin',
    'app/views/home',
    'core',
    'config',
    'public/css',
    'public/js',
    'public/images',
    'public/uploads'
];

echo "Création de la structure MVC...\n";

foreach ($directories as $dir) {
    $path = $baseDir . '/' . $dir;
    if (!is_dir($path)) {
        if (mkdir($path, 0755, true)) {
            echo "✓ Créé: $dir\n";
        } else {
            echo "✗ Erreur: $dir\n";
        }
    } else {
        echo "- Existe déjà: $dir\n";
    }
}

echo "\nStructure créée avec succès!\n";
echo "Vous pouvez supprimer ce fichier setup.php\n";
