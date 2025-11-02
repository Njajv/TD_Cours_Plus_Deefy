<?php

require_once __DIR__ . '/vendor/autoload.php';

use IUT\Spotify\CookieProvider;
use IUT\Spotify\dispatch\Dispatcher;


$dispatcher = new Dispatcher();
$dispatcher->run();


/*
const COOKIE_INCREMENTAL = 'incremental';
const COOKIE_PLAYLIST = 'playlist';

$cookieProvider = new CookieProvider();
init($cookieProvider);
$body = getHeaderHtml($cookieProvider);

// if get show a form with name and adress
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $body .= '<form method="POST" action="">
<h1>Add track</h1>
            <label for="playlist">Playlist:</label>
            <select name="playlist" id="playlist">
                <option value="playlist1">Playlist 1</option>
                <option value="playlist2">Playlist 2</option>
                <option value="playlist3">Playlist 3</option>
            </select>
            <br>
            <label for="track">Track:</label>
            <input type="text" id="track" name="track" required>
            <input type="submit"
    // simple validation value="Submit">
          </form>';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist = $_POST['playlist'] ?? '';
    $track = $_POST['track'] ?? '';

    $cookieProvider->createCookie(COOKIE_PLAYLIST, $playlist);

    if (empty($playlist) || empty($track)) {
        $body .= '<p style="color:red;">Please fill in all fields.</p>';
    } else {
        $body .= sprintf('<p style="color:green;">Track "%s" added to playlist "%s".</p>', htmlspecialchars($track), htmlspecialchars($playlist));
    }

    // add a link to go back to the form
    $body .= '<p><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">Add another track</a></p>';
}

// renvoi html avec un sprint qui continuer la response, avec body etc
echo sprintf(
    '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>IUT - spotify</title></head><body>%s</html>',
    $body
);

function init(CookieProvider $cookieProvider): void {
    $incremental = $cookieProvider->getCookie(COOKIE_INCREMENTAL) ? $cookieProvider->getCookie(COOKIE_INCREMENTAL) + 1 : 1;
    $cookieProvider->createCookie(COOKIE_INCREMENTAL, $incremental);
}

function getHeaderHtml(CookieProvider $cookieProvider): string {
    $playlist = $cookieProvider->getCookie(COOKIE_PLAYLIST) ?: '';
    $incremental = $cookieProvider->getCookie(COOKIE_INCREMENTAL);
    $playlistHTml = $playlist ? '<h1>My playlist is: ' . htmlspecialchars($playlist).'</h1>' : '<h1>No playlist selected.</h1>';
    $incrementalHtml = $incremental ? '<p>You have visited this page ' . htmlspecialchars($incremental) . ' times.</p>' : '';

    return $playlistHTml . $incrementalHtml;
}
*/