<?php

namespace IUT\Spotify;

use IUT\Spotify\action\AddUserAction;
use IUT\Spotify\action\DefaultAction;
use IUT\Spotify\action\AddPlaylistAction;
use IUT\Spotify\action\AddPodcastTrackAction;
use IUT\Spotify\action\DisplayPlaylistAction;
use IUT\Spotify\auth\AuthnProvider;
use IUT\Spotify\auth\AuthnException;

class Dispatcher {

    private string $action;

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void {

        switch ($this->action) {
            case 'display-playlist':
                $this->displayPlaylist();
                break;

            case 'signin':
                $this->signin();
                break;

            case 'playlist':
                $act = new DisplayPlaylistAction();
                break;

            case 'add-playlist':
                $act = new AddPlaylistAction();
                break;

            case 'add-track':
                $act = new AddPodcastTrackAction();
                break;

            case 'add-user':
                $act = new AddUserAction();
                break;
                
            default:
                $act = new DefaultAction();
                break;
        }

        $html = $act->execute();

        $this->renderPage($html);
    }

    private function renderPage(string $html): void {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Spotify/Deefy</title>

        </head>
        <body>
            <nav>
                <a href="?action=default">Accueil</a> |
                <a href="?action=add-playlist">Créer playlist</a> |
                <a href="?action=add-track">Ajouter une piste</a> |
                <a href="?action=playlist">Afficher playlist</a>
            </nav>
            <hr>
            {$html}
        </body>
        </html>
        HTML;
    }

    private function signin(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo '
                <form method="POST" action="?action=signin">
                    <label>Email : <input type="email" name="email" required></label><br>
                    <label>Mot de passe : <input type="password" name="passwd" required></label><br>
                    <button type="submit">Se connecter</button>
                </form>
            ';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = AuthnProvider::signin($_POST['email'], $_POST['passwd']);
                $_SESSION['user'] = $user;
                echo "<p>Connexion réussie. Bienvenue, {$user->getUsername()} !</p>";
            } catch (AuthnException $e) {
                echo "<p>Erreur : {$e->getMessage()}</p>";
            }
        }
    }


    private function displayPlaylist(): void {
        $id = $_GET['id'];

        $repo = new DeefyRepository($this->pdo);
        $playlist = $repo->findPlaylistById($id);

        if (!$playlist) {
            echo "Playlist non trouvée.";
            return;
        }

        $renderer = new PlaylistRenderer();
        echo $renderer->render($playlist);
    }

}