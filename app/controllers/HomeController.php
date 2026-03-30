<?php
/**
 * HomeController - Page d'accueil du site
 */
class HomeController extends Controller
{
    /**
     * Page d'accueil
     */
    public function index(): void
    {
        $articleModel = $this->model('Article');
        $categoryModel = $this->model('Category');
        
        $data = [
            'pageTitle' => 'Accueil - ' . SITE_NAME,
            'metaDescription' => SITE_DESCRIPTION,
            'metaKeywords' => SITE_KEYWORDS,
            'articles' => $articleModel->getPublished(6),
            'categories' => $categoryModel->getActive()
        ];
        
        $this->render('home/index', $data);
    }
    
    /**
     * Page À propos
     */
    public function about(): void
    {
        $data = [
            'pageTitle' => 'À propos - ' . SITE_NAME,
            'metaDescription' => 'En savoir plus sur ' . SITE_NAME . ' et notre mission d\'information.',
        ];
        
        $this->render('home/about', $data);
    }
    
    /**
     * Page Contact
     */
    public function contact(): void
    {
        $data = [
            'pageTitle' => 'Contact - ' . SITE_NAME,
            'metaDescription' => 'Contactez l\'équipe de ' . SITE_NAME,
            'success' => false,
            'error' => ''
        ];
        
        if ($this->isPost()) {
            $name = $this->post('name');
            $email = $this->post('email');
            $message = $this->post('message');
            
            if ($name && $email && $message) {
                // Ici, envoyer l'email ou sauvegarder le message
                $data['success'] = true;
            } else {
                $data['error'] = 'Veuillez remplir tous les champs.';
            }
        }
        
        $this->render('home/contact', $data);
    }
}
