<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  <title>Los Tacos Diablos</title>
  <link rel="icon" href="img/original/icon.jpg">
</head>
<body>
  <div id="bg"></div>
  <div id="bg-opaque"></div>
  <div id="page">
    <header>
      <div id="branding-mobile">
        <a href="index.php">
          <img src="img/logo/newlogocropped.jpg" alt="Los Tacos Diablos">
        </a>
      </div>
      <div id="lang-expand">
        <i class="fas fa-globe"></i>
        <select name="language" id="language">
          <option value="English">EN</option>
          <option value="Spanish">ES</option>
          <option value="Korean">KO</option>
        </select>
      </div>
      <div id="menu-expand">
        <i class="fas fa-bars"></i>
      </div>
      <nav id="nav-header-pc">
        <ul class="nav-header-ul-pc" id="nav-header-pc-left">
          <li>
            <a href="our-story.php">Our Story</a>
          </li>
          <li>
            <a href="news.php">News</a>
          </li>
        </ul>
        <div id="branding-pc">
          <a href="index.php">
            <img src="img/logo/newlogocropped.jpg" alt="index" style="height:120px; width:auto;">
          </a>
        </div>
        <ul class="nav-header-ul-pc" id="nav-header-pc-right">
          <li>
            <a href="menu.php">Menu</a>
          </li>
          <li>
            <a href="find-us.php">Find Us</a>
          </li>
        </ul>
      </nav>
    </header>
    <nav id="nav-header-mobile">
      <ul>
        <li>
          <a href="our-story.php">Our Story</a>
        </li>
        <li>
          <a href="news.php">News</a>
        </li>
        <li>
          <a href="menu.php">Menu</a>
        </li>
        <li>
          <a href="find-us.php">Find Us</a>
        </li>
      </ul>
    </nav>
    <main>
      <div class="blackout"></div>
      <div id="hero-image">
        <img src="img/large/<?php echo $page_hero_image;?>.jpg" alt="">
      </div>
      <div class="main-text">
        <div class="page-header">
          <h1><?php echo $page_header;?></h1>
        </div>
