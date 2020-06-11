<?php
  define('CAN_OPEN', true);
  include_once '../../database/db.php';

  $currentPageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
  $itemsPerPage = 10;
  $offset = ($currentPageNumber * $itemsPerPage) - $itemsPerPage;
  $maxStringLength = 10;
  $hadDatabaseError = false;
  $errorMessage = "";

  if(isset($_POST['delete-page'])){
    try{
      $conn = Database::connectWriteDB();
      $stmt = $conn->prepare("DELETE FROM ltd_page_content WHERE id = :id");
      $stmt->bindParam(':id', $_POST['delete-id'], PDO::PARAM_INT);
      $stmt->execute();
    }
    catch(PDOException $ex){
      $errorMessage = "There was an issue connecting to the database: " . $ex->getMessage();
    }
    unset($_POST['delete-id']);
    unset($_POST['delete-page']);
  }
  if($errorMessage === ""){
    try{
      $conn = Database::connectReadDB();
      $stmt = $conn->prepare("SELECT DISTINCT * FROM ltd_page_content LIMIT :itemsPerPage OFFSET :offset");
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
  <title>CRUD - Los Tacos Diablos Pages</title>
</head>
<body>
  <div class="container p-4">
    <h1>Page Index</h1>
    <p class="text-right">
      <a href="add.php" class="btn btn-primary">+ Add Page</a>
    </p>
    <table class="table text-center">
      <thead>
        <tr class="bg-light">
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Header Title</th>
          <th scope="col">English HTML</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php if($rowCount > 0 && !$hadDatabaseError):
          $counter = 0;

          while($row = $stmt->fetch(PDO::FETCH_OBJ)):
          $id = $row->id;
          $title = $row->title !== "" ? $row->title : "---";
          $header_title = $row->header_title !== "" ? $row->header_title : "---";
          $html_english = $row->html_english !== "" ? substr($row->html_english, 0, $maxStringLength) : "---";
          $html_spanish = $row->html_spanish !== "" ? substr($row->html_spanish, 0, $maxStringLength) : "---";
          $html_korean = $row->html_korean !== "" ? substr($row->html_korean, 0, $maxStringLength) : "---";

          if(strlen($html_english) === $maxStringLength){
            $html_english .= "...";
          }
          if(strlen($html_spanish) === 20){
            $html_spanish .= "...";
          }
          if(strlen($html_korean) === 20){
            $html_korean .= "...";
          }
          ?>
          <tr class="<?php if($counter % 2 !== 0){echo "bg-light";}?>">
            <td><?php echo $id;?></td>
            <td><?php echo $title;?></td>
            <td><?php echo $header_title;?></td>
            <td><?php echo $html_english;?></td>
            <td>
              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return confirm('Are you sure you want to delete the entry at id #<?php echo $row->id;?>?')">
                <a class="btn btn-primary" href="view.php?id=<?php echo $row->id;?>">View</a>
                <a class="btn btn-info" href="edit.php?id=<?php echo $row->id;?>">Edit</a>
                <input type="hidden" name="delete-id" value="<?php echo $id;?>">
                <input class="btn btn-danger" type="submit" name="delete-page" value="Delete">
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
