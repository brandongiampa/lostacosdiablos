<?php
  include_once 'database/db.php';
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';
  if(isset($_GET['title'])){
    try{
      $db = Database::connectReadDB();
      $query = 'SELECT * FROM ltd_news_blogs WHERE slug = :slug LIMIT 1';
      $stmt = $db->prepare($query);
      $stmt->bindParam(':slug', $_GET['title']);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_OBJ);

      $id = $row->id;
      $date_unformatted = date_create($row->timestamp);
      $date = date_format($date_unformatted, 'm-d-Y');
      $title = $row->title;
      $html = $row->html;
      $page_hero_image = $row->img_path;
    }
    catch(PDOException $ex){
      $id = 0;
      $page_hero_image = "img/large/chihuahua-1850477_1920.jpg";
      $date = "";
      $title = '?';
      $html = "There has been a database error. Please try reloading the page.";
    }
  }
  else{
    $id = 0;
    $page_hero_image = "img/large/chihuahua-1850477_1920.jpg";
    $title = "Uh-oh!";
    $html = "It looks like the article you are looking for isn't here.";
    $date = "";
  }
  $page_header = $title;
  include_once 'inc/header.php';?>
  <div class="news-item-page">
    <div class="news-item-header news-item-page-subheader">
      <div class="news-item-date"><?php echo $date;?></div>
    </div>
    <div class="news-item-page-body">
      <div class="news-item-text">
        <?php echo $html;?>
      </div>
    </div>
  </div>
  <?php
  if($id > 0){
    $language = $document_language === "en" ? "English" : "Spanish";
    //get previous article
    $db = Database::connectReadDB();
    $query = 'SELECT slug FROM ltd_news_blogs WHERE id < :id AND language = :language ORDER BY id DESC LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':language', $language, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $has_previous = true;
      $prev_link = $document_root_path . 'news-item/' . $row->slug;
    }
    else{
      $has_previous = false;
      $prev_link = "";
    }
    //get next article
    $db = Database::connectReadDB();
    $query = 'SELECT slug FROM ltd_news_blogs WHERE id > :id AND language = :language LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':language', $language, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $has_next = true;
      $next_link = $document_root_path . 'news-item/' . $row->slug;
    }
    else{
      $has_next = false;
      $next_link = "";
    }
  }
  else{
    $has_previous = false;
    $has_next = false;
    $prev_link = "";
    $next_link = "";
  }
  ?>
  <div class="news-page-footer">
    <a href="<?php echo $prev_link;?>" onclick="<?php if(!$has_previous){echo 'return false';}?>" class="link-prev<?php if (!$has_previous){echo ' disabled';}?>"><span class="chevron">&lsaquo; </span>Prev</a>
    <a href="http://192.168.1.232:8080/lostacosamigos/news" class="btn btn-red">Back to News</a>
    <a href="<?php echo $next_link;?>" onclick="<?php if(!$has_next){echo 'return false';}?>" class="link-next<?php if (!$has_next){echo ' disabled';}?>">Next <span class="chevron">&rsaquo;</span></a>
  </div>
</main>
<?php include_once 'inc/footer.php';?>
