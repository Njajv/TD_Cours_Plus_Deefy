<?php
namespace IUT\Spotify\action;

use IUT\Spotify\Entity\Playlist;

class AddPlaylistAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = filter_var($_POST['playlist_name'], FILTER_SANITIZE_STRING);
            $playlist = new Playlist($nom);
            $_SESSION['playlist'] = $playlist;
            $renderer = new AudioListRenderer($playlist);
            $html = $renderer->render();
            $html .= '<p><a href="?action=add-track">Ajouter une piste</a></p>';
            return $html;
        } else {
            $form = <<<HTML
                <form method="post" action="?action=add-playlist">
                    <label>Nom de la playlist :</label>
                    <input type="text" name="playlist_name" required>
                    <button type="submit">Créer</button>
                </form>
            HTML;
            return $form;
        }
    }


}