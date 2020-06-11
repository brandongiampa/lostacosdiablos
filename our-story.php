<?php
  define('CAN_OPEN', true);
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';
  $page_hero_image = "https://i.imgur.com/z2UVC25.jpg";
  $page_header = "Our Story";
  include_once 'inc/header.php';
  include_once 'database/db.php';
  $conn = Database::connectReadDB();

  switch($document_language){
    case "en":{$language_addon = "english"; break;}
    case "es":{$language_addon = "spanish"; break;}
  }

  $page_title = "Our Story";

  $stmt = $conn->prepare('SELECT title, header_title, html_' . $language_addon . ' FROM ltd_page_content WHERE title = :title LIMIT 1');
  $stmt->bindParam(':title', $page_title , PDO::PARAM_STR);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_OBJ);

  $title = $row->title;
  $header_title = $row->header_title;

  if (isset($row->html_spanish)){
    $page_html = $row->html_spanish;
  }
  else if(isset($row->html_english)){
    $page_html = $row->html_english;
  }
  else {
    $page_html = "There is no page content to display. Please notify the site administrator.";
  }
?>
    <?php echo $page_html;?>
      </div>
    </main>
<?php include_once 'inc/footer.php';?>
