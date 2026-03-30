<?php
/**
 * Controller de base - Classe parente pour tous les contrôleurs
 */
abstract class Controller
{
    protected array $data = [];
    
    /**
     * Charger une vue avec des données
     */
    protected function view(string $viewName, array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
        extract($this->data);
        
        $viewFile = VIEWS_PATH . $viewName . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("Vue '{$viewName}' non trouvée");
        }
    }
    
    /**
     * Charger une vue avec le layout principal
     */
    protected function render(string $viewName, array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
        $this->data['content'] = $viewName;
        
        extract($this->data);
        require_once VIEWS_PATH . 'layouts/main.php';
    }
    
    /**
     * Charger un modèle
     */
    protected function model(string $modelName): object
    {
        $modelFile = MODELS_PATH . $modelName . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $modelName();
        }
        
        throw new Exception("Modèle '{$modelName}' non trouvé");
    }
    
    /**
     * Redirection
     */
    protected function redirect(string $url): void
    {
        header("Location: " . SITE_URL . '/' . ltrim($url, '/'));
        exit;
    }
    
    /**
     * Réponse JSON
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Vérifier si la requête est POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Récupérer une donnée POST sécurisée
     */
    protected function post(string $key, $default = null)
    {
        return isset($_POST[$key]) ? htmlspecialchars(trim($_POST[$key])) : $default;
    }
    
    /**
     * Récupérer une donnée GET sécurisée
     */
    protected function get(string $key, $default = null)
    {
        return isset($_GET[$key]) ? htmlspecialchars(trim($_GET[$key])) : $default;
    }
}
