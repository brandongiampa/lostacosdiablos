<?php
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';

  include_once 'database/db.php';
  $db = Database::connectReadDB();

  switch($document_language){
    case "en":{$language_addon = "english"; break;}
    case "es":{$language_addon = "spanish"; break;}
  }

  $page_title = "Welcome To Los Tacos Diablos!";

  $stmt = $db->prepare('SELECT title, header_title, html_' . $language_addon . ' FROM ltd_page_content WHERE title = :title LIMIT 1');
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

<?php

  $page_hero_image = "img/large/tacos2-blur.jpg";
  $page_header = $title;
  include_once 'inc/header.php';?>
    <?php echo $page_html;?>
  </div>
  <h1>News</h1>
  <?php
  $upperLimit = 3;
  $language = $document_language === "es" ? "Spanish" : "English";
  $query = "SELECT * FROM `ltd_news_blogs` WHERE `language` = :language ORDER BY timestamp DESC LIMIT :upperLimit";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':upperLimit', $upperLimit, PDO::PARAM_INT);
  $stmt->bindParam(':language', $language, PDO::PARAM_STR);
  $stmt->execute();
  ?>
  <div class="news-items">
    <?php
    if($stmt->rowCount()<1){
      echo "There are no news items to display at this time.";
    }
    else {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        $title = $row['title'];
        $slug = $row['slug'];
        $date_unformatted = date_create(substr($row['timestamp'], 0, 10));
        $date = date_format($date_unformatted, "n/j/Y");

        $imgPath = $row['img_path'];

        $excerptLength = 60;
        $excerpt = strlen(strip_tags($row['html'])) < $excerptLength ? strip_tags($row['html']) : substr(strip_tags($row['html']), 0, $excerptLength-3) . "...";
      ?>
        <div class="news-item">
          <div class="news-item-header">
            <h2><?php echo $title?></h2>
            <div class="news-item-date"><?php echo $date;?></div>
          </div>
          <div class="news-item-body">
            <div class="news-item-img">
              <a href="<?php echo $document_root_path;?>news-item/<?php echo $slug;?>">
                <img src="<?php echo $imgPath;?>" alt="IMAGE NOT FOUND">
              </a>
            </div>
            <div class="news-item-text">
              <?php echo $excerpt;?>
              <a class="link" href="<?php echo $document_root_path;?>news-item/<?php echo $slug;?>">READ MORE</a>
            </div>
          </div>
        </div>
      <?php endwhile;
    }
    ?>
  </div>
  <a href="<?php echo $document_root_path . 'news/';?>" class="btn">See All News</a>
</main>
<?php include_once 'inc/footer.php';?>
