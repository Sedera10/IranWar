<?php
/**
 * Autoloader - Chargement automatique des classes
 */
class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register([self::class, 'autoload']);
    }
    
    public static function autoload(string $className): void
    {
        // Chemins possibles pour les classes
        $paths = [
            ROOT_PATH . '/core/' . $className . '.php',
            ROOT_PATH . '/app/controllers/' . $className . '.php',
            ROOT_PATH . '/app/models/' . $className . '.php',
            ROOT_PATH . '/config/' . $className . '.php',
        ];
        
        foreach ($paths as $path) {
            if (file_exists($path)) {
                require_once $path;
                return;
            }
        }
    }
}
