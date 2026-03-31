<?php
/**
 * Application principale - Routeur MVC
 */
class App
{
    protected string $controller = DEFAULT_CONTROLLER;
    protected string $action = DEFAULT_ACTION;
    protected array $params = [];
    
    public function run(): void
    {
        $this->parseUrl();
        $this->dispatch();
    }
    
    protected function parseUrl(): void
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        
        if (!empty($url)) {
            $parts = explode('/', $url);
            
            // Controller
            if (isset($parts[0]) && !empty($parts[0])) {
                $this->controller = ucfirst(strtolower($parts[0]));
            }
            
            // Action
            if (isset($parts[1]) && !empty($parts[1])) {
                $this->action = strtolower($parts[1]);
            }
            
            // Paramètres
            if (count($parts) > 2) {
                $this->params = array_slice($parts, 2);
            }
        }
    }
    
    protected function dispatch(): void
    {
        $controllerName = $this->controller . 'Controller';
        $controllerFile = CONTROLLERS_PATH . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                
                if (method_exists($controller, $this->action)) {
                    call_user_func_array([$controller, $this->action], $this->params);
                } else {
                    $this->error404("Action '{$this->action}' non trouvée");
                }
            } else {
                $this->error404("Classe '{$controllerName}' non trouvée");
            }
        } else {
            $this->error404("Controller '{$controllerName}' non trouvé");
        }
    }
    
    protected function error404(string $message = ''): void
    {
        http_response_code(404);
        
        // Inclure la page 404 stylisée
        if (file_exists(ROOT_PATH . '/404.php')) {
            include ROOT_PATH . '/404.php';
        } else {
            // Fallback si le fichier n'existe pas
            echo '<!DOCTYPE html><html><head><title>404</title></head><body>';
            echo '<h1>Page non trouvée</h1>';
            if (DEBUG_MODE && !empty($message)) {
                echo "<p>{$message}</p>";
            }
            echo '</body></html>';
        }
        exit;
    }
}
