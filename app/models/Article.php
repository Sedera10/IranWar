<?php
/**
 * Modèle Article - Gestion des articles d'actualité
 * Adapté à la structure BDD simplifiée (sans colonne status/slug)
 */
class Article extends Model
{
    protected string $table = 'articles';
    
    /**
     * Récupérer les articles publiés (avec published_at non null)
     */
    public function getPublished(int $limit = 10): array
    {
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name 
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                WHERE a.published_at IS NOT NULL 
                ORDER BY a.published_at DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer un article par son ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name 
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                WHERE a.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Récupérer les articles par catégorie
     */
    public function getByCategory(int $categoryId, int $limit = 10): array
    {
        $sql = "SELECT a.*, c.libelle as category_name 
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE a.category_id = :category_id 
                AND a.published_at IS NOT NULL 
                ORDER BY a.published_at DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Rechercher des articles
     */
    public function search(string $keyword): array
    {
        $sql = "SELECT a.*, c.libelle as category_name 
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE (a.title LIKE :keyword OR a.content LIKE :keyword) 
                AND a.published_at IS NOT NULL 
                ORDER BY a.published_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }
    
    /**
     * Incrémenter les vues
     */
    public function incrementViews(int $id): bool
    {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Récupérer tous les articles (pour admin)
     */
    public function getAllWithDetails(): array
    {
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name 
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                ORDER BY a.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
