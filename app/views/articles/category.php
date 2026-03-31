<div class="category-page">
    <h1>Catégorie: <?= htmlspecialchars($category['libelle']) ?></h1>
    
    <?php if (!empty($category['description'])): ?>
        <p class="category-description"><?= htmlspecialchars($category['description']) ?></p>
    <?php endif; ?>
    
    <div class="articles-layout">
        <div class="articles-list">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <?php $articleUrl = UrlHelper::articleUrl($article, $category); ?>
                    <article class="article-item <?= !empty($article['image_url']) ? 'has-image' : '' ?>">
                        <div class="article-body">
                            <h2>
                                <a href="<?= $articleUrl ?>">
                                    <?= htmlspecialchars($article['title'] ?? '') ?>
                                </a>
                            </h2>
                            <?php if (!empty($article['category_name'])): ?>
                                <span class="article-category"><?= htmlspecialchars($article['category_name']) ?></span>
                            <?php endif; ?>
                            <p class="article-excerpt">
                                <?= substr(strip_tags($article['content'] ?? ''), 0, 200) ?>...
                            </p>
                            <div class="article-meta">
                                <span class="date">📅 <?= date('d/m/Y H:i', strtotime($article['published_at'] ?? $article['created_at'])) ?></span>
                                <span class="views">👁 <?= $article['views'] ?? 0 ?> vues</span>
                            </div>
                            <a href="<?= $articleUrl ?>" class="read-more">
                                Lire la suite →
                            </a>
                        </div>
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
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-articles">Aucun article dans cette catégorie.</p>
            <?php endif; ?>
        </div>
        
        <aside class="sidebar">
            <div class="widget">
                <h3>Autres catégories</h3>
                <ul class="categories-widget">
                    <?php foreach ($categories as $cat): ?>
                        <li class="<?= $cat['id'] === $category['id'] ? 'active' : '' ?>">
                            <a href="<?= UrlHelper::categoryUrl($cat) ?>">
                                <?= htmlspecialchars($cat['libelle']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</div>
