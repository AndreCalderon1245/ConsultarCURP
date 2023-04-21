<?php 
session_start();
$url_base="http://localhost/apps/webtest/";
?>
<!doctype html>
<html lang="en">
<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="css/styles.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- place navbar here -->
    <header>
  <nav class="nav-bg1 navbar navbar-expand-md">
    <div class="container-fluid">
      <img href="index.php" src="https://framework-gb.cdn.gob.mx/landing/img/logoheader.svg" width="128" height="48" alt="PÃ¡gina de inicio, Gobierno de MÃ©xico">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="text-white nav-link" href="#" style="margin-right: 10px;">Tramites</a>
          </li>
          <li class="nav-item">
            <a class="text-white nav-link" href="#" style="margin-right: 10px;">Gobierno</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <nav class="nav-bg2 navbar navbar-expand-md">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarNavDark">
      <a href="index.php" class="text-white navbar-brand" href="/">RENAPO</a>
      </div>
    </div>
  </nav>
</header>


  <main class="container">