<?php
/**
 * ArticlesController - Gestion des articles côté public
 */
class ArticlesController extends Controller
{
    private Article $articleModel;
    private Category $categoryModel;
    
    public function __construct()
    {
        $this->articleModel = $this->model('Article');
        $this->categoryModel = $this->model('Category');
    }
    
    /**
     * Liste des articles
     */
    public function index(): void
    {
        $page = (int) ($this->get('page') ?? 1);
        $pagination = $this->articleModel->paginatePublished($page, 10);
        
        $data = [
            'pageTitle' => 'Actualités - ' . SITE_NAME,
            'metaDescription' => 'Toutes les actualités sur la guerre en Iran',
            'articles' => $pagination['data'],
            'pagination' => $pagination,
            'categories' => $this->categoryModel->getActive()
        ];
        
        $this->render('articles/index', $data);
    }
    
    /**
     * Afficher un article
     */
    public function show(string $id = ''): void
    {
        if (empty($id)) {
            $this->redirect('articles');
            return;
        }
        
        $article = $this->articleModel->findById((int) $id);
        
        if (!$article) {
            http_response_code(404);
            $this->render('layouts/404', ['pageTitle' => 'Article non trouvé']);
            return;
        }
        
        // Incrémenter les vues
        $this->articleModel->incrementViews($article['id']);
        
        // Récupérer l'image depuis la table media
        $mediaModel = $this->model('Media');
        $image = $mediaModel->getMainByArticle($article['id']);
        
        $data = [
            'pageTitle' => $article['title'] . ' - ' . SITE_NAME,
            'metaDescription' => substr(strip_tags($article['content']), 0, 160),
            'article' => $article,
            'image' => $image,
            'categories' => $this->categoryModel->getActive()
        ];
        
        $this->render('articles/show', $data);
    }
    
    /**
     * Articles par catégorie (par ID)
     */
    public function category(string $id = ''): void
    {
        // Convertir en entier pour la recherche par ID
        $categoryId = (int) $id;
        $category = $this->categoryModel->findById($categoryId);
        
        if (!$category) {
            $this->redirect('articles');
            return;
        }
        
        $articles = $this->articleModel->getByCategory($category['id']);
        
        $data = [
            'pageTitle' => $category['libelle'] . ' - ' . SITE_NAME,
            'metaDescription' => 'Articles de la catégorie ' . $category['libelle'],
            'category' => $category,
            'articles' => $articles,
            'categories' => $this->categoryModel->getActive()
        ];
        
        $this->render('articles/category', $data);
    }
    
    /**
     * Recherche d'articles
     */
    public function search(): void
    {
        $keyword = $this->get('q') ?? '';
        $articles = [];
        
        if (!empty($keyword)) {
            $articles = $this->articleModel->search($keyword);
        }
        
        $data = [
            'pageTitle' => 'Recherche: ' . $keyword . ' - ' . SITE_NAME,
            'metaDescription' => 'Résultats de recherche pour ' . $keyword,
            'keyword' => $keyword,
            'articles' => $articles,
            'categories' => $this->categoryModel->getActive()
        ];
        
        $this->render('articles/search', $data);
    }
}
