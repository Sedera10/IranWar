<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Articles' ?> - Administration</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/admin.min.css">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/public/images/logo.png">
</head>
<body class="admin-page">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="<?= SITE_URL ?>/public/images/logo.png" alt="Logo IranWar" class="sidebar-logo" loading="lazy">
            <h2><?= SITE_NAME ?></h2>
            <span>Administration</span>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li><a href="<?= SITE_URL ?>/admin"><span class="nav-icon">📊</span> Dashboard</a></li>
                <li><a href="<?= SITE_URL ?>/admin/articles" class="active"><span class="nav-icon">📝</span> Articles</a></li>
                <li><a href="<?= SITE_URL ?>/admin/createArticle"><span class="nav-icon">➕</span> Nouvel article</a></li>
                <li><a href="<?= SITE_URL ?>" target="_blank"><span class="nav-icon">🌐</span> Voir le site</a></li>
                <li><a href="<?= SITE_URL ?>/admin/logout"><span class="nav-icon">🚪</span> Déconnexion</a></li>
            </ul>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <h1>Gestion des articles</h1>
            <a href="<?= SITE_URL ?>/admin/createArticle" class="btn btn-primary">+ Nouvel article</a>
        </header>
        
        <div class="admin-content">
            <?php if (!empty($articles)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Vues</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?= $article['id'] ?></td>
                                <td><?= htmlspecialchars($article['title']) ?></td>
                                <td><?= htmlspecialchars($article['category_name'] ?? '-') ?></td>
                                <td>
                                    <?php 
                                    $statusName = $article['status_name'] ?? ($article['published_at'] ? 'Publié' : 'Brouillon');
                                    $statusClass = strtolower(str_replace(['é', 'è'], 'e', $statusName));
                                    ?>
                                    <span class="status-badge status-<?= $statusClass ?>">
                                        <?= htmlspecialchars($statusName) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($article['created_at'])) ?></td>
                                <td><?= $article['views'] ?? 0 ?></td>
                                <td class="actions">
                                    <a href="<?= SITE_URL ?>/articles/show/<?= $article['id'] ?>" target="_blank" class="btn btn-small btn-view">Voir</a>
                                    <a href="<?= SITE_URL ?>/admin/editArticle/<?= $article['id'] ?>" class="btn btn-small btn-edit">Modifier</a>
                                    <a href="<?= SITE_URL ?>/admin/deleteArticle/<?= $article['id'] ?>" class="btn btn-small btn-delete" onclick="return confirm('Supprimer cet article ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>Aucun article pour le moment.</p>
                    <a href="<?= SITE_URL ?>/admin/createArticle" class="btn btn-primary">Créer votre premier article</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
