<?php

namespace IUT\Spotify\Action;

class DisplayPlaylistAction
{
    public function execute(): string
    {
        session_start();
        $playlist = $_SESSION['playlist'];
        $html = "";

        foreach ($playlist['tracks'] as $piste){
            $html .= "Titre : " + $piste["title"] + " Auteur : " + $piste["auteur"];
        }

        return $html;

    }
}