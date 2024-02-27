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
    <link rel="stylesheet" href="css/font.css">
    <link rel="website icon" type="png" href="icon/main-icon.png">
    <script src="js.js"></script>
</head>
<?php
session_start();
require_once 'BD/db.php';
$ID_Person = $_SESSION['ID_Person'];
$ID_Servic = $_GET['id'];
$text= "";

if (isset($_POST['send'])){
if (isset($_POST['text'])) {
    $a = "SELECT * FROM BD_Reviews WHERE ID_servic=".$ID_Servic;
    $flag = true;
    if ($result = $conn->query($a)) {
        foreach ($result as $row) {
            if ($row['ID_Person'] == $ID_Person) {
                global $text;
                $text='Вы уже оставляли отзыв';
                $flag = false;
                break;
            } 
        }
        if ($flag) {
            if (isset($_POST)) {
                mysqli_query(
                    $conn,
                    "INSERT INTO BD_Reviews (`ID`, `ID_servic`, `ID_Person`, `Value`, `Text`, `Date`) 
   VALUES (NULL,'" . $ID_Servic . "', '" . $ID_Person . "', '".$_POST['star']."', 
   '" . $_POST['text'] . "', '" . date('Y-m-j') . "');"
                );
                    header('Location: http://rabotady/reviews.php?id='.$ID_Servic);
                    die();
                }
            }
        }
    }
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
        <li  id="menu-categor" onclick="go('categorii.php')"><img src="icon/categories.png">КАТЕГОРИИ</li>
        <li id="menu-notif" onclick="go('chat.php')"><img src="icon/chat.png">УВЕДОМЛЕНИЯ</li>
      </ul>
      <div class="button" onclick="go('user.php')">
        <img src="<?php session_start(); echo $_SESSION['Img_Person'] ?>" class='user'>
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
    <form action='' method='POST'>
        <input type="submit" class='add_review' placeholder="Впешите текст отзыва" name='add' value="Добавить отзыв">
<?php
if(isset($_POST['add'])){
    echo "
    <div class='add_review-form'>
        <textarea require name='text' placeholder='Напишите отзыв' ></textarea>
        <div class='stars-block'>
            <input class='star star-5' value='5' id='star-5' type='radio' name='star' />
            <label class='star star-5'  for='star-5'></label>
            <input class='star star-4' value='4' id='star-4' type='radio' name='star' />
            <label class='star star-4' for='star-4'></label>
            <input class='star star-3' value='3' id='star-3' type='radio' name='star' />
            <label class='star star-3' for='star-3'></label>
            <input class='star star-2' value='2' id='star-2' type='radio' name='star'/>
            <label class='star star-2' for='star-2'></label>
            <input class='star star-1' value='1' id='star-1' type='radio' name='star' />
            <label class='star star-1' for='star-1'></label>
        </div>
    <label><?php echo $text ?> </label>
        <input type='submit' class='send' name='send'>
    </div>
</form>";
}
?>
        
        <div class='reviews'>
            <?php
          
            $sql = 'SELECT BD_Reviews.*, BD_Customer.ID, BD_Customer.Name FROM BD_Reviews INNER JOIN BD_Customer ON ID_Person = BD_Customer.ID WHERE BD_Reviews.ID_servic=' . $ID_Servic;
            if ($result = $conn->query($sql)) {

                if ($rowsCount = mysqli_num_rows($result) != 0) {
                    foreach ($result as $row) {
                        echo "<div class='review'>
                        <div class='header'> <label class='name'>".$row['Name']."</label> <label class='date'>".$row['Date']."</label><img src='icon/".$row['Value'].".png'> </div>
                       <p>".$row['Text']."</p> 
                    </div>";
                    }
                } else echo "Отзывы отсутствуют";
            }
            ?>
        </div>
    </section>
</body>

</html>