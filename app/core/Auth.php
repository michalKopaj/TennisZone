<?php

namespace App\Core;

class Auth {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login($login, $password) {
        $sql = "SELECT * FROM users WHERE username = :login OR email = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->password_hash)) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role']     = $user->role;
            return true;
        }

        return false;
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public static function check() {
        if (!self::isLoggedIn()) {
            $redirect = new Redirect('login.php');
            $redirect->redirect();
        }
    }

    public static function checkAdmin() {
        self::check();
        if (!self::isAdmin()) {
            $redirect = new Redirect('home.php');
            $redirect->redirect();
        }
    }
}
