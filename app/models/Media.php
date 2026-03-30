<?php
/**
 * Modèle Media - Gestion des médias (images)
 */
class Media extends Model
{
    protected string $table = 'media';
    
    /**
     * Récupérer les médias d'un article
     */
    public function getByArticle(int $articleId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE article_id = :article_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer l'image principale d'un article
     */
    public function getMainByArticle(int $articleId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE article_id = :article_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Supprimer les médias d'un article
     */
    public function deleteByArticle(int $articleId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE article_id = :article_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['article_id' => $articleId]);
    }
}
