<?php

namespace IUT\Spotify\action;

use IUT\Spotify\Auth\AuthnException;
use IUT\Spotify\Auth\AuthnProvider;

class AddUserAction extends Action {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo '
                <form method="POST" action="?action=add-user">
                    <label>Email : <input type="email" name="email" required></label><br>
                    <label>Mot de passe : <input type="password" name="passwd" required></label><br>
                    <label>Confirmez le mot de passe : <input type="password" name="passwd_confirm" required></label><br>
                    <button type="submit">Créer un compte</button>
                </form>
            ';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                AuthnProvider::register($_POST['email'], $_POST['passwd'], $_POST['passwd_confirm']);
                echo "<p>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>";
            } catch (AuthnException $e) {
                echo "<p>Erreur : {$e->getMessage()}</p>";
            }
        }
    }
}
