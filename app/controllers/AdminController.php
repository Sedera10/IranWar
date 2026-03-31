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
            'articles' => $articleModel->getAllWithDetails()
        ]);
    }
    
    /**
     * Créer un article
     */
    public function createArticle(): void
    {
        $categoryModel = $this->model('Category');
        $statutModel = $this->model('Statut');
        $error = '';
        $success = '';
        
        if ($this->isPost()) {
            $articleModel = $this->model('Article');
            $articleStatutModel = $this->model('ArticleStatut');
            
            $title = $this->post('title');
            $content = $_POST['content'] ?? '';
            $categoryId = (int) $this->post('category_id');
            $statusId = (int) $this->post('status');
            $publishedAt = $this->post('published_at');
            
            if ($title && $content) {
                // Préparer les données de l'article
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'category_id' => $categoryId ?: null,
                    'author_id' => $_SESSION['user_id'],
                    'views' => 0
                ];
                
                // Gestion de la date de publication
                $statut = $statutModel->findById($statusId);
                if ($statut && strtolower($statut['libelle']) === 'published') {
                    // Utiliser la date sélectionnée ou la date actuelle
                    $data['published_at'] = !empty($publishedAt) ? date('Y-m-d H:i:s', strtotime($publishedAt)) : date('Y-m-d H:i:s');
                }
                
                // Créer l'article et récupérer l'ID
                $articleId = $articleModel->createAndGetId($data);
                
                if ($articleId) {
                    // Lier l'article au statut via articles_statuts
                    if ($statusId > 0) {
                        $articleStatutModel->create([
                            'id_1' => $statusId,
                            'id_2' => $articleId,
                            'date_' => date('Y-m-d H:i:s')
                        ]);
                    }
                    
                    // Gérer l'image (table media)
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $imagePath = $this->uploadImage($_FILES['image']);
                        if ($imagePath) {
                            $mediaModel = $this->model('Media');
                            $mediaModel->create([
                                'url' => $imagePath,
                                'alt_text' => $title,
                                'article_id' => $articleId
                            ]);
                        }
                    }
                    
                    $success = 'Article créé avec succès!';
                } else {
                    $error = 'Erreur lors de la création de l\'article.';
                }
            } else {
                $error = 'Le titre et le contenu sont requis.';
            }
        }
        
        $this->view('admin/article-create', [
            'pageTitle' => 'Créer un article',
            'categories' => $categoryModel->all(),
            'statuts' => $statutModel->all(),
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
        $statutModel = $this->model('Statut');
        $articleStatutModel = $this->model('ArticleStatut');
        $mediaModel = $this->model('Media');
        
        $article = $articleModel->findById($id);
        
        if (!$article) {
            $this->redirect('admin/articles');
            return;
        }
        
        // Récupérer le statut actuel de l'article
        $currentStatus = $articleStatutModel->getByArticle($id);
        $article['status_id'] = $currentStatus ? $currentStatus['id_1'] : null;
        
        // Récupérer l'image actuelle
        $currentImage = $mediaModel->getMainByArticle($id);
        
        $error = '';
        $success = '';
        
        if ($this->isPost()) {
            $title = $this->post('title');
            $content = $_POST['content'] ?? '';
            $categoryId = (int) $this->post('category_id');
            $statusId = (int) $this->post('status');
            $publishedAt = $this->post('published_at');
            
            if ($title && $content) {
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'category_id' => $categoryId ?: null,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Gérer published_at selon le statut et la date sélectionnée
                $statut = $statutModel->findById($statusId);
                if ($statut && strtolower($statut['libelle']) === 'published') {
                    $data['published_at'] = !empty($publishedAt) ? date('Y-m-d H:i:s', strtotime($publishedAt)) : date('Y-m-d H:i:s');
                } else {
                    $data['published_at'] = null;
                }
                
                // Mettre à jour l'article
                $articleModel->update($id, $data);
                
                // Mettre à jour le statut dans articles_statuts
                if ($statusId > 0) {
                    $articleStatutModel->updateStatus($id, $statusId);
                }
                
                // Gestion de l'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->uploadImage($_FILES['image']);
                    if ($imagePath) {
                        // Supprimer l'ancienne image si existe
                        $mediaModel->deleteByArticle($id);
                        // Ajouter la nouvelle
                        $mediaModel->create([
                            'url' => $imagePath,
                            'alt_text' => $title,
                            'article_id' => $id
                        ]);
                    }
                }
                
                $success = 'Article mis à jour!';
                $article = $articleModel->findById($id);
                $article['status_id'] = $statusId;
                $currentImage = $mediaModel->getMainByArticle($id);
            } else {
                $error = 'Le titre et le contenu sont requis.';
            }
        }
        
        $this->view('admin/article-edit', [
            'pageTitle' => 'Modifier l\'article',
            'article' => $article,
            'image' => $currentImage,
            'categories' => $categoryModel->all(),
            'statuts' => $statutModel->all(),
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
     * Upload d'image avec optimisation
     * - Redimensionnement automatique
     * - Conversion en WebP
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
        
        // Dimensions maximales pour les images articles
        $maxWidth = 1200;
        $maxHeight = 800;
        
        // Créer l'image source
        $sourceImage = null;
        switch ($file['type']) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($file['tmp_name']);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($file['tmp_name']);
                break;
        }
        
        if (!$sourceImage) {
            // Fallback: upload sans traitement
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $destination = UPLOADS_PATH . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return 'uploads/' . $filename;
            }
            return null;
        }
        
        // Obtenir les dimensions originales
        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);
        
        // Calculer les nouvelles dimensions (proportionnelles)
        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight, 1);
        $newWidth = (int) ($origWidth * $ratio);
        $newHeight = (int) ($origHeight * $ratio);
        
        // Créer l'image redimensionnée
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Préserver la transparence pour PNG
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        
        // Redimensionner
        imagecopyresampled(
            $resizedImage, $sourceImage,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );
        
        // Nom du fichier en WebP
        $filename = uniqid() . '_' . time() . '.webp';
        $destination = UPLOADS_PATH . $filename;
        
        // Sauvegarder en WebP (qualité 85%)
        if (imagewebp($resizedImage, $destination, 85)) {
            imagedestroy($sourceImage);
            imagedestroy($resizedImage);
            return 'uploads/' . $filename;
        }
        
        // Libérer la mémoire
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
        
        return null;
    }
}
