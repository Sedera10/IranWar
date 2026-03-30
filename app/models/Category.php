<?php
/**
 * Modèle Category - Gestion des catégories
 * Adapté à la structure BDD simplifiée (libelle au lieu de name, pas de slug/status)
 */
class Category extends Model
{
    protected string $table = 'categories';
    
    /**
     * Récupérer toutes les catégories
     */
    public function getActive(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY libelle ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer une catégorie par son ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Récupérer les catégories avec le nombre d'articles
     */
    public function getWithArticleCount(): array
    {
        $sql = "SELECT c.*, COUNT(a.id) as article_count 
                FROM {$this->table} c 
                LEFT JOIN articles a ON c.id = a.category_id AND a.published_at IS NOT NULL
                GROUP BY c.id 
                ORDER BY c.libelle ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
