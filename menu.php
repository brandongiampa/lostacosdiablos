<?php
  define('CAN_OPEN', true);
  $document_language = isset($_COOKIE['documentlanguage']) ? $_COOKIE['documentlanguage'] : 'en';
  $page_hero_image = "img/large/twelvebythree1.jpg";
  $page_header = "Menu";
  include_once 'inc/header.php';?>
<?php
  $carnesList = array(
    "Asada",
    "Pastor",
    "Pollo",
    "Chorizo",
    "Carnitas",
    "Lengua",
    "Cabeza",
    "Buche",
    "Tripa",
    "Birria",
    "Camaron",
    "Pezcado"
  );
  $singleItems = array(
    array(
      'food' => 'BURRITOS',
      'price' => '$6.50-$8.95'
    ),
    array(
      'food' => 'QUESADILLAS',
      'price' => '$6.50-$8.95'
    ),
    array(
      'food' => 'ASADA FRIES',
      'price' => '$7.50'
    ),
    array(
      'food' => 'SOPAS',
      'price' => '$3.25'
    ),
    array(
      'food' => 'MULITAS',
      'price' => '$3.25'
    ),
    array(
      'food' => 'TORTAS',
      'price' => '$7.50'
    ),
  );
?>
        <div class="menu-section">
          <div class="menu-subsection">
            <div class="menu-subsection-header">
              <h5>CARNES</h5>
            </div>
            <table class="menu-subsection-table menu-text">
              <?php

                $numberOfColumns = 3;
                $outputString="";
                $counter=1;

                for($i=0;$i<count($carnesList);$i++){
                  if($counter===1){
                    $outputString .= "<tr>";
                  }
                  $outputString .= "<td>";
                  $outputString .= $carnesList[$i];
                  $outputString .= "</td>";
                  if($counter===$numberOfColumns||$counter===sizeof($carnesList)-1){
                    $outputString .= "</tr>";
                  }
                  $counter = $counter === $numberOfColumns ? 1 : $counter+1;
                }
                echo $outputString;
              ?>
            </table>
          </div>
          <div class="menu-subsection menu-subsection-split-2">
            <?php
              $tacos125=array(
                "Asada", "Pastor", "Pollo", "Chorizo"
              );
              $tacos150 = array(
                "Carnitas", "Lengua", "Cabeza", "Buche", "Tripa"
              );
            ?>
          </div>
          <div class="menu-item">
            <div class="menu-header">
              <h5>Tacos <span class="price">$1.25</span></h5>
            </div>
            <div class="menu-text">
              <?php
                for($i=0;$i<sizeof($tacos125)-1;$i++){
                  echo $tacos125[$i]." | ";
                }
                echo $tacos125[(sizeof($tacos125))-1];
              ?>
            </div>
          </div>
          <div class="menu-section">
            <div class="menu-header">
              <h5>Tacos <span class="price">$1.50</span></h5>
            </div>
            <div class="menu-text">
              <?php
                for($i=0;$i<sizeof($tacos150)-1;$i++){
                  echo $tacos150[$i]." | ";
                }
                echo $tacos150[(sizeof($tacos150))-1];
              ?>
            </div>
          </div>
          <div class="menu-single-items">
            <h5>BURRITOS <span class="price">$6.50-$8.95</span></h5>
            <h5>QUESADILLAS <span class="price">$6.75</span></h5>
            <h5>ASADA FRIES <span class="price">$7.50</span></h5>
            <h5>SOPAS <span class="price">$3.25</span></h5>
            <h5>MULITAS <span class="price">$3.25</span></h5>
            <h5>TORTAS <span class="price">$7.50</span></h5>
            <h5>PAPA / BAKED POTATO <span class="price">$7.50</span></h5>
          </div>
          <div class="menu-item">
            <h5>FLAMING ASADA FRIES <span class="price">$9.95</span></h5>
            <div class="subtext menu-text">A bunch of text I can't read</div>
          </div>
          <div class="menu-item">
            <h5>NACHOS <span class="price">$7.50</span></h5>
            <div class="subtext menu-text">A bunch of text I can't read <span class="price">$9.00</span></div>
          </div>
          <div class="menu-subsection-header">
            <h5>MARISCOS</h5>
          </div>
          <table class="menu-text">
            <tr>
              <td>Taso de pescado</td>
              <td class="price">$3.75</td>
            </tr>
            <tr>
              <td>Taso de camaron</td>
              <td class="price">$3.75</td>
            </tr>
            <tr>
              <td>Ceviche de camaron</td>
              <td class="price">$3.75</td>
            </tr>
            <tr>
              <td>Taso governador</td>
              <td class="price">$3.75</td>
            </tr>
            <tr>
              <td>Something de pescado</td>
              <td class="price">$3.75</td>
            </tr>
          </table>
        </div>
      </div>
    </main>
<?php include_once 'inc/footer.php';?>
