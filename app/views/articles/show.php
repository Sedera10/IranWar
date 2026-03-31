<?php 
// Préparer la catégorie pour l'URL
$articleCategory = null;
if (!empty($article['category_id']) && !empty($article['category_name'])) {
    $articleCategory = ['id' => $article['category_id'], 'libelle' => $article['category_name']];
}
$currentArticleUrl = UrlHelper::articleUrl($article, $articleCategory);
?>
<div class="article-page">
    <article class="article-single">
        <header class="article-header">
            <?php if (!empty($article['category_name'])): ?>
                <a href="<?= UrlHelper::categoryUrl(['id' => $article['category_id'], 'libelle' => $article['category_name']]) ?>" class="article-category-badge">
                    <?= htmlspecialchars($article['category_name']) ?>
                </a>
            <?php endif; ?>
            <h1><?= htmlspecialchars($article['title']) ?></h1>
            <div class="article-meta">
                <span class="date">📅 <?= date('d/m/Y à H:i', strtotime($article['published_at'] ?? $article['created_at'])) ?></span>
                <?php if (!empty($article['author_name'])): ?>
                    <span class="author">✍️ <?= htmlspecialchars($article['author_name']) ?></span>
                <?php endif; ?>
                <span class="views">👁️ <?= $article['views'] ?? 0 ?> vues</span>
            </div>
        </header>
        
        <?php if (!empty($image)): ?>
            <div class="article-featured-image">
                <img src="<?= SITE_URL ?>/public/<?= htmlspecialchars($image['url']) ?>" 
                     alt="<?= htmlspecialchars($image['alt_text'] ?? $article['title']) ?>"
                     loading="lazy"
                     decoding="async">
            </div>
        <?php endif; ?>
        
        <div class="article-content">
            <?= $article['content'] ?>
        </div>
        
        <footer class="article-footer">
            <div class="share-buttons">
                <span>Partager cet article :</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentArticleUrl) ?>" 
                   target="_blank" rel="noopener" class="share-btn facebook">
                    📘 Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentArticleUrl) ?>&text=<?= urlencode($article['title']) ?>" 
                   target="_blank" rel="noopener" class="share-btn twitter">
                    🐦 Twitter
                </a>
                <a href="https://wa.me/?text=<?= urlencode($article['title'] . ' - ' . $currentArticleUrl) ?>" 
                   target="_blank" rel="noopener" class="share-btn whatsapp">
                    💬 WhatsApp
                </a>
            </div>
        </footer>
    </article>
    
    <!-- Sidebar avec articles connexes -->
    <aside class="article-sidebar">
        <div class="widget">
            <h3>📰 Articles récents</h3>
            <?php if (!empty($recentArticles)): ?>
                <ul class="recent-articles-list">
                    <?php foreach ($recentArticles as $recent): ?>
                        <?php if ($recent['id'] != $article['id']): ?>
                            <?php 
                            $recentCategory = null;
                            if (!empty($recent['category_id']) && !empty($recent['category_name'])) {
                                $recentCategory = ['id' => $recent['category_id'], 'libelle' => $recent['category_name']];
                            }
                            ?>
                            <li>
                                <a href="<?= UrlHelper::articleUrl($recent, $recentCategory) ?>">
                                    <?= htmlspecialchars($recent['title']) ?>
                                </a>
                                <small><?= date('d/m/Y', strtotime($recent['published_at'] ?? $recent['created_at'])) ?></small>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <div class="widget">
            <h3>📂 Catégories</h3>
            <?php if (!empty($categories)): ?>
                <ul class="categories-widget">
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?= UrlHelper::categoryUrl($cat) ?>">
                                <?= htmlspecialchars($cat['libelle']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <div class="back-link">
            <a href="<?= UrlHelper::actualitesUrl() ?>" class="btn btn-secondary">
                ← Retour aux actualités
            </a>
        </div>
    </aside>
</div>
