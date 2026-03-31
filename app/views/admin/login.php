<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Connexion' ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/admin.min.css">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/public/images/logo.png">
</head>
<body class="login-page">
    <div class="login-wrapper">
        <!-- Formulaire à gauche -->
        <div class="login-form-section">
            <div class="login-box">
                <h1>Administration</h1>
                <h2><?= SITE_NAME ?></h2>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form action="<?= SITE_URL ?>/admin/login" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="admin@iranwar.info" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" value="admin123" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
                
                <p class="back-link">
                    <a href="<?= SITE_URL ?>">← Retour au site</a>
                </p>
            </div>
        </div>
        
        <!-- Image à droite -->
        <div class="login-image-section" style="background-image: url('<?= SITE_URL ?>/public/images/logPhoto.webp');">
            <div class="overlay-text">
                <h2>IranWar Info</h2>
                <p>Plateforme d'administration pour la gestion des contenus et des actualités.</p>
            </div>
        </div>
    </div>
</body>
</html>
