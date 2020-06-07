<?php
  include_once '../../database/db.php';

  $language_addon = "";

  if(isset($_POST['language'])){
    $language_addon .= $_POST['language'] === 'All' ? "" : ' WHERE language = "' . $_POST['language'] . '"';
  }
  $currentPageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
  $itemsPerPage = 10;
  $offset = ($currentPageNumber * $itemsPerPage) - $itemsPerPage;
  $maxStringLength = 20;
  $hadDatabaseError = false;
  $errorMessage = "";

  if(isset($_POST['delete-blog'])){
    try{
      $conn = Database::connectWriteDB();
      $stmt = $conn->prepare("DELETE FROM ltd_news_blogs WHERE id = :id");
      $stmt->bindParam(':id', $_POST['delete-id'], PDO::PARAM_INT);
      $stmt->execute();
    }
    catch(PDOException $ex){
      $errorMessage = "There was an issue connecting to the database: " . $ex->getMessage();
    }
    unset($_POST);
  }
  if($errorMessage === ""){
    try{
      $conn = Database::connectReadDB();
      $stmt = $conn->prepare("SELECT DISTINCT * FROM ltd_news_blogs " . $language_addon . " LIMIT :itemsPerPage OFFSET :offset");
      $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
      $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $rowCount = $stmt->rowCount();
      if($rowCount < 1){
        $errorMessage = "There are currently no results to display.";
      }
    }
    catch(PDOException $ex){
      $hadDatabaseError = true;
      $errorMessage = "There has been a database error: " . $ex->getMessage();
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
  <title>CRUD - Los Tacos Diablos News Blogs</title>
</head>
<body>
  <div class="container p-4">
    <h1>Blog Index</h1>
    <p class="text-right">
      <a href="add.php" class="btn btn-primary">+ Add Page</a>
    </p>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="">
      <b>Show:</b>
      <input type="radio" value="All" id="all" name="language"<?php if ((isset($_POST['language'])&&($_POST['language']==="All"))||!isset($_POST['language'])){echo " checked";}?>>
      <label for="all">All</label>
      <input type="radio" value="English" id="english" name="language"<?php if (isset($_POST['language'])&&($_POST['language']==="English")){echo " checked";}?>>
      <label for="english">English</label>
      <input type="radio" value="Spanish" id="spanish" name="language"<?php if (isset($_POST['language'])&&($_POST['language']==="Spanish")){echo " checked";}?>>
      <label for="spanish">Spanish</label>
      <input type="submit" class="btn btn-primary mx-1" name="change-language" id="change-language" value="Reload &rarr;">
    </form>
    <table class="table text-center" style="margin-top:16px;">
      <thead>
        <tr class="bg-light">
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Image Path</th>
          <th scope="col">Language</th>
          <th scope="col">HTML</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php if($rowCount > 0 && !$hadDatabaseError):
          $counter = 0;

          while($row = $stmt->fetch(PDO::FETCH_OBJ)):
          $id = $row->id;
          $title = $row->title !== "" ? $row->title : "---";
          $img_path = $row->img_path !== "" ? $row->img_path : "---";
          $language = $row->language !== "" ? $row->language : "English";
          $html = $row->html !== "" ? substr($row->html, 0, $maxStringLength) : "---";

          if(strlen($html) === $maxStringLength){
            $html .= "...";
          }
          ?>
          <tr class="<?php if($counter % 2 !== 0){echo "bg-light";}?>">
            <td><?php echo $id;?></td>
            <td><?php echo $title;?></td>
            <td><?php echo $img_path;?></td>
            <td><?php echo $language;?></td>
            <td><?php echo $html;?></td>
            <td>
              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return confirm('Are you sure you want to delete the entry at id #<?php echo $row->id;?>?')">
                <a class="btn btn-primary" href="view.php?id=<?php echo $row->id;?>">View</a>
                <a class="btn btn-info" href="edit.php?id=<?php echo $row->id;?>">Edit</a>
                <input type="hidden" name="delete-id" value="<?php echo $id;?>">
                <input class="btn btn-danger" type="submit" name="delete-blog" value="Delete">
              </form>
            </td>
          </tr>
          <?php $counter++;?>
          <?php endwhile;
        endif; ?>
      </tbody>
    </table>
    <?php echo $errorMessage;?>
  </div>
</body>
</html>
