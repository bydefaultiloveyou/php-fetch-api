<?php

class fetch
{
  protected $uri;
  public function __construct($uri)
  {
    $this->uri = $uri;
  }

  private function exec()
  {
    $json = file_get_contents($this->uri);
    $response = json_decode($json, true);
    return [$response,  $http_response_header[0]];
  }

  public function get()
  {
    return $this->exec()[0]["data"];
  }

  public function statusCode()
  {
    return $this->exec()[1];
  }
}

$imgRandom = [
  "https://freeaddon.com/wp-content/uploads/2019/01/anime-meme-28.jpg",
  "https://media.tenor.com/o3SXzAksOokAAAAC/anime-meme.gif",
  "https://media.tenor.com/aF0ipAtOk9cAAAAS/spy-x-family-anya.gif",
  "https://64.media.tumblr.com/24291384b31c1ac161abab1379af2320/9f405815309c8099-3e/s540x810/2062bd878f79111a57625d42588f0086dbe17bfa.gif",
  "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7oL4Z5cYuMel-f3IN-CRLEem3t7uJQTeJQ&usqp=CAU"
];

// get id
$id = $_GET["id"] ?? 1;

// fetch data
$anime = new fetch("https://api.jikan.moe/v4/anime/$id");

// cek status code
$success;
$anime->statusCode() === "HTTP/1.1 404 Not Found" ? $success = true : $success = false;

// get data jika oke
$data = $anime->get();
?>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GET ANIME RANDOM - Jikan moe </title>
  <link rel="stylesheet" href="./app.css" type="text/css">
</head>

<body>
  <?php if ($success) : ?>
    <p class="message_alert">Resources not found</p>
  <?php endif ?>
  <main class="wrapper">
    <header class="wrapper_header">
      <figure>
        <img class="cover_image" src="<?= $data["images"]["jpg"]["large_image_url"] ?? $imgRandom[rand(0, 4)] ?>" alt="<?= $data["title"] ?? "Not Found" ?>" width="200" height="200">
        <figcaption>
          <p class="title"><?= $data["title"] ?? "Nippon Banzai" ?></p>
          <p class="romanji"><?= $data["title_japanese"] ?? "日本万歳" ?></p>
        </figcaption>
      </figure>
    </header>
    <div class="genres">
      <?php foreach ($data["genres"] as $key => $value) : ?>
        <p class="genres_item"><?= $value["name"] ?></p>
      <?php endforeach ?>
    </div>
    <figcaption class="sinopsis">
      <p>
        Sinopsis
      </p>
      <p>
        <?= $data["synopsis"] ?>
      </p>
    </figcaption>
    <section class="information_anime">
      <table>
        <tr>
          <td class="heading_table" colspan="2">INFORMATION ANIME</td>
        </tr>
        <tr>
          <td class="column">Type</td>
          <td><?= $data["type"] ?></td>
        </tr>
        <tr>
          <td class="column">Source</td>
          <td><?= $data["source"] ?></td>
        </tr>
        <tr>
          <td class="column">Status</td>
          <td><?= $data["status"] ?></td>
        </tr>
        <tr>
          <td class="column">Aired</td>
          <td><?= $data["aired"]["string"] ?></td>
        </tr>
        <tr>
          <td class="column">Ranting</td>
          <td><?= $data["rating"] ?></td>
        </tr>
        <tr>
          <td class="column">Year</td>
          <td><?= $data["year"] ?></td>
        </tr>
        <tr>
          <td class="column">Type</td>
          <td><?= $data["type"] ?></td>
        </tr>
      </table>
    </section>
    <!-- trailer section -->
    <figure class="trailer">
      <p>Trailer</p>
      <iframe width="350" height="230" src="<?= $data["trailer"]["embed_url"] ?>" title="<?= $data["title"] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </figure>
    <!-- end trailer -->
  </main>
</body>

</html>
