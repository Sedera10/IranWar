<div class="home-page">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Informations sur la guerre en Iran</h1>
            <p>Suivez les dernières actualités, analyses et reportages sur le conflit en Iran</p>
        </div>
    </section>
    
    <!-- Articles récents -->
    <section class="recent-articles">
        <h2>Dernières actualités</h2>
        
        <div class="articles-grid">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <article class="article-card">
                        <div class="article-content">
                            <h3>
                                <a href="<?= SITE_URL ?>/articles/show/<?= $article['id'] ?>">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h3>
                            <p class="article-excerpt">
                                <?= substr(strip_tags($article['content']), 0, 150) ?>...
                            </p>
                            <div class="article-meta">
                                <span class="date"><?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
                                <span class="views"><?= $article['views'] ?? 0 ?> vues</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-articles">Aucun article disponible pour le moment.</p>
            <?php endif; ?>
        </div>
        
        <div class="view-all">
            <a href="<?= SITE_URL ?>/articles" class="btn btn-primary">Voir toutes les actualités</a>
        </div>
    </section>
    
    <!-- Catégories -->
    <?php if (!empty($categories)): ?>
    <section class="categories-section">
        <h2>Catégories</h2>
        <div class="categories-list">
            <?php foreach ($categories as $category): ?>
                <a href="<?= SITE_URL ?>/articles/category/<?= $category['id'] ?>" class="category-tag">
                    <?= htmlspecialchars($category['libelle']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>
