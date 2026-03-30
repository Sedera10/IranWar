<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Créer un article' ?> - Administration</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/admin.css">
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/public/images/logo.png">
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/auubzeaa3lmb3ainmfq1goiel3mrkh4wiw1sdmqma0vty65n/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            language: 'fr_FR',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'link image media | removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 16px; }',
            images_upload_url: '<?= SITE_URL ?>/admin/uploadImage',
            automatic_uploads: true,
            file_picker_types: 'image'
        });
    </script>
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
                <li><a href="<?= SITE_URL ?>/admin"><span class="nav-icon">📊</span> Dashboard</a></li>
                <li><a href="<?= SITE_URL ?>/admin/articles"><span class="nav-icon">📝</span> Articles</a></li>
                <li><a href="<?= SITE_URL ?>/admin/createArticle" class="active"><span class="nav-icon">➕</span> Nouvel article</a></li>
                <li><a href="<?= SITE_URL ?>" target="_blank"><span class="nav-icon">🌐</span> Voir le site</a></li>
                <li><a href="<?= SITE_URL ?>/admin/logout"><span class="nav-icon">🚪</span> Déconnexion</a></li>
            </ul>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <h1>Créer un article</h1>
            <a href="<?= SITE_URL ?>/admin/articles" class="btn">← Retour</a>
        </header>
        
        <div class="admin-content">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form action="<?= SITE_URL ?>/admin/createArticle" method="POST" enctype="multipart/form-data" class="article-form">
                <div class="form-row">
                    <div class="form-group form-group-large">
                        <label for="title">Titre de l'article *</label>
                        <input type="text" id="title" name="title" required placeholder="Entrez le titre de l'article">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Catégorie</label>
                        <select id="category_id" name="category_id">
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select id="status" name="status">
                            <option value="draft">Brouillon</option>
                            <option value="published">Publié</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Image de couverture</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                
                <div class="form-group">
                    <label for="content">Contenu * (TinyMCE)</label>
                    <textarea id="content" name="content" rows="15"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="keywords">Mots-clés SEO (séparés par des virgules)</label>
                    <input type="text" id="keywords" name="keywords" placeholder="iran, guerre, actualités">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Créer l'article</button>
                    <a href="<?= SITE_URL ?>/admin/articles" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
