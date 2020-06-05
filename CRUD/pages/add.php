<?php
  include_once '../../database/db.php';

  if(isset($_POST['add-page'])){
    $page_title = trim($_POST['page-title']);
    $header_title = trim($_POST['header-title']);
    $html_english = trim($_POST['html-english']);
    $html_spanish = trim($_POST['html-spanish']);
    $html_korean = trim($_POST['html-korean']);

    try{
      $conn = Database::connectWriteDB();
      $stmt = $conn->prepare('INSERT INTO `ltd_page_content` (title, header_title, html_english, html_spanish, html_korean) VALUES (:title, :header_title, :html_english, :html_spanish, :html_korean)');
      $stmt->bindParam(':title', $page_title, PDO::PARAM_STR);
      $stmt->bindParam(':header_title', $header_title, PDO::PARAM_STR);
      $stmt->bindParam(':html_english', $html_english, PDO::PARAM_STR);
      $stmt->bindParam(':html_spanish', $html_spanish, PDO::PARAM_STR);
      $stmt->bindParam(':html_korean', $html_korean, PDO::PARAM_STR);
      $stmt->execute();
      echo '<div class="container"><div class="alert alert-success">You have successfully added an entry!</div></div>';
      unset($_POST);
    }
    catch(PDOException $ex){
      echo '<script>';
      echo 'alert("There was an error connecting to the database. ' . $ex->getMessage() . '")';
      echo '</script>';
    }
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
  <title>Add Page</title>
</head>
<body>
  <div class="container p-4">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <a href="index.php" class="btn btn-primary">&larr;Back to Index</a>
      <h1 class="text-center">Add Page</h1>
      <label for="page-title"><b>Title</b></label><span class="text-danger"><i> *Required</i></span><br>
      <input type="text" class="form-control" id="page-title" name="page-title" required><br>
      <label for="header-title"><b>Header Title</b></label><br>
      <input type="text" class="form-control" id="header-title" name="header-title"><br>
      <label for="html-english"><b>English HTML</b></label><span class="text-danger"><i> *Required</i></span><br>
      <textarea name="html-english"class="form-control"  id="html-english" cols="30" rows="20" required></textarea><br>
      <label for="html-spanish"><b>Spanish HTML</b></label><br>
      <textarea name="html-spanish" class="form-control" id="html-spanish" cols="30" rows="20"></textarea><br>
      <label for="html-korean"><b>Korean HTML</b></label><br>
      <textarea name="html-korean" class="form-control" id="html-korean" cols="30" rows="20"></textarea><br>
      <input type="submit" class="btn btn-success" value="Add Page" name="add-page" id="add-page">
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
