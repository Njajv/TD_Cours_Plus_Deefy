<?php

namespace IUT\Spotify;

use IUT\Spotify\Entity\AudioTrack;
use IUT\Spotify\Entity\Playlist;

class ModifierPiste
{
    public function __construct()
    {
        session_start();

        $_SESSION['playlist'] = new Playlist();
    }

    public function ajouterPiste()
    {
        $_SESSION['playlist'].addTrack(new AudioTrack());
    }

    public function afficherPiste()
    {
        echo $_SESSION['playlist'];
    }
}