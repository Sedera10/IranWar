<?php
/**
 * UrlHelper - Génération d'URLs SEO-friendly
 * 
 * Exemples d'URLs générées:
 * - Article: /politique/article/2026/03/31/iran-tensions-nucleaires_123.html
 * - Catégorie: /categorie/politique_1.html
 * - Actualités: /actualites.html
 */
class UrlHelper
{
    /**
     * Génère un slug à partir d'un texte
     * "Mon Titre d'Article!" -> "mon-titre-d-article"
     */
    public static function slugify(string $text): string
    {
        // Convertir en minuscules
        $text = mb_strtolower($text, 'UTF-8');
        
        // Remplacer les caractères accentués
        $text = self::removeAccents($text);
        
        // Remplacer tout ce qui n'est pas alphanumérique par un tiret
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        
        // Supprimer les tirets en début et fin
        $text = trim($text, '-');
        
        // Limiter la longueur
        if (strlen($text) > 60) {
            $text = substr($text, 0, 60);
            $text = rtrim($text, '-');
        }
        
        return $text;
    }
    
    /**
     * Supprime les accents d'une chaîne
     */
    public static function removeAccents(string $text): string
    {
        $accents = [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ñ' => 'n',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'ÿ' => 'y',
            'œ' => 'oe', 'æ' => 'ae'
        ];
        
        return strtr($text, $accents);
    }
    
    /**
     * Génère l'URL SEO complète d'un article
     * Format: /categorie/article/YYYY/MM/DD/titre-slug_ID.html
     */
    public static function articleUrl(array $article, ?array $category = null): string
    {
        $slug = self::slugify($article['title']);
        $id = $article['id'];
        
        // Date de publication ou création
        $date = $article['published_at'] ?? $article['created_at'] ?? date('Y-m-d');
        $dateObj = new DateTime($date);
        $year = $dateObj->format('Y');
        $month = $dateObj->format('m');
        $day = $dateObj->format('d');
        
        // Si catégorie disponible, URL complète
        if ($category && isset($category['libelle'])) {
            $catSlug = self::slugify($category['libelle']);
            return SITE_URL . "/{$catSlug}/article/{$year}/{$month}/{$day}/{$slug}_{$id}.html";
        }
        
        // URL simplifiée sans catégorie
        return SITE_URL . "/article/{$slug}_{$id}.html";
    }
    
    /**
     * Génère l'URL SEO d'une catégorie
     * Format: /categorie/nom-categorie_ID.html
     */
    public static function categoryUrl(array $category): string
    {
        $slug = self::slugify($category['libelle']);
        $id = $category['id'];
        
        return SITE_URL . "/categorie/{$slug}_{$id}.html";
    }
    
    /**
     * URL de la page actualités
     */
    public static function actualitesUrl(): string
    {
        return SITE_URL . "/actualites.html";
    }
    
    /**
     * URL de recherche
     */
    public static function searchUrl(string $keyword = ''): string
    {
        $url = SITE_URL . "/recherche.html";
        if (!empty($keyword)) {
            $url .= "?q=" . urlencode($keyword);
        }
        return $url;
    }
    
    /**
     * URL de la page à propos
     */
    public static function aboutUrl(): string
    {
        return SITE_URL . "/a-propos.html";
    }
    
    /**
     * URL de la page contact
     */
    public static function contactUrl(): string
    {
        return SITE_URL . "/contact.html";
    }
    
    /**
     * URL de l'accueil
     */
    public static function homeUrl(): string
    {
        return SITE_URL;
    }
}
