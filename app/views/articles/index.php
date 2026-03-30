<div class="articles-page">
    <h1>Actualités</h1>
    
    <div class="articles-layout">
        <!-- Liste des articles -->
        <div class="articles-list">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <article class="article-item">
                        <?php if (!empty($article['image'])): ?>
                            <div class="article-image">
                                <img src="<?= SITE_URL ?>/public/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="article-body">
                            <h2>
                                <a href="<?= SITE_URL ?>/articles/show/<?= htmlspecialchars($article['slug']) ?>">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h2>
                            <p class="article-excerpt">
                                <?= substr(strip_tags($article['content']), 0, 200) ?>...
                            </p>
                            <div class="article-meta">
                                <span class="date"><?= date('d/m/Y H:i', strtotime($article['created_at'])) ?></span>
                                <span class="views"><?= $article['views'] ?? 0 ?> vues</span>
                            </div>
                            <a href="<?= SITE_URL ?>/articles/show/<?= htmlspecialchars($article['slug']) ?>" class="read-more">
                                Lire la suite →
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <?php if (isset($pagination) && $pagination['totalPages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['page'] > 1): ?>
                            <a href="<?= SITE_URL ?>/articles?page=<?= $pagination['page'] - 1 ?>" class="prev">← Précédent</a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
                            <a href="<?= SITE_URL ?>/articles?page=<?= $i ?>" class="<?= $i === $pagination['page'] ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($pagination['page'] < $pagination['totalPages']): ?>
                            <a href="<?= SITE_URL ?>/articles?page=<?= $pagination['page'] + 1 ?>" class="next">Suivant →</a>
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
                                <a href="<?= SITE_URL ?>/articles/category/<?= htmlspecialchars($category['libelle']) ?>">
                                    <?= htmlspecialchars($category['description']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
    </div>
</div>
