<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  <title>Los Tacos Amigos</title>
</head>
<body>
  <div id="bg"></div>
  <div id="bg-opaque"></div>
  <div id="page">
    <header>
      <div id="branding-mobile">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>">
          <img src="img/logo/logocropped.jpg" alt="Los Tacos Amigos">
        </a>
      </div>
      <div id="menu-expand">
        <i class="fas fa-bars"></i>
      </div>
      <div id="ctas">
        <a href="#" class="btn btn-red">ORDER NOW</a>
      </div>
      <nav id="nav-header-pc" style="visibility: hidden; position: absolute; height: 0;">
        <ul>
          <li>Our Story</li>
          <li>News</li>
          <li>
            <a href="<?php echo $_SERVER['PHP_SELF'];?>">
              <img src="img/logo/logocropped.jpg" alt="">
            </a>
          </li>
          <li>Menu</li>
          <li>Find Us</li>
        </ul>
      </nav>
    </header>
    <nav id="nav-header-mobile">
      <ul>
        <li>Our Story</li>
        <li>News</li>
        <li>Menu</li>
        <li>Find Us</li>
      </ul>
    </nav>
