<div class="articles-page">
    <h1>Actualités</h1>
    
    <div class="articles-layout">
        <!-- Liste des articles -->
        <div class="articles-list">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <?php 
                    $articleCategory = null;
                    if (!empty($article['category_id']) && !empty($article['category_name'])) {
                        $articleCategory = ['id' => $article['category_id'], 'libelle' => $article['category_name']];
                    }
                    $articleUrl = UrlHelper::articleUrl($article, $articleCategory);
                    ?>
                    <article class="article-item <?= !empty($article['image_url']) ? 'has-image' : '' ?>">
                        <div class="article-body">
                            <h2>
                                <a href="<?= $articleUrl ?>">
                                    <?= htmlspecialchars($article['title'] ?? '') ?>
                                </a>
                            </h2>
                            <?php if (!empty($article['category_name'])): ?>
                                <a href="<?= UrlHelper::categoryUrl(['id' => $article['category_id'], 'libelle' => $article['category_name']]) ?>" class="article-category">
                                    <?= htmlspecialchars($article['category_name']) ?>
                                </a>
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
                
                <!-- Pagination -->
                <?php if (isset($pagination) && $pagination['totalPages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['page'] > 1): ?>
                            <a href="<?= UrlHelper::actualitesUrl() ?>?page=<?= $pagination['page'] - 1 ?>" class="prev">← Précédent</a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
                            <a href="<?= UrlHelper::actualitesUrl() ?>?page=<?= $i ?>" class="<?= $i === $pagination['page'] ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($pagination['page'] < $pagination['totalPages']): ?>
                            <a href="<?= UrlHelper::actualitesUrl() ?>?page=<?= $pagination['page'] + 1 ?>" class="next">Suivant →</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="no-articles">Aucun article disponible pour le moment.</p>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="widget">
                <h3>Catégories</h3>
                <ul class="categories-widget">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="<?= UrlHelper::categoryUrl($category) ?>">
                                    <?= htmlspecialchars($category['libelle'] ?? '') ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
    </div>
</div>
