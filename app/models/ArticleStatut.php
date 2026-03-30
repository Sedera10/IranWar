<?php
class ArticleStatut extends Model
{
    protected string $table = 'articles_statuts';
    
    /**
     * Récupérer le statut d'un article
     */
    public function getByArticle(int $articleId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_2 = :article_id ORDER BY date_ DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Mettre à jour le statut d'un article
     */
    public function updateStatus(int $articleId, int $statusId): bool
    {
        // Supprimer l'ancien statut
        $sql = "DELETE FROM {$this->table} WHERE id_2 = :article_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        
        // Insérer le nouveau statut
        $sql = "INSERT INTO {$this->table} (id_1, id_2, date_) VALUES (:status_id, :article_id, :date_)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'status_id' => $statusId,
            'article_id' => $articleId,
            'date_' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Supprimer les statuts d'un article
     */
    public function deleteByArticle(int $articleId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id_2 = :article_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['article_id' => $articleId]);
    }
}
