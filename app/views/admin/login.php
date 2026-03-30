<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Connexion' ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/admin.css">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/public/images/logo.png">
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            background: #1e293b;
        }
        .login-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        .login-form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #fff;
        }
        .login-image-section {
            flex: 1;
            background-image: url('<?= SITE_URL ?>/public/images/logPhoto.webp');
            background-position: center;
            position: relative;
        }
        .login-image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 41, 59, 0.6);
        }
        .login-image-section .overlay-text {
            position: absolute;
            bottom: 50px;
            left: 50px;
            right: 50px;
            color: #fff;
            z-index: 1;
        }
        .login-image-section .overlay-text h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .login-image-section .overlay-text p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
        .login-box h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .login-box h2 {
            font-size: 1rem;
            color: #64748b;
            font-weight: normal;
            margin-bottom: 30px;
        }
        .login-box .form-group {
            margin-bottom: 20px;
        }
        .login-box .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #334155;
        }
        .login-box .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .login-box .form-group input:focus {
            outline: none;
            border-color: #2563eb;
        }
        .login-box .btn-primary {
            width: 100%;
            padding: 14px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-box .btn-primary:hover {
            background: #1d4ed8;
        }
        .login-box .back-link {
            text-align: center;
            margin-top: 25px;
        }
        .login-box .back-link a {
            color: #64748b;
            text-decoration: none;
        }
        .login-box .back-link a:hover {
            color: #2563eb;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }
        @media (max-width: 992px) {
            .login-image-section {
                display: none;
            }
            .login-form-section {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            }
            .login-box {
                background: #fff;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            }
        }
    </style>
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
        <div class="login-image-section">
            <div class="overlay-text">
                <h2>IranWar Info</h2>
                <p>Plateforme d'administration pour la gestion des contenus et des actualités.</p>
            </div>
        </div>
    </div>
</body>
</html>
