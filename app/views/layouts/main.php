<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO Meta Tags -->
    <title><?= $pageTitle ?? SITE_NAME ?></title>
    <meta name="description" content="<?= $metaDescription ?? SITE_DESCRIPTION ?>">
    <meta name="keywords" content="<?= $metaKeywords ?? SITE_KEYWORDS ?>">
    <meta name="author" content="<?= SITE_AUTHOR ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL ?>">
    <meta property="og:title" content="<?= $pageTitle ?? SITE_NAME ?>">
    <meta property="og:description" content="<?= $metaDescription ?? SITE_DESCRIPTION ?>">
    <meta property="og:image" content="<?= $ogImage ?? SITE_URL . '/public/images/og-default.jpg' ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= SITE_URL ?>">
    <meta property="twitter:title" content="<?= $pageTitle ?? SITE_NAME ?>">
    <meta property="twitter:description" content="<?= $metaDescription ?? SITE_DESCRIPTION ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= $canonicalUrl ?? SITE_URL ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/public/images/logo.png">
    <link rel="apple-touch-icon" href="<?= SITE_URL ?>/public/images/logo.png">
    
    <!-- Critical CSS (inline pour rendu rapide) -->
    <style><?php include ROOT_PATH . '/public/css/critical.css'; ?></style>
    
    <!-- CSS complet chargé de façon asynchrone -->
    <link rel="preload" href="<?= SITE_URL ?>/public/css/style.min.css?v=<?= filemtime(ROOT_PATH . '/public/css/style.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?= SITE_URL ?>/public/css/style.min.css"></noscript>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="<?= UrlHelper::homeUrl() ?>" class="logo">
                    <h1><?= SITE_NAME ?></h1>
                </a>
                
                <nav class="main-nav" role="navigation" aria-label="Navigation principale">
                    <ul>
                        <li><a href="<?= UrlHelper::homeUrl() ?>">Accueil</a></li>
                        <li><a href="<?= UrlHelper::actualitesUrl() ?>">Actualités</a></li>
                        <li><a href="<?= UrlHelper::aboutUrl() ?>">À propos</a></li>
                        <li><a href="<?= UrlHelper::contactUrl() ?>">Contact</a></li>
                    </ul>
                </nav>
                
                <!-- Formulaire de recherche -->
                <form action="<?= UrlHelper::searchUrl() ?>" method="GET" class="search-form" role="search">
                    <input type="text" name="q" placeholder="Rechercher..." required aria-label="Rechercher un article">
                    <button type="submit" aria-label="Lancer la recherche">🔍</button>
                </form>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <div class="container">
            <?php 
            if (isset($content)) {
                $viewFile = VIEWS_PATH . $content . '.php';
                if (file_exists($viewFile)) {
                    include $viewFile;
                }
            }
            ?>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?= SITE_NAME ?></h3>
                    <p><?= SITE_DESCRIPTION ?></p>
                </div>
                
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="<?= UrlHelper::homeUrl() ?>">Accueil</a></li>
                        <li><a href="<?= UrlHelper::actualitesUrl() ?>">Actualités</a></li>
                        <li><a href="<?= UrlHelper::aboutUrl() ?>">À propos</a></li>
                        <li><a href="<?= UrlHelper::contactUrl() ?>">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Catégories</h3>
                    <ul>
                        <?php if (isset($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <li><a href="<?= UrlHelper::categoryUrl($cat) ?>"><?= htmlspecialchars($cat['libelle']) ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Lien d'évitement pour accessibilité clavier -->
    <a href="#main-content" class="skip-link">Aller au contenu principal</a>
    
    <!-- JavaScript chargé de façon asynchrone (non-bloquant) -->
    <script src="<?= SITE_URL ?>/public/js/main.js" defer></script>
</body>
</html>
