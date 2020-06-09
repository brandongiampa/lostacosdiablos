<?php
  include_once '../../inc/globals.php';
  include_once '../classes/NewsBlog.php';
  include_once '../functions/functions.php';
  include_once '../../database/db.php';

  if(isset($_POST['add-page'])){
    $title = $_POST['title'];
    $html = $_POST['html'];
    $language = $_POST['language'];

    $uploadOk = true;

    if($_FILES['file']['name']!==""){
      $extension = strrchr($_FILES['file']['name'], '.');
      $new_basename = uniqid('', true) . $extension;
      $target_file = '../../uploads/' . $new_basename;
      $absolute_path = $document_root_path . 'uploads/' . $new_basename;

      $checkFile = getimagesize($_FILES['file']['tmp_name']);
      if ($checkFile===false){
        $uploadOk = false;
        sendAlertDanger("The file you uploaded is not an image file.");
      }
      if($_FILES['file']['size']>1000000){
        $uploadOk = false;
        sendAlertDanger("File must be less than 1MB.");
      }
      if($uploadOk){
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)){
          sendAlertDanger("There was an error uploading your file. Please try again.");
          $uploadOk = false;
          echo $target_file .'<br>';
          echo $absolute_path;
        }
      }
    }
    if($uploadOk){
      try{
        $newsBlog = new NewsBlog(null, $title);
        $newsBlog->setImgPath($absolute_path);
        $newsBlog->setHTML($html);
        $newsBlog->setLanguage($language);

        $title = $newsBlog->getTitle();
        $slug = $newsBlog->getSlug();
        $img_path = $newsBlog->getImgPath();
        $html = $newsBlog->getHTML();
        $language = $newsBlog->getLanguage();

        $db = Database::connectWriteDB();
        $query = "INSERT INTO `ltd_news_blogs`(title, slug, img_path, html, language, timestamp) VALUES (:title, :slug, :img_path, :html, :language, now())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':img_path', $img_path, PDO::PARAM_STR);
        $stmt->bindParam(':html', $html, PDO::PARAM_STR);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->execute();
        sendAlertSuccess("Your entry has been successfully submitted.");
        $title = $img_path = $html = $language = "";
      }
      catch(NewsBlogException $ex){
        sendAlertDanger($ex);
      }
      catch(PDOException $ex){
        sendAlertDanger($ex->getMessage());
      }
    }
  }
  else{
    $title = $img_path = $html = $language = "";
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
