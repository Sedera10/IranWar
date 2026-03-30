<article class="article-single">
    <header class="article-header">
        <?php if (!empty($article['category_name'])): ?>
            <span class="article-category-badge"><?= htmlspecialchars($article['category_name']) ?></span>
        <?php endif; ?>
        <h1><?= htmlspecialchars($article['title']) ?></h1>
    </header>
    
    <?php if (!empty($image)): ?>
        <div class="article-featured-image">
            <img src="<?= SITE_URL ?>/public/<?= htmlspecialchars($image['url']) ?>" alt="<?= htmlspecialchars($image['alt_text'] ?? $article['title']) ?>">
        </div>
    <?php endif; ?>
    
    <div class="article-meta">
        <span class="date">📅 Publié le <?= date('d/m/Y à H:i', strtotime($article['published_at'] ?? $article['created_at'])) ?></span>
        <?php if (!empty($article['author_name'])): ?>
            <span class="author">✍️ par <?= htmlspecialchars($article['author_name']) ?></span>
        <?php endif; ?>
        <span class="views">👁️ <?= $article['views'] ?? 0 ?> vues</span>
    </div>
    
    <div class="article-content">
        <?= $article['content'] ?>
    </div>
    
    <footer class="article-footer">
        <div class="share-buttons">
            <span>Partager:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/articles/show/' . $article['id']) ?>" target="_blank" rel="noopener">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/articles/show/' . $article['id']) ?>&text=<?= urlencode($article['title']) ?>" target="_blank" rel="noopener">Twitter</a>
        </div>
        
        <div class="back-link">
            <a href="<?= SITE_URL ?>/articles">← Retour aux actualités</a>
        </div>
    </footer>
</article>
