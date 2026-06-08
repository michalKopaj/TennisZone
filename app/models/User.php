<?php
require_once __DIR__ . '/../core/Database.php';

class User {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function findByLogin($login) {
        $sql = "SELECT * FROM users WHERE username = :login OR email = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['login' => $login]);
        return $stmt->fetch();
    }

    public function login($login, $password) {
        $user = $this->findByLogin($login);

        if ($user && password_verify($password, $user->password_hash)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            return true;
        }

        return false;
    }

    public function logout() {
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

 public function existsByUsername($username) {
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch() !== false;
    }

    public function existsByEmail($email) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() !== false;
    }

    public function register($username, $email, $password) {
        $sql = "INSERT INTO users (username, email, password_hash, role)
                VALUES (:username, :email, :password_hash, 'user')";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'username'      => $username,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        return $this->db->lastInsertId();
    }

}