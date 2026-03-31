<?php
/**
 * Script de minification CSS
 * 
 * Usage: php minify-css.php
 * 
 * Ce script minifie automatiquement les fichiers CSS :
 * - style.css → style.min.css
 * - admin.css → admin.min.css
 */

echo "=== Minification CSS ===\n\n";

$cssDir = __DIR__ . '/public/css/';

$files = [
    'style.css' => 'style.min.css',
    'admin.css' => 'admin.min.css'
];

foreach ($files as $source => $dest) {
    $sourcePath = $cssDir . $source;
    $destPath = $cssDir . $dest;
    
    if (!file_exists($sourcePath)) {
        echo "❌ Fichier source non trouvé: $source\n";
        continue;
    }
    
    // Lire le CSS original
    $css = file_get_contents($sourcePath);
    $originalSize = strlen($css);
    
    // Minification
    $minified = minifyCSS($css);
    $minifiedSize = strlen($minified);
    
    // Sauvegarder
    file_put_contents($destPath, $minified);
    
    // Stats
    $reduction = round((1 - $minifiedSize / $originalSize) * 100);
    echo "✅ $source → $dest\n";
    echo "   Original: " . formatBytes($originalSize) . "\n";
    echo "   Minifié:  " . formatBytes($minifiedSize) . " (-$reduction%)\n\n";
}

echo "=== Terminé ===\n";

/**
 * Minifie le CSS
 */
function minifyCSS(string $css): string
{
    // Supprimer les commentaires
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    
    // Supprimer les espaces, tabs, newlines
    $css = preg_replace('/\s+/', ' ', $css);
    
    // Supprimer les espaces autour des caractères spéciaux
    $css = preg_replace('/\s*([{}:;,>+~])\s*/', '$1', $css);
    
    // Supprimer le point-virgule avant }
    $css = preg_replace('/;}/', '}', $css);
    
    // Supprimer les espaces en début/fin
    $css = trim($css);
    
    return $css;
}

/**
 * Formater les bytes
 */
function formatBytes(int $bytes): string
{
    if ($bytes < 1024) return $bytes . ' B';
    return round($bytes / 1024, 1) . ' KB';
}
