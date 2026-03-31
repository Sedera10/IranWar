<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> - Administration</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/admin.min.css">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/public/images/logo.png">
</head>
<body class="admin-page">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="<?= SITE_URL ?>/public/images/logo.png" alt="Logo" class="sidebar-logo">
            <h2><?= SITE_NAME ?></h2>
            <span>Administration</span>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li><a href="<?= SITE_URL ?>/admin" class="active"><span class="nav-icon">📊</span> Dashboard</a></li>
                <li><a href="<?= SITE_URL ?>/admin/articles"><span class="nav-icon">📝</span> Articles</a></li>
                <li><a href="<?= SITE_URL ?>/admin/createArticle"><span class="nav-icon">➕</span> Nouvel article</a></li>
                <li><a href="<?= SITE_URL ?>" target="_blank"><span class="nav-icon">🌐</span> Voir le site</a></li>
                <li><a href="<?= SITE_URL ?>/admin/logout"><span class="nav-icon">🚪</span> Déconnexion</a></li>
            </ul>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <h1>Dashboard</h1>
            <div class="user-info">
                Bienvenue, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?>
            </div>
        </header>
        
        <div class="admin-content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📝</div>
                    <div class="stat-info">
                        <h3><?= $totalArticles ?? 0 ?></h3>
                        <p>Articles</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📁</div>
                    <div class="stat-info">
                        <h3><?= $totalCategories ?? 0 ?></h3>
                        <p>Catégories</p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Articles -->
            <div class="admin-section">
                <h2>Articles récents</h2>
                
                <?php if (!empty($recentArticles)): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Date</th>
                                <th>Vues</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentArticles as $article): ?>
                                <tr>
                                    <td><?= htmlspecialchars($article['title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($article['created_at'])) ?></td>
                                    <td><?= $article['views'] ?? 0 ?></td>
                                    <td>
                                        <a href="<?= SITE_URL ?>/admin/editArticle/<?= $article['id'] ?>" class="btn btn-small">Modifier</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun article pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
