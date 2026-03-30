<article class="article-single">
    <header class="article-header">
        <h1><?= htmlspecialchars($article['title']) ?></h1>
        
        <div class="article-meta">
            <span class="date">Publié le <?= date('d/m/Y à H:i', strtotime($article['created_at'])) ?></span>
            <span class="views"><?= $article['views'] ?? 0 ?> vues</span>
        </div>
    </header>
    
    <?php if (!empty($article['image'])): ?>
        <div class="article-featured-image">
            <img src="<?= SITE_URL ?>/public/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
        </div>
    <?php endif; ?>
    
    <div class="article-content">
        <?= $article['content'] ?>
    </div>
    
    <footer class="article-footer">
        <?php if (!empty($article['keywords'])): ?>
            <div class="article-tags">
                <strong>Mots-clés:</strong>
                <?php 
                $keywords = explode(',', $article['keywords']);
                foreach ($keywords as $keyword): 
                ?>
                    <span class="tag"><?= htmlspecialchars(trim($keyword)) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="share-buttons">
            <span>Partager:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/articles/show/' . $article['slug']) ?>" target="_blank" rel="noopener">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/articles/show/' . $article['slug']) ?>&text=<?= urlencode($article['title']) ?>" target="_blank" rel="noopener">Twitter</a>
        </div>
        
        <div class="back-link">
            <a href="<?= SITE_URL ?>/articles">← Retour aux actualités</a>
        </div>
    </footer>
</article>
