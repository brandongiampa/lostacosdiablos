<?php
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';
  $page_hero_image = "tacos1";
  $page_header = "We are on Postmates!";
  include_once 'inc/header.php';?>
  <div class="news-item-page">
    <div class="news-item-header news-item-page-subheader">
      <div class="news-item-date">May 31, 2020</div>
    </div>
    <div class="news-item-page-body">
      <div class="news-item-text">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque veritatis adipisci labore natus suscipit? Numquam sint molestias nobis nisi quibusdam accusamus perferendis deleniti rem libero est cum laboriosam harum, modi eaque sit quia, rerum obcaecati molestiae doloribus sed aliquid aliquam! Velit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam dolor totam soluta repellendus sed, deleniti nam delectus accusantium, dolorem voluptas consequatur magni, a molestias praesentium necessitatibus nostrum cum, animi. Necessitatibus veniam, eligendi!</p>
      </div>
    </div>
  </div>
  <div class="news-page-footer">
    <a href="#" class="link-prev disabled"><span class="chevron">&lsaquo; </span>Prev</a>
    <a href="news.php" class="btn btn-red">Back to News</a>
    <a href="news-item.php" class="link-next">Next <span class="chevron">&rsaquo;</span></a>
  </div>
</main>
<?php include_once 'inc/footer.php';?>
