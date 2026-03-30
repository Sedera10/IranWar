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
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="<?= SITE_URL ?>" class="logo">
                    <h1><?= SITE_NAME ?></h1>
                </a>
                
                <nav class="main-nav">
                    <ul>
                        <li><a href="<?= SITE_URL ?>">Accueil</a></li>
                        <li><a href="<?= SITE_URL ?>/articles">Actualités</a></li>
                        <li><a href="<?= SITE_URL ?>/home/about">À propos</a></li>
                        <li><a href="<?= SITE_URL ?>/home/contact">Contact</a></li>
                    </ul>
                </nav>
                
                <!-- Formulaire de recherche -->
                <form action="<?= SITE_URL ?>/articles/search" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Rechercher..." required>
                    <button type="submit">🔍</button>
                </form>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
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
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?= SITE_NAME ?></h3>
                    <p><?= SITE_DESCRIPTION ?></p>
                </div>
                
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="<?= SITE_URL ?>">Accueil</a></li>
                        <li><a href="<?= SITE_URL ?>/articles">Actualités</a></li>
                        <li><a href="<?= SITE_URL ?>/home/about">À propos</a></li>
                        <li><a href="<?= SITE_URL ?>/home/contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Catégories</h3>
                    <ul>
                        <?php if (isset($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <li><a href="<?= SITE_URL ?>/articles/category/<?= $cat['id'] ?>"><?= htmlspecialchars($cat['libelle']) ?></a></li>
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
    
    <!-- JavaScript -->
    <script src="<?= SITE_URL ?>/public/js/main.js"></script>
</body>
</html>
