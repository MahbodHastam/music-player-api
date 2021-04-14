<?php

use wapmorgan\Mp3Info\Mp3Info;

require_once 'includes/Mp3Info.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');

require_once 'utils.php';

$req = @$_GET['req'] ?? 'songs-list';
$dir = 'public/songs/';
$songs = [];

if (is_dir($dir)) {
  if ($d = opendir($dir)) {
    while (($file = readdir($d)) !== false) {
      if ($file !== '.' && $file !== '..')
        $songs[] = $file;
    }
    closedir($d);
  }
}

if ($req === 'songs-list') {
  $songsArray = [];

  foreach ($songs as $song) {
    $song_path = realpath(__DIR__) . '/' . $dir . $song;
    $Mp3Info = new Mp3Info($song_path, true);
    if ($Mp3Info->isValidAudio($song_path)) {
      $songsArray[] = [
        'url' => get_url($song_path),
        'path' => $song_path,
        'details' => [
          'file_name' => $song,
          'song' => $Mp3Info->tags['song'] ?? null,
          'artist' => $Mp3Info->tags['artist'] ?? null,
          'album_cover' => $Mp3Info->tags['cover'] ?? base_url() . 'public/no-cover.png',
        ],
      ];
    }
  }

  echo json($songsArray);
} else if ($req === 'one-song') {
  $songArray = [];

  foreach ($songs as $song) {
    $song_path = realpath(__DIR__) . '/' . $dir . $song;
    $Mp3Info = new Mp3Info($song_path, true);
    if ($Mp3Info->isValidAudio($song_path)) {
      $songArray = [
        'url' => get_url($song_path),
        'path' => $song_path,
        'details' => [
          'file_name' => $song,
          'song' => $Mp3Info->tags['song'] ?? null,
          'artist' => $Mp3Info->tags['artist'] ?? null,
          'album_cover' => $Mp3Info->tags['cover'] ?? base_url() . 'public/no-cover.png',
        ],
      ];
    }
    break;
  }

  echo json($songArray);
}