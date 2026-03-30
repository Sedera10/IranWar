<?php
/**
 * Modèle User - Gestion des utilisateurs/administrateurs
 */
class User extends Model
{
    protected string $table = 'users';
    
    /**
     * Trouver un utilisateur par email
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Authentifier un utilisateur
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        
        return null;
    }
    
    /**
     * Créer un utilisateur avec mot de passe hashé
     */
    public function createUser(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->create($data);
    }
    
    /**
     * Vérifier si un utilisateur est connecté
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Récupérer l'utilisateur connecté
     */
    public static function current(): ?array
    {
        if (self::isLoggedIn()) {
            return $_SESSION['user'] ?? null;
        }
        return null;
    }
}
