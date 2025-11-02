<?php
namespace IUT\Spotify\action;

use IUT\Spotify\Entity\Playlist;
use IUT\Spotify\Entity\PodcastTrack;

class AddPodcastTrackAction extends Action {

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $artist = filter_var($_POST['artist'], FILTER_SANITIZE_STRING);

            if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(substr($_FILES['userfile']['name'], -4));
                $type = $_FILES['userfile']['type'];

                if ($ext === '.mp3' && $type === 'audio/mpeg') {
                    $uploadDir = 'audio/';
                    $randomName = uniqid('track_', true) . '.mp3';
                    $uploadFile = $uploadDir . basename($randomName);
                    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile);
                    $filepath = $uploadFile;
                } else {
                    return "<p>Erreur : seul le format MP3 est accepté.</p>";
                }
            } else {
                $filepath = '';
            }

            $track = new PodcastTrack($title, $artist, $filepath);

            if (isset($_SESSION['playlist'])) {
                $playlist = $_SESSION['playlist'];
                $playlist->addTrack($track);
                $_SESSION['playlist'] = $playlist;
                $renderer = new AudioListRenderer($playlist);
                $html = $renderer->render();
                $html .= '<p><a href="?action=add-track">Ajouter encore une piste</a></p>';
                return $html;
            } else {
                return "<p>Aucune playlist en cours. <a href='?action=add-playlist'>Créer une playlist</a></p>";
            }

        } else {
            $form = <<<HTML
                <form method="post" action="?action=add-track" enctype="multipart/form-data">
                    <label>Titre :</label>
                    <input type="text" name="title" required><br>
                    <label>Artiste :</label>
                    <input type="text" name="artist" required><br>
                    <label>Fichier audio (.mp3) :</label>
                    <input type="file" name="userfile" accept="audio/mpeg"><br>
                    <button type="submit">Ajouter</button>
                </form>
            HTML;
            return $form;
        }
    }
}