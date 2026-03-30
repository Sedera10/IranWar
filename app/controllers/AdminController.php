<?php
/**
 * AdminController - Panneau d'administration
 */
class AdminController extends Controller
{
    public function __construct()
    {
        // Vérifier l'authentification pour toutes les actions sauf login
        $action = $_GET['url'] ?? '';
        if (strpos($action, 'admin/login') === false && !User::isLoggedIn()) {
            $this->redirect('admin/login');
        }
    }
    
    /**
     * Dashboard
     */
    public function index(): void
    {
        $articleModel = $this->model('Article');
        $categoryModel = $this->model('Category');
        
        $data = [
            'pageTitle' => 'Dashboard - Administration',
            'totalArticles' => $articleModel->count(),
            'totalCategories' => $categoryModel->count(),
            'recentArticles' => $articleModel->getPublished(5)
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    /**
     * Page de connexion
     */
    public function login(): void
    {
        if (User::isLoggedIn()) {
            $this->redirect('admin');
            return;
        }
        
        $error = '';
        
        if ($this->isPost()) {
            $email = $this->post('email');
            $password = $_POST['password'] ?? '';
            
            $userModel = $this->model('User');
            $user = $userModel->authenticate($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user;
                $this->redirect('admin');
                return;
            } else {
                $error = 'Email ou mot de passe incorrect.';
            }
        }
        
        $this->view('admin/login', [
            'pageTitle' => 'Connexion - Administration',
            'error' => $error
        ]);
    }
    
    /**
     * Déconnexion
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('admin/login');
    }
    
    /**
     * Liste des articles (admin)
     */
    public function articles(): void
    {
        $articleModel = $this->model('Article');
        
        $this->view('admin/articles-list', [
            'pageTitle' => 'Gestion des articles',
            'articles' => $articleModel->all()
        ]);
    }
    
    /**
     * Créer un article
     */
    public function createArticle(): void
    {
        $categoryModel = $this->model('Category');
        $error = '';
        $success = '';
        
        if ($this->isPost()) {
            $articleModel = $this->model('Article');
            
            $title = $this->post('title');
            $content = $_POST['content'] ?? ''; // TinyMCE content (HTML)
            $categoryId = (int) $this->post('category_id');
            $status = $this->post('status') ?? 'draft';
            $keywords = $this->post('keywords');
            
            if ($title && $content) {
                $slug = $articleModel->generateSlug($title);
                
                $data = [
                    'title' => $title,
                    'slug' => $slug,
                    'content' => $content,
                    'category_id' => $categoryId,
                    'status' => $status,
                    'keywords' => $keywords,
                    'author_id' => $_SESSION['user_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'views' => 0
                ];
                
                // Gestion de l'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->uploadImage($_FILES['image']);
                    if ($imagePath) {
                        $data['image'] = $imagePath;
                    }
                }
                
                $articleModel->create($data);
                $success = 'Article créé avec succès!';
            } else {
                $error = 'Le titre et le contenu sont requis.';
            }
        }
        
        $this->view('admin/article-create', [
            'pageTitle' => 'Créer un article',
            'categories' => $categoryModel->all(),
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Modifier un article
     */
    public function editArticle(int $id = 0): void
    {
        $articleModel = $this->model('Article');
        $categoryModel = $this->model('Category');
        
        $article = $articleModel->find($id);
        
        if (!$article) {
            $this->redirect('admin/articles');
            return;
        }
        
        $error = '';
        $success = '';
        
        if ($this->isPost()) {
            $title = $this->post('title');
            $content = $_POST['content'] ?? '';
            $categoryId = (int) $this->post('category_id');
            $status = $this->post('status') ?? 'draft';
            $keywords = $this->post('keywords');
            
            if ($title && $content) {
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'category_id' => $categoryId,
                    'status' => $status,
                    'keywords' => $keywords,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Gestion de l'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->uploadImage($_FILES['image']);
                    if ($imagePath) {
                        $data['image'] = $imagePath;
                    }
                }
                
                $articleModel->update($id, $data);
                $success = 'Article mis à jour!';
                $article = $articleModel->find($id);
            } else {
                $error = 'Le titre et le contenu sont requis.';
            }
        }
        
        $this->view('admin/article-edit', [
            'pageTitle' => 'Modifier l\'article',
            'article' => $article,
            'categories' => $categoryModel->all(),
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Supprimer un article
     */
    public function deleteArticle(int $id = 0): void
    {
        if ($id > 0) {
            $articleModel = $this->model('Article');
            $articleModel->delete($id);
        }
        $this->redirect('admin/articles');
    }
    
    /**
     * Upload d'image
     */
    private function uploadImage(array $file): ?string
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        if (!in_array($file['type'], $allowedTypes)) {
            return null;
        }
        
        if ($file['size'] > MAX_UPLOAD_SIZE) {
            return null;
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $destination = UPLOADS_PATH . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return 'uploads/' . $filename;
        }
        
        return null;
    }
}
