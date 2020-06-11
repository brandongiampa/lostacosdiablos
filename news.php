<?php
  define('CAN_OPEN', true);
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';
  $page_hero_image = "https://i.imgur.com/g7wm2Lp.jpg";
  $page_header = "News";
  include_once 'inc/header.php';
  include_once 'database/db.php';

  //sql query
  $db = Database::connectReadDB();
  $language = $document_language === "es" ? "Spanish" : "English";
  $upperLimit = 12;
  $query = "SELECT * FROM `ltd_news_blogs` WHERE `language` = :language ORDER BY timestamp DESC LIMIT :upperLimit";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':upperLimit', $upperLimit, PDO::PARAM_INT);
  $stmt->bindParam(':language', $language, PDO::PARAM_STR);
  $stmt->execute();
  ?>
  </div>
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
</main>
<?php include_once 'inc/footer.php';?>
