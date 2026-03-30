<?php
/**
 * Modèle Article - Gestion des articles d'actualité
 * Adapté à la structure BDD simplifiée (sans colonne status/slug)
 */
class Article extends Model
{
    protected string $table = 'articles';
    
    /**
     * Créer un article et retourner son ID
     */
    public function createAndGetId(array $data): ?int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($data)) {
            return (int) $this->db->lastInsertId();
        }
        return null;
    }
    
    /**
     * Récupérer les articles publiés (avec published_at non null) avec image
     */
    public function getPublished(int $limit = 10): array
    {
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name,
                       m.url as image_url, m.alt_text as image_alt
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN media m ON a.id = m.article_id
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
     * Récupérer les articles par catégorie avec images
     */
    public function getByCategory(int $categoryId, int $limit = 10): array
    {
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name,
                       m.url as image_url, m.alt_text as image_alt
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN media m ON a.id = m.article_id
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
        $sql = "SELECT a.*, c.libelle as category_name, m.url as image_url, m.alt_text as image_alt
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN media m ON a.id = m.article_id
                WHERE (a.title LIKE :keyword OR a.content LIKE :keyword) 
                AND a.published_at IS NOT NULL 
                ORDER BY a.published_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }
    
    /**
     * Pagination des articles publiés avec images
     */
    public function paginatePublished(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        
        // Compter le total d'articles publiés
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE published_at IS NOT NULL";
        $countStmt = $this->db->query($countSql);
        $total = (int) $countStmt->fetch()['total'];
        
        // Récupérer les articles avec images
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name,
                       m.url as image_url, m.alt_text as image_alt
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN media m ON a.id = m.article_id
                WHERE a.published_at IS NOT NULL
                ORDER BY a.published_at DESC 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
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
     * Récupérer tous les articles avec détails (pour admin)
     */
    public function getAllWithDetails(): array
    {
        $sql = "SELECT a.*, c.libelle as category_name, u.name as author_name,
                       s.libelle as status_name
                FROM {$this->table} a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN articles_statuts ast ON a.id = ast.id_2
                LEFT JOIN statuts s ON ast.id_1 = s.id
                ORDER BY a.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer l'image principale d'un article
     */
    public function getMainImage(int $articleId): ?array
    {
        $sql = "SELECT * FROM media WHERE article_id = :article_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
