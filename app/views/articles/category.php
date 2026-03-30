<div class="category-page">
    <h1>Catégorie: <?= htmlspecialchars($category['name']) ?></h1>
    
    <?php if (!empty($category['description'])): ?>
        <p class="category-description"><?= htmlspecialchars($category['description']) ?></p>
    <?php endif; ?>
    
    <div class="articles-layout">
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
                                <span class="date"><?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
                            </div>
                        </div>
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
                            <a href="<?= SITE_URL ?>/articles/category/<?= htmlspecialchars($cat['slug']) ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</div>
