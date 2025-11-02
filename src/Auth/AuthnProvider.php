<?php

namespace IUT\Spotify\Auth;

use IUT\Spotify\Repository\DeefyRepository;
use PDO;
use Exception;

class AuthnException extends Exception {}

class AuthnProvider {

    public static function signin(string $email, string $passwd): array {
        $db = DeefyRepository::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new AuthnException("Utilisateur non trouvé.");
        }

        if (!password_verify($passwd, $user['passwd'])) {
            throw new AuthnException("Mot de passe incorrect.");
        }

        return $user;
    }

    public static function register(string $email, string $passwd, string $passwd_confirm): void {
        $db = DeefyRepository::getInstance()->getConnection();


        if ($passwd !== $passwd_confirm) {
            throw new AuthnException("Les mots de passe ne correspondent pas.");
        }

        if (strlen($passwd) < 10) {
            throw new AuthnException("Le mot de passe doit contenir au moins 10 caractères.");
        }


        $stmt = $db->prepare("SELECT email FROM user WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            throw new AuthnException("Un compte existe déjà avec cet email.");
        }


        $hash = password_hash($passwd, PASSWORD_BCRYPT);


        $stmt = $db->prepare("INSERT INTO user (email, password, role) VALUES (:email, :password, 1)");
        $stmt->execute([
            ':email' => $email,
            ':passwd' => $hash
        ]);
    }
}