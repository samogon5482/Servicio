<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servisio</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style_tel.css">
  <link rel="stylesheet" href="css/chatik1.css">
  <link rel="stylesheet" href="css/color.css">
  <link rel="stylesheet" href="css/font.css">
  <link rel="website icon" type="png" href="icon/main-icon.png">
  <script src="js.js"></script>
  <style>
    * {
      overflow-y: hidden;
    }
  </style>
</head>
<?php
require_once 'BD/db.php';
session_start();
if ($_GET['person'] != "") {
  $ssql = "UPDATE Messages SET View=1 WHERE ID_Recipient=" . $_SESSION['ID_Person'] . " AND ID_Sender=" . $_GET['person'];
  if ($conn->query($ssql)) {
  }
}


?>

<body>
  <?php if (isset($_POST['profil_person'])) {
  
    Person($_POST['profil_person']);
  } ?>
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
        <li id="menu-notif" onclick="go('chat.php')"><img src="icon/chat.png">УВЕДОМЛЕНИЯ
          <?php

          $ssql = "SELECT  COUNT(*) AS View FROM Messages WHERE ID_Recipient =" . $_SESSION['ID_Person'] . " AND View=0";
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

  <body>
    <div class="container">
      <div class="row">
        <section class="discussions">
          <ul>

            <?php

            $arr = array();
            $sql = "SELECT * FROM Messages INNER JOIN BD_Customer ON ID_Sender=BD_Customer.ID WHERE ID_Recipient=" . $_SESSION['ID_Person'] . " ORDER BY View ASC, Date DESC";
            if ($result = $conn->query($sql)) {
              foreach ($result as $row) {
                $flag = true;
                global $arr;
                foreach ($arr as $a) {
                  if ($a == $row['ID']) {
                    global $flag;
                    $flag = false;
                    break;
                  }
                }
                if ($flag) {
                  $ssql = "SELECT  COUNT(*) AS View FROM Messages WHERE ID_Recipient =" . $_SESSION['ID_Person'] . " AND ID_Sender=" . $row['ID'] . " AND View=0 ";
                  if ($result = $conn->query($ssql)) {
                    foreach ($result as $cout) {
                    }
                  }
                  echo "<li onclick=\"go('chat.php?person=" . $row['ID'] . "')\" class='discussion'><img class='icon_person' src='" . $row['Img'] . "'>
                  <p>" . $row['Surname'] . " " . $row['Name'] . "</p> ";
                  if ($cout['View'] > 0) {
                    echo "<label>" . $cout['View'] . "</label>";
                  }
                  echo " </li>";
                  array_push($arr, $row['ID']);
                }
                // }
                // }

              }
            } else {
              echo "<br>Ошибка: " . $conn->error;
            }

            $sql = "SELECT * FROM Messages INNER JOIN BD_Customer ON ID_Recipient=BD_Customer.ID WHERE ID_Sender=" . $_SESSION['ID_Person'] . " ORDER BY  Date DESC";
            if ($result = $conn->query($sql)) {
              foreach ($result as $row) {
                $flag = true;
                foreach ($arr as $a) {
                  if ($a == $row['ID']) {
                    global $flag;
                    $flag = false;
                    break;
                  }
                }
                if ($flag) {

                  echo "<li onclick=\"go('chat.php?person=" . $row['ID'] . "')\" class='discussion'><img class='icon_person' src='" . $row['Img'] . "'>
                          <p>" . $row['Surname'] . " " . $row['Name'] . "</p>  </li>";
                  array_push($arr, $row['ID']);
                }
              }
            } else {
              echo "<br>Ошибка: " . $conn->error;
            }

            ?>

          </ul>
        </section>

        <section class="chat">
          <?php
          require_once 'BD/db.php';

          $personID = $_GET['person'];
          if ($personID != "") {


            $sql = "SELECT * FROM BD_Customer  WHERE ID=" . $personID;
            if ($result = $conn->query($sql)) {
              foreach ($result as $row) {
                echo '   <form action="" method="POST">
                <button value="'.$personID.'" class="header-chat" name="profil_person">
                <img class="icon_person" src="' . $row['Img'] . '">
                <a class="name" name="profil_person">' . $row['Surname'] . ' ' . $row['Name'] . '</a>
                </button></form>';
              }
            } else {
              echo "<br>Ошибка: " . $conn->error;
            }


            echo '   <div class="messages-chat" style="overflow-y:auto;">';

            $sql = "SELECT * FROM Messages  WHERE (ID_Recipient=" . $_SESSION['ID_Person'] . " AND ID_Sender=" . $personID . ") OR (ID_Recipient=" . $personID . " AND ID_Sender=" . $_SESSION['ID_Person'] . ") ORDER BY `Messages`.`Date` ASC";
            if ($result = $conn->query($sql)) {
              foreach ($result as $row) {
                if ($row['ID_Sender'] == $_SESSION['ID_Person']) {
                  echo '
                  <div class="message text-only" data-tooltip="' . $row['Date'] . '">
                  <div class="response">
                    <p class="text">' . $row['Text'] . '</p>
                  </div>
                  </div>

            ';
                } else {
                  echo '
                  <div class="message text-only" data-tooltip="' . $row['Date'] . '">
                  <p class="text">' . $row['Text'] . '</p>
                  </div>
                  ';
                }
              }
            } else {
              echo "<br>Ошибка: " . $conn->error;
            }

            echo '</div>
            <form action="" method="POST">
            <div class="footer-chat">
            <textarea type="text" name="message" class="write-message" placeholder="Сообщение"></textarea>
            <input type="submit" name="send" class="send" value="&#9002;">
            </div>
            </form> ';

            if (isset($_POST['message']) && isset($_POST['send'])) {

              $sql = "INSERT INTO Messages (`ID`, `ID_Sender`, `ID_Recipient`, `Text`, `Date`, `View`)
              VALUES (NULL, '" . $_SESSION['ID_Person'] . "' , '" . $personID . "', '" . $_POST['message'] . "', '" . Date('Y-m-d H:i:s') . "', '0')";
              if ($conn->query($sql)) {
                header('Location: http://rabotady/chat.php?person=' . $personID);
                die();
              }
            }
          } else {
            echo "<p><h3> Выберайте собеседника</h3></p>";
          }
          ?>





        </section>
      </div>
    </div>
  </body>
</body>

</html>