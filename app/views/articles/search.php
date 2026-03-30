<div class="search-page">
    <h1>Recherche: "<?= htmlspecialchars($keyword) ?>"</h1>
    
    <form action="<?= SITE_URL ?>/articles/search" method="GET" class="search-form-large">
        <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Rechercher...">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
    
    <div class="search-results">
        <?php if (!empty($articles)): ?>
            <p class="results-count"><?= count($articles) ?> résultat(s) trouvé(s)</p>
            
            <?php foreach ($articles as $article): ?>
                <article class="article-item">
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
        <?php elseif (!empty($keyword)): ?>
            <p class="no-results">Aucun résultat trouvé pour "<?= htmlspecialchars($keyword) ?>"</p>
        <?php else: ?>
            <p class="no-results">Entrez un terme de recherche ci-dessus.</p>
        <?php endif; ?>
    </div>
</div>
