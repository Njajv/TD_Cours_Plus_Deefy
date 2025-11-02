<?php
namespace IUT\Spotify\Repository;

use IUT\Spotify\Entity\PodcastTrack;
use PDO;

class DeefyRepository {

    private static ?DeefyRepository $instance = null;
    private static array $config;
    private PDO $pdo;

    private function __construct() {
        $this->pdo = new PDO('mysql:host=localhost; dbname=Deefy; charset=utf8', 'root', '');
    }

    public static function setConfig(string $file): void {
        self::$config = parse_ini_file($file);
    }

    public static function getInstance(): DeefyRepository {
        if (self::$instance === null) {
            self::$instance = new DeefyRepository();
        }
        return self::$instance;
    }


    public function getConnection(): PDO {
        return $this->pdo;
    }


    public function findAllPlaylists(): array {
        $sql = "SELECT * FROM playlist";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();

        $playlists = [];
        foreach ($rows as $row) {
            $p = new Playlist($row['nom']);
            $p->id = $row['id'];
            $playlists[] = $p;
        }
        return $playlists;
    }

    public function findPlaylistById(int $id): array {
        $sql = "SELECT * FROM playlist WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $playlistData = $stmt->fetch(PDO::FETCH_ASSOC);

        $playlist = new Playlist(
            $playlistData['nom']
        );
        return $playlist;
    }

    public function savePlaylist(Playlist $playlist): void {
        $sql = "INSERT INTO playlist (nom) VALUES (:nom)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nom' => $playlist->name]);
        $playlist->id = $this->pdo->lastInsertId();
    }

    public function saveTrack(PodcastTrack $track): void {
        $sql = "INSERT INTO track (titre, artiste_album, duration) VALUES (:titre, :artiste_album, :duration)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $track->title,
            ':artiste_album' => $track->author,
            ':duration' => $track->duration
        ]);
        $track->id = $this->pdo->lastInsertId();
    }


    public function addTrackToPlaylist(int $trackId, int $playlistId): void {
        $sql = "INSERT INTO playlist2track (id_pl, id_track) VALUES (:id_pl, :id_track)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_pl' => $playlistId,
            ':id_track' => $trackId
        ]);
    }
}
