<?php

$api_key = 'AIzaSyBoRC0PflWog6Tez0enyx3aK0rkJ2D8FT4';
$playlist_id = 'PLHlVVKveSoo3O2GuygtZfNv7AmQL9YWgN';

// Faz uma solicitação para obter todos os vídeos da playlist
$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId={$playlist_id}&maxResults=50&key={$api_key}";
$response = file_get_contents($url);
$data = json_decode($response, true);

// Obtém a lista de vídeos da resposta JSON
$videos = $data['items'];

// Classifica os vídeos por data (do mais recente para o mais antigo)
usort($videos, function($a, $b) {
    $date_a = strtotime($a['snippet']['publishedAt']);
    $date_b = strtotime($b['snippet']['publishedAt']);
    return $date_b - $date_a;
});

// Cria um array para armazenar as informações dos vídeos ordenados
$videos_ordenados = array();
foreach ($videos as $video) {
    $video_info = array(
        'videoId' => $video['snippet']['resourceId']['videoId'],
        'title' => $video['snippet']['title'],
        'description' => $video['snippet']['description'],
        'publishedAt' => $video['snippet']['publishedAt']
    );
    $videos_ordenados[] = $video_info;
}

// Retorna o JSON com as informações dos vídeos ordenados
$json = json_encode($videos_ordenados);

echo $json;
?>