<?php
  $errorMessage = "";

  include_once '../../database/db.php';

  try{
    $conn = Database::connectReadDB();
    $stmt = $conn->prepare("SELECT * FROM ltd_page_content WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();

    $rowCount = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    if($rowCount < 1){
      echo '<div class="container"><div class="alert alert-danger">Error: No item exists under that id.</div></div>';
    }
  }
  catch(PDOException $ex){
    $hadDatabaseError = true;
    $errorMessage = "There has been a database error: " . $ex->getMessage();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
  img{
    max-width:100%;
  }
    @media only screen and (min-width:940px){
      img{
        max-width:50%;
      }
    }
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <title>View Page Info</title>
</head>
<body>
  <div class="container p-4">
    <?php
      $id = $row->id;
      $title = isset($row->title) ? trim($row->title) : "";
      $header_title = isset($row->header_title) ? trim($row->header_title) : "";
      $html_english = isset($row->html_english) ? trim($row->html_english) : "";
      $html_spanish = isset($row->html_spanish) ? trim($row->html_spanish) : "";
      $html_korean = isset($row->html_korean) ? trim($row->html_korean) : "";
    ?>
    <a href="index.php" class="btn btn-primary">&larr;Back to Index</a>
    <h1 class="text-center">View Page Info</h1>
    <p><b>ID:</b> <?php echo $id;?></p>
    <label for="page-title"><b>Title</b></label><br>
    <div id="page-title"><?php echo $title;?></div><br>
    <label for="header-title"><b>Header Title</b></label><br>
    <div id="header-title"><?php echo $header_title;?>"</div><br>
    <label for="html-english"><b>English Text</b></label><br>
    <div id="html-english"><?php echo $html_english;?></div><br>
    <label for="html-spanish"><b>Spanish Text</b></label><br>
    <div id="html-spanish"><?php echo $html_spanish;?></div><br>
    <label for="html-korean"><b>Korean Text</b></label><br>
    <div id="html-korean"><?php echo $html_korean;?></div><br>
    <a href="edit.php?id=<?php echo $id;?>" class="btn btn-info">Edit Entry</a>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
