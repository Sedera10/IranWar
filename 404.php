<?php
/**
 * Page 404 - Erreur serveur
 */
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .error-container {
            text-align: center;
            padding: 40px;
        }
        h1 {
            font-size: 8rem;
            color: #c41e3a;
            text-shadow: 0 0 30px rgba(196, 30, 58, 0.5);
            margin-bottom: 10px;
        }
        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 400;
        }
        p {
            color: #aaa;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: #c41e3a;
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #a01830;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(196, 30, 58, 0.4);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <h2>Page non trouvée</h2>
        <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
        <a href="/" class="btn">Retour à l'accueil</a>
    </div>
</body>
</html>
