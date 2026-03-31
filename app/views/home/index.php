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
                    <?php 
                    // Préparer la catégorie pour l'URL
                    $articleCategory = null;
                    if (!empty($article['category_id']) && !empty($article['category_name'])) {
                        $articleCategory = ['id' => $article['category_id'], 'libelle' => $article['category_name']];
                    }
                    $articleUrl = UrlHelper::articleUrl($article, $articleCategory);
                    ?>
                    <article class="article-card <?= !empty($article['image_url']) ? 'has-image' : '' ?>">
                        <?php if (!empty($article['image_url'])): ?>
                            <div class="article-thumbnail">
                                <a href="<?= $articleUrl ?>">
                                    <img src="<?= SITE_URL ?>/public/<?= htmlspecialchars($article['image_url']) ?>" 
                                         alt="<?= htmlspecialchars($article['image_alt'] ?? $article['title']) ?>"
                                         loading="lazy"
                                         decoding="async">
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="article-content">
                            <?php if (!empty($article['category_name'])): ?>
                                <a href="<?= UrlHelper::categoryUrl(['id' => $article['category_id'], 'libelle' => $article['category_name']]) ?>" class="article-category">
                                    <?= htmlspecialchars($article['category_name']) ?>
                                </a>
                            <?php endif; ?>
                            <h3>
                                <a href="<?= $articleUrl ?>">
                                    <?= htmlspecialchars($article['title'] ?? '') ?>
                                </a>
                            </h3>
                            <p class="article-excerpt">
                                <?= substr(strip_tags($article['content'] ?? ''), 0, 120) ?>...
                            </p>
                            <div class="article-meta">
                                <span class="date">📅 <?= date('d/m/Y', strtotime($article['published_at'] ?? $article['created_at'])) ?></span>
                                <span class="views">👁 <?= $article['views'] ?? 0 ?> vues</span>
                            </div>
                            <a href="<?= $articleUrl ?>" class="read-more">
                                Lire la suite →
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-articles">Aucun article disponible pour le moment.</p>
            <?php endif; ?>
        </div>
        
        <div class="view-all">
            <a href="<?= UrlHelper::actualitesUrl() ?>" class="btn btn-primary">Voir toutes les actualités</a>
        </div>
    </section>
    
    <!-- Catégories -->
    <?php if (!empty($categories)): ?>
    <section class="categories-section">
        <h2>Catégories</h2>
        <div class="categories-list">
            <?php foreach ($categories as $category): ?>
                <a href="<?= UrlHelper::categoryUrl($category) ?>" class="category-tag">
                    <?= htmlspecialchars($category['libelle'] ?? '') ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>
