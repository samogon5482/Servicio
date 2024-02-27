<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servisio</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style_tel.css">
  <link rel="stylesheet" href="css/color.css">
  <link rel="stylesheet" href="css/font.css">
  <link rel="website icon" type="png" href="icon/main-icon.png">
  <script src="js.js"></script>
</head>
<?php
session_start();
require_once 'BD/db.php';
$ID_Person = $_SESSION['ID_Person'];
$Person_img = $_SESSION['Img_Person'];
if(isset($_POST['name_person'])){
  Person($_POST['name_person']);
}
?>

<body>
  <form action="" method="POST">
    <nav>
      <div tabindex="1" class="logo" onclick="go('main.php')"><img src="img/logo.png" /></div>
      <div class="serch"><img src="icon/zoom-search.svg">
        <input tabindex="2" id="search" type="search" autocomplete="off" name="serch" placeholder="Поиск услуг">
        <input type="submit" name='send' id='serch_send' value="&#10003;">
        <?php
        if (isset($_POST['serch'])) {
          Person("ASD");
        }
        ?>
      </div>
      <ul class="menu">
        <li id="menu-categor" onclick="go('categorii.php')"><img src="icon/categories.png">КАТЕГОРИИ</li>
        <li id="menu-notif" onclick="go('chat.php')"><img src="icon/chat.png">УВЕДОМЛЕНИЯ
      <?php
      require_once 'BD/db.php';
      session_start();
      $ssql = "SELECT  COUNT(*) AS View FROM Messages WHERE ID_Recipient =" . $_SESSION['ID_Person']." AND View=0";
      if ($result = $conn->query($ssql)) {
        foreach ($result as $cout) {
        }
      }
      if ($cout['View'] > 0) {
        echo '
                <label>
                    ' . $cout['View'] . '
                </label>
                ';
      }
      ?>
      </li>
      </ul>
      <div class="button" onclick="go('user.php')">
        <img src="<?php session_start();
                  echo $_SESSION['Img_Person'] ?>" class='user'>
      </div>
    </nav>
  </form>
  <div class="nav_tel">
    <div class="home" onclick="go('main.php')"><img src="icon/home.png"></div>
    <div class="serch" onclick="go('categorii.php')"><img src="icon/search.png"></div>
    <div class="notif" onclick="go('chat.php')"><img src="icon/chat.png"></div>
    <div class="user" onclick="go('user.php')"><img src="<?php echo $_SESSION['Img_Person'] ?>"></div>
  </div>
  <section class="content">
    <div class="service__block">


      <?php


      $ID_Person = $_SESSION['ID_Person'];
      
$sql = 'SELECT BD_Servic.*, BD_Customer.Name, BD_Customer.Img FROM BD_Servic 
INNER JOIN BD_Customer ON BD_Servic.ID_Person = BD_Customer.ID WHERE Check_admin=1';

      if ($result = $conn->query($sql)) {

        if ($rowsCount = mysqli_num_rows($result) != 0) {

          foreach ($result as $row) {


            $id_person = $row['ID_Person'];
            $name_person = $row['Name'];
            $id = $row['ID'];
            $src =  $row['ImgHref'];
            $name = $row['Denomination'];
            $ad = $row['Address'];
            $stage = $row['Experience'];
            $ssql = 'SELECT  round(AVG(Value),2) AS Value FROM BD_Reviews WHERE ID_Servic =' . $id;
            if ($result = $conn->query($ssql)) {
              foreach ($result as $cout) {
                break;
              }
            }
            echo ' <div class="card"> 
                        <div class="service__card" onclick="go(\'servic.php?id=' . $id . '\')">
                            <img class="card_img" src="' . $src . '" alt="картинка услуги">
                            <a href="categorii.php?tag=' . $row['TAG'] . '">#' . $row['TAG'] . '</a>
                            <div class="card__title">' . $name . '</div>
                            <div class="card_inf">' . $ad . '</div>
                            <div class="line_card">
                                <div id="stag" data-tooltip="стаж"><img src="icon/time.png" alt="">' . $stage . '</div>
                                <div id="star" data-tooltip="оценка"><img src="icon/star-black.png" alt="">' . $cout['Value'] . '</div>
                            </div>
                            <div class="card_master">
                                <img src="'.$row['Img'].'" alt="аватрака мастера">
                                <a href="chat.php?person='.$id_person.'" name="name_person">' . $name_person . '</a>
                            </div>
                        </div>
                    </div>
                    ';
          }
        } else print('Ничего не найдено');
      }
   
      ?>
    </div>
  </section>
</body>

</html>