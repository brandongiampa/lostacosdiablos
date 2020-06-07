<?php
  include_once '../../inc/globals.php';
  $message = "";
  $title = isset($_POST['title']) ? $_POST['title'] : "";
  $language = isset($_POST['language']) ? $_POST['language'] : "English";
  $html = isset($_POST['html']) ? $_POST['html'] : "";

  include_once '../../database/db.php';

  if(isset($_POST['add-page'])){

    $file = $_FILES['file'];
    $target_directory =  "../../uploads/";
    $target_file = $target_directory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //set absolute path for database
    $absolute_directory = "http://192.168.1.232:8080/lostacosamigos/uploads/";
    $absolute_path = $absolute_directory . basename($_FILES["file"]["name"]);
    //check if is real image or fake
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check===false){
      $uploadOk = 0;
      $message .= '<div class="container">';
        $message .= '<div class="alert alert-danger">';
        $message .= 'The file uploaded is not an image file. Please try again.';
        $message .= '</div>';
      $message .= '</div>';
    }
    if($_FILES["file"]["size"]>1000000){
      $uploadOk = 0;
      $message .= '<div class="container">';
        $message .= '<div class="alert alert-danger">';
        $message .= 'Image file size is too large. Compress it or use something smaller, you moron.';
        $message .= '</div>';
      $message .= '</div>';
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg"){
      $uploadOk = 0;
      $message .= '<div class="container">';
        $message .= '<div class="alert alert-danger">';
        $message .= 'Only files of type "jpg", "jpeg", "gif" and "png" are valid for upload.';
        $message .= '</div>';
      $message .= '</div>';
    }
    if($uploadOk===1){
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        try{
          $conn = Database::connectWriteDB();
          $stmt = $conn->prepare('INSERT INTO ltd_news_blogs (title, img_path, language, html, timestamp) VALUES (:title, :img_path, :language, :html, NOW() )');
          $stmt->bindParam(':title', $title, PDO::PARAM_STR);
          $stmt->bindParam(':img_path', $absolute_path, PDO::PARAM_STR);
          $stmt->bindParam(':language', $language, PDO::PARAM_STR);
          $stmt->bindParam(':html', $html, PDO::PARAM_STR);
          $stmt->execute();
          $message .= '<div class="container"><div class="alert alert-success">Your entry has been successfully added.</div></div>';
        }
        catch(PDOException $ex){
          $uploadOk = 0;
          $message .= '<div class="container"><div class="alert alert-warning">There was an error connecting to the database. Please try again. <br>' . $ex->getMessage() . '</div></div>';
        }
      }
      else {
        $uploadOk = 0;
        $message .= '<div class="container">';
          $message .= '<div class="alert alert-danger">';
          $message .= 'There was an error uploading your file. Please try again.';
          $message .= '</div>';
        $message .= '</div>';
      }
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
  <title>Add News Blog</title>
</head>
<body>
  <div class="container p-4">
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
      <a href="index.php" class="btn btn-primary">&larr;Back to Index</a>
      <h1 class="text-center">Add News Blog</h1>
      <label for="title"><b>Title</b></label><span class="text-danger"><i> *Required</i></span><br>
      <input type="text" class="form-control" id="title" name="title" value="<?php echo $title;?>" required><br>
      <div class="row">
        <div class="col-12 col-lg-4 my-2">
          <label for="language"><b>Language</b></label><span class="text-danger"><i> *Required</i></span><br>
          <select name="language" id="language" class="form-control">
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
          </select>
        </div>
        <div class="col-12 col-lg-4 my-2">
          <label for="file"><b>Image Path</b></label><br>
          <input type="file" name="file" id="file">
        </div>
      </div>
      <label class="mt-4" for="html"><b>HTML</b></label><br>
      <textarea name="html"class="form-control"id="html"cols="30"rows="20"><?php echo $html;?></textarea><br>
      <button type="submit" class="btn btn-info" name="add-page" id="add-page">Add News Blog</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
