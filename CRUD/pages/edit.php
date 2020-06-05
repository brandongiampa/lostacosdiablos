<?php
  $errorMessage = "";

  include_once '../../database/db.php';

  if(isset($_POST['edit-page'])){
    try{
      $conn = Database::connectWriteDB();
      $stmt = $conn->prepare('UPDATE ltd_page_content SET title = :title, header_title = :header_title, html_english = :html_english, html_spanish = :html_spanish, html_korean = :html_korean WHERE id = :id');
      $stmt->bindParam(':title', $_POST['page-title'], PDO::PARAM_STR);
      $stmt->bindParam(':header_title', $_POST['header-title'], PDO::PARAM_STR);
      $stmt->bindParam(':html_english', $_POST['html-english'], PDO::PARAM_STR);
      $stmt->bindParam(':html_spanish', $_POST['html-spanish'], PDO::PARAM_STR);
      $stmt->bindParam(':html_korean', $_POST['html-korean'], PDO::PARAM_STR);
      $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
      $stmt->execute();
      echo '<div class="container"><div class="alert alert-success">Your entry has been successfully edited.</div></div>';
    }
    catch(PDOException $ex){
      echo '<div class="container"><div class="alert alert-warning">There was an error connecting to the database: ' . $ex->getMessage() . '</div></div>';
    }
  }
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <title>Edit Page</title>
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
    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id;?>" method="post">
      <a href="index.php" class="btn btn-primary">&larr;Back to Index</a>
      <h1 class="text-center">Edit Page</h1>
      <p class="text-right"><a href="view.php?id=<?php echo $id;?>" class="btn btn-info">View Entry</a></p>
      <p><b>ID:</b> <?php echo $id;?></p>
      <input type="hidden" value="<?php echo $id;?>" name="id">
      <label for="page-title"><b>Title</b></label><span class="text-danger"><i> *Required</i></span><br>
      <input type="text" class="form-control" id="page-title" name="page-title" value="<?php echo $title;?>" required><br>
      <label for="header-title"><b>Header Title</b></label><br>
      <input type="text" class="form-control" id="header-title" name="header-title" value="<?php echo $header_title;?>"><br>
      <label for="html-english"><b>English HTML</b></label><span class="text-danger"><i> *Required</i></span><br>
      <textarea name="html-english"class="form-control"id="html-english"cols="30"rows="20"required><?php echo $html_english;?></textarea><br>
      <label for="html-spanish"><b>Spanish HTML</b></label><br>
      <textarea name="html-spanish"class="form-control"id="html-spanish"cols="30"rows="20"><?php echo $html_spanish;?></textarea><br>
      <label for="html-korean"><b>Korean HTML</b></label><br>
      <textarea name="html-korean"class="form-control"id="html-korean"cols="30"rows="20"><?php echo $html_korean;?></textarea><br>
      <input type="submit" class="btn btn-info" value="Submit Edit" name="edit-page" id="edit-page">
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
