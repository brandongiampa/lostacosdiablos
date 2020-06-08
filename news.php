<?php
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';
  $page_hero_image = "news";
  $page_header = "News";
  include_once 'inc/header.php';
  include_once 'database/db.php';

  //sql query
  $upperLimit = 12;
  $db = Database::connectReadDB();
  $language = $document_language === "es" ? "Spanish" : "English";
  $query = "SELECT * FROM `ltd_news_blogs` WHERE `language` = :language LIMIT :upperLimit";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':upperLimit', $upperLimit, PDO::PARAM_INT);
  $stmt->bindParam(':language', $language, PDO::PARAM_STR);
  $stmt->execute();
  ?>
  </div>
  <div class="news-items">
    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)):?>
    <?php
      $title = $row['title'];
      $titleExplode = explode($title, " ");
      $dashedTitle = "";

      for($i=0;$i<sizeof($titleExplode)-1;$i++){
        $dashedTitle .= $titleExplode[$i];
        $dashedTitle .= '-';
      }
      $dashedTitle .= $titleExplode[sizeof($titleExplode)-1];

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
            <a href="news/<?php echo $dashedTitle;?>">
              <img src="<?php echo $imgPath;?>" alt="IMAGE NOT FOUND">
            </a>
          </div>
          <div class="news-item-text">
            <?php echo $excerpt;?>
            <a class="btn" href="news/<?php echo $dashedTitle;?>">READ MORE</a>
          </div>
        </div>
      </div>
    <?php endwhile;?>
  </div>
</main>
<?php include_once 'inc/footer.php';?>
