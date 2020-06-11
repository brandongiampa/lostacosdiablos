<?php include_once 'database/globals.php';?>
<?php
  //check constant
  if (!defined('CAN_OPEN')){
    header('location: ' . $document_root_path);
  }
?>

<!DOCTYPE html>
<html lang="<?php echo $document_language;?>">
<head>
  <meta charset="<?php echo $document_language === "ko" ? "iso-8859-1" : "UTF-8";?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?php echo $document_root_path;?>css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  <title><?php echo isset($header_title) ? $header_title : "Los Tacos Diablos";?></title>
  <link rel="icon" href="<?php echo $document_root_path;?>img/original/icon.jpg">
</head>
<body>
  <div id="cookie-notice">
    <h2>Oye!</h2>
    <p>This site uses cookies for a better user experience. We do not sell your information. By continuing to use this site, you are consenting to this.</p>
    <button class="btn btn-red">OK</button>
  </div>
  <div id="bg"></div>
  <div id="bg-opaque"></div>
  <div id="page">
    <header>
      <div id="branding-mobile">
        <a href="<?php echo $document_root_path;?>">
          <img src="<?php echo $document_root_path;?>img/logo/newlogocropped.jpg" alt="Los Tacos Diablos">
        </a>
      </div>
      <div id="lang-expand">
        <div id="lang-expand-visible">
          <i class="fas fa-globe"></i>
          <span id="document-language"><?php echo strtoupper($document_language);?></span>
          <span id="language-dropdown-caret">&#9660;</span>
        </div>
        <div id="language-dropdown-menu">
          <ul>
            <li data-selectedlanguage="en">EN</li>
            <li data-selectedlanguage="es">ES</li>
          </ul>
        </div>
      </div>
      <div id="menu-expand">
        <i class="fas fa-bars"></i>
      </div>
      <nav id="nav-header-pc">
        <ul class="nav-header-ul-pc" id="nav-header-pc-left">
          <li>
            <a href="<?php echo $document_root_path;?>our-story">Our Story</a>
          </li>
          <li>
            <a href="<?php echo $document_root_path;?>news">News</a>
          </li>
        </ul>
        <div id="branding-pc">
          <a href="<?php echo $document_root_path;?>">
            <img src="<?php echo $document_root_path;?>img/logo/newlogocropped.jpg" alt="index" style="height:120px; width:auto;">
          </a>
        </div>
        <ul class="nav-header-ul-pc" id="nav-header-pc-right">
          <li>
            <a href="<?php echo $document_root_path;?>menu.php">Menu</a>
          </li>
          <li>
            <a href="<?php echo $document_root_path;?>find-us.php">Find Us</a>
          </li>
        </ul>
      </nav>
    </header>
    <nav id="nav-header-mobile">
      <ul>
        <li>
          <a href="<?php echo $document_root_path;?>">Home</a>
        </li>
        <li>
          <a href="<?php echo $document_root_path;?>our-story">Our Story</a>
        </li>
        <li>
          <a href="<?php echo $document_root_path;?>news">News</a>
        </li>
        <li>
          <a href="<?php echo $document_root_path;?>menu">Menu</a>
        </li>
        <li>
          <a href="<?php echo $document_root_path;?>find-us">Find Us</a>
        </li>
      </ul>
    </nav>
    <main>
      <div class="blackout"></div>
      <div id="hero-image">
        <img src="<?php echo $page_hero_image;?>" alt="">
      </div>
      <div class="main-text">
        <a href="https://postmates.com">
          <div id="call-to-action">
            <!--<i class="fas fa-phone"></i>-->
            <img src="<?php echo $document_root_path;?>img/logo/postmatessmall.png" alt="ORDER">
          </div>
        </a>
        <div class="page-header">
          <h1><?php echo $page_header;?></h1>
        </div>
