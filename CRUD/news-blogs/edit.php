<?php
  include_once '../../inc/globals.php';

  $message = "";

  include_once '../../database/db.php';

  if(isset($_POST['edit-page'])){
    $date = date("Y-m-d H:i:s", strtotime($_POST['date']));
    $title = ucwords($_POST['title']);

    if(isset($_FILES['file'])&&$_FILES['file']['name']!==""){
        $file = $_FILES['file'];
        $target_directory =  "../../uploads/";
        $target_file = $target_directory . basename($_FILES["file"]["name"]);

        //set absolute path for database
        $absolute_directory = "http://192.168.1.232:8080/lostacosamigos/uploads/";
        $absolute_path = $absolute_directory . basename($_FILES["file"]["name"]);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
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
        if($_FILES["file"]["size"]>500000){
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
              $stmt = $conn->prepare('UPDATE ltd_news_blogs SET title = :title, img_path = :img_path, language = :language, html = :html, timestamp = :timestamp WHERE id = :id');
              $stmt->bindParam(':title', $title, PDO::PARAM_STR);
              $stmt->bindParam(':img_path', $absolute_path, PDO::PARAM_STR);
              $stmt->bindParam(':language', $_POST['language'], PDO::PARAM_STR);
              $stmt->bindParam(':html', $_POST['html'], PDO::PARAM_STR);
              $stmt->bindParam(':timestamp', $date, PDO::PARAM_STR);
              $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
              $stmt->execute();
              $message .= '<div class="container"><div class="alert alert-success">Your entry has been successfully edited.</div></div>';
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
    else {

      $conn = Database::connectWriteDB();
      $stmt = $conn->prepare('UPDATE ltd_news_blogs SET title = :title, img_path = :img_path, language = :language, html = :html, timestamp = :timestamp WHERE id = :id');
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':img_path', $_POST['image-path'], PDO::PARAM_STR);
      $stmt->bindParam(':language', $_POST['language'], PDO::PARAM_STR);
      $stmt->bindParam(':html', $_POST['html'], PDO::PARAM_STR);
      $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
      $stmt->bindParam(':timestamp', $date, PDO::PARAM_STR);
      $stmt->execute();
      $message .= '<div class="container"><div class="alert alert-success">Your entry has been successfully edited.</div></div>';
    }
  }
  try{
    $conn = Database::connectReadDB();
    $stmt = $conn->prepare("SELECT * FROM ltd_news_blogs WHERE id = :id LIMIT 1");
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
    $message = "There has been a database error: " . $ex->getMessage();
  }
?>
<?php
  $id = $row->id;
  $date = substr($row->timestamp, 0, 10);
  $title = isset($row->title) ? trim($row->title) : "";
  $img_path = isset($row->img_path) ? trim($row->img_path) : "";
  $language = isset($row->language) ? trim($row->language) : "";
  $html = isset($row->html) ? trim($row->html) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <title>Edit News Blog</title>
</head>
<body>
  <div class="container p-4">
    <?php echo $message;?>
    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id;?>" method="post" enctype="multipart/form-data" onsubmit="document.getElementById('image-path').disabled=false">
      <a href="index.php" class="btn btn-primary">&larr;Back to Index</a>
      <h1 class="text-center">Edit News Blog</h1>
      <p class="text-right"><a href="view.php?id=<?php echo $id;?>" class="btn btn-info">View Entry</a></p>
      <p><b>ID:</b> <?php echo $id;?></p>
      <input type="hidden" value="<?php echo $id;?>" name="id">
      <label for="date"><b>Date</b><span class="text-danger"><i> *Required</i></span></label><br>
      <input name="date" id="date" type="date" value="<?php echo $date;?>"required><br>
      <label class="mt-3" for="title"><b>Title</b></label><span class="text-danger"><i> *Required</i></span><br>
      <input type="text" class="form-control" id="title" name="title" value="<?php echo $title;?>" required><br>
      <label for="image-path"><b>Image Path</b></label><br>
      <div class="row">
        <div class="col-12 col-lg-8 my-1"><input type="text" class="form-control" id="image-path" name="image-path" value="<?php echo $img_path;?>"disabled></div>
        <div class="col-12 col-lg-4 my-1"><input type="file" name="file" id="file" onchange="document.getElementById('image-path').value=document.getElementById('file').value;"></div>
      </div>
      <label class="mt-3" for="language"><b>Language</b></label><span class="text-danger"><i> *Required</i></span><br>
      <select name="language" id="language">
        <option value="English"<?php if ($language==='English' || $language === ""){echo "selected";}?>>English</option>
        <option value="Spanish"<?php if ($language==='Spanish'){echo "selected";}?>>Spanish</option>
      </select><br>
      <label class="mt-3" for="html"><b>HTML</b></label><br>
      <textarea name="html"class="form-control"id="html"cols="30"rows="20"><?php echo $html;?></textarea><br>
      <button type="submit" class="btn btn-info" name="edit-page" id="edit-page">Submit Edit</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
