<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servisio</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style_tel.css">
  <link rel="stylesheet" href="css/servic1.css">
  <link rel="stylesheet" href="css/color.css">
  <link rel="stylesheet" href="css/registr.css">

  <link rel="stylesheet" href="css/font.css">
  <link rel="website icon" type="png" href="icon/main-icon.png">
  <script src="js.js"></script>
  <style></style>
</head>
<?php
session_start();
require_once 'BD/db.php';
$ID_Person = $_SESSION['ID_Person'];
$Person_img = $_SESSION['Img_Person'];

if (isset($_POST['mas'])) {
  header('Location: http://rabotady/chat.php?person=' . $_POST['mas']);
  die();
}
if (isset($_POST['send_application'])) {
  if ($_POST['time2'] == '') {
    $sql = "INSERT INTO BD_Application (`ID`, `ID_Person`, `ID_Servic`, `Date`, `Time`, `Time2`, `Name`)
   VALUES (NULL, '" . $ID_Person . "', '" . $_GET['id'] . "', '" . $_POST['day'] . "', '" . $_POST['time1'] . "', NULL, '".$_POST['name_servic']."' )";
  } else    $sql = "INSERT INTO BD_Application (`ID`, `ID_Person`, `ID_Servic`, `Date`, `Time`, `Time2`,`Name`)
  VALUES (NULL, '" . $ID_Person . "', '" . $_GET['id'] . "', '" . $_POST['day'] . "', '" . $_POST['time1'] . "', '" . $_POST['time2'] . "', '".$_POST['name_servic']."' )";
}
if($conn->query($sql)){
  // header('Location: http://rabotady/chat.php?person=1');
  // die();
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
          $sql = 'SELECT * FROM  BD_Servic WHERE Denomination LIKE "%' . $_POST['serch'] . '%" AND Check_admin=1';
        }
        ?>
      </div>
      <ul class="menu">
        <li id="menu-categor" onclick="go('categorii.php')"><img src="icon/categories.png">КАТЕГОРИИ</li>
        <li id="menu-notif" onclick="go('chat.php')"><img src="icon/chat.png">УВЕДОМЛЕНИЯ</li>
      </ul>
      <div class="button" onclick="go('user.php')">
        <img src="<?php
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


  <div id="main-img"><img src="img/img2.png"></div>
  <section class="content">
    <?php
    require_once 'BD/db.php';

    $ID_Person = $_SESSION['ID_Person'];
    $ID_Servic = $_GET['id'];
    $sql = 'SELECT BD_Servic.*, BD_Customer.* FROM BD_Servic INNER JOIN BD_Customer ON BD_Servic.ID_Person = BD_Customer.ID WHERE BD_Servic.ID =' . $ID_Servic;
    if ($result = $conn->query($sql)) {

      if ($rowsCount = mysqli_num_rows($result) != 0) {

        foreach ($result as $row) {
          //////PERSON
          $id_person = $row['ID_Person'];
          $name_person = $row['Name'];
          $surname_p = $row['Surname'];
          $middle_p = $row['Middle_Name'];
          $mail_p = $row['E-mail'];
          /////SERVIC
          $id = $row['ID'];
          $src =  $row['ImgHref'];
          $name = $row['Denomination'];
          $ad = $row['Address'];
          $stage = $row['Experience'];
          $open = $row['Opening'];
          echo ' <div class="main-inf">
                        <div class="img"><img src="' . $src . '"></div>
                        <h1> “' . $name . '”</h1>
                        <div class="inf">
                            <span class="FIO"><b>ФИО: </b>' . $surname_p . ' ' . $name_person . ' ' . $middle_p . '</span>
                            <span class="Experience"><b>Опыт: </b>' . $stage . ' года</span>
                            <span class="Address"><b>Адрес: </b> ' . $ad . '</span>
                            <br>
                            <span class="Opening hours"><b>Часы работы: </b>' . $open . '</span>
                        </div>
                  </div>
                    <div class="mini-blocks">';
          $arr = explode(",", $row['Skils']);
          foreach ($arr as $p) {
            echo '<div> ' . $p . ' </div>';
          }

          echo ' </div>
                    
                    <div class="block-price">
                        <h3>ЦЕНЫ:</h3>
                        <div class="price"> ';
                        $sssql = 'SELECT  round(AVG(Value),0) AS Value FROM BD_Reviews WHERE ID_Servic =' .  $ID_Servic;
                        if ($res2 = $conn->query($sssql)) {
                            foreach ($res2 as $cout) {
                                break;
                            }
                        }
          $sql = "SELECT * FROM BD_Price WHERE ID_Servic=" . $ID_Servic;
          if ($result = $conn->query($sql)) {
            foreach ($result as $pr) {
              echo '  
                              <div class="price-servic">
                                <div class="dollar">' . $pr['Price'] . ' руб</div>
                                <div class="min">' . $pr['Time'] . ' мин</div>
                                <div class="name">' . $pr['Name'] . '</div>
                          </div>';}}
          echo '
                        </div>
                    </div>
                    <div class="inf_dop">
                       <p>' . $row['Inf'] . '</p>
                    </div>
                    <div class="review_go" onclick="go(\'reviews.php?id=' . $ID_Servic . '\')">
                        Отзывы <img class="dw" src="icon/'.$cout['Value'].'.png">
                    </div> 
                <form class="buttons" action="" method="POST"> 
                    <div  class="buttons">
                        <button class="send" type="submit" name="mas" value="' . $id_person . '">Написать сообщение</button>
                       <button class="send"  type="submit" name="record">Записаться</button>
                   </div>
                </form>';
        }
      } else print('Ничего не найдено');
    }

    if (isset($_POST['record'])) {

      echo ' <section style="position:fixed; margin-top:0px;box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.4); "   class="Form_registr">
    <form action="" method="POST">
        <label style="  text-align: center; ">Запись:</label>
        <div style="display: flex;">
        <div class="input-data">
            <input required type="date" name="day" placeholder="День" autocomplete="off">
            <span>День</span>
        </div>

        <div class="select" > 
        <span>Услуга:</span>
        <select name="name_servic">';
      $sq = "SELECT * FROM BD_Price WHERE ID_Servic=" . $ID_Servic;
      // <option value="Web-услуги">Web-услуги</option>
      if ($result = $conn->query($sql)) {
        foreach ($result as $n) {
          echo ' <option value="' . $n['Name'] . '">' . $n['Name'] . '</option> 
                ';
        }
      }
      echo '   
        </select>
        </div>
    </div>
        Если хотите записаться на конкретное время, то выберите только первое время
        <div style="display: flex;">
            <div class="input-data">
                <input required type="time" name="time1" placeholder="с" autocomplete="off">
                <span>с</span>
            </div>
            <label>	&ensp; - &ensp;</label>
            <div class="input-data">
                <input type="time" name="time2" placeholder="до" autocomplete="off">
                <span>до</span>
            </div>
        </div>
        <input id="submit" type="submit" name="send_application" onclick="Entrance()" value="Записаться">
        <a href="servic.php?id=' . $_GET['id'] . '" class="href">Закрыть</a>
    </form>
  </section>';
    }
    ?>
  </section>
</body>

</html>