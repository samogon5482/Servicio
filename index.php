<!DOCTYPE html>
<html lang="en">

<?php
require_once 'BD/db.php';
$log = $_POST['login'];
$pas = $_POST['password'];
$ID_Person = 5;
$text = "";
session_start();
if (isset($_POST['login']) && isset($_POST['send']) ) {
    if($_POST['login']=='admin' && $_POST['password']=='1'){
        header('Location: http://rabotady/admin_BD.php');
        die();
    }
    $BD = 'BD_Customer';
    // if ($_POST['customer'] == 'Yes') {
    //     $BD = 'BD_Seller';
    //     // $url = 'main.php';
    //     $url = 'http://rabotady/main.php';

    //     $a = $authorization_Seller;
    // } else {
    //     $BD = 'BD_Customer';
    //     //$url =  'user.php';;
    //     $url = 'http://rabotady/user.php';
    //     $a = $authorization_Customer;
    // }
    $url = 'http://rabotady/user.php';
    $sql = "SELECT `ID`,`Login`,`Password`, `Img` FROM $BD WHERE `Login`='$log' AND `Password` = '$pas' ";
    if ($result = $conn->query($sql)) {
        
        if ($rowsCount = mysqli_num_rows($result) != 0) { // количество полученных строк

            foreach ($result as $row) {

                global $ID_Person;
                $ID_Person = $row["ID"];
                $_SESSION['ID_Person'] = $row["ID"];
                $_SESSION['Img_Person'] = $row['Img'];
            }
            // include $url;
            header('Location: ' . $url);
            die();
        }
        else{
            global $text;
            $text = "Неправильный логин или пароль";
        }
    } 
   
}




?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servisio</title>
    <link rel="stylesheet" href="css/registr.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/join.css">
    <link rel="stylesheet" href="css/style_tel.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="website icon" type="png" href="icon/main-icon.png">
  
</head>

<body>
    <section class="Form_registr">
<!-- <img src='icon/start_logo.png' id='start_img'> -->

        <form action="" method="POST">

            <label style="  text-align: center;">Авторизация:</label>
            <span name="NONE" id='NONE'><?php echo $text?></span>
            <!-- <input type="checkbox" id="switch" name='customer' value='Yes'>
            <label class="label" for="switch">
                <div class="toggle" for="switch"></div>
                <div class="names">
                    <p class="light">Клиент</p>
                    <p class="dark">Исполнитель</p>
                </div>
            </label> -->

            <div class="input-data">
                <input required type="text" name='login' placeholder="Логин" autocomplete="off">
                <span>Логин</span>
            </div>
            <div class="input-data">
                <input required type="text" name='password' placeholder="Пароль" autocomplete="off">
                <span>Пароль</span>
            </div>
            <input id="submit" type="submit" name='send' onclick="Entrance()" value="Войти">
            <a href="registr.php" class='href'>Зарегестрироваться</a>
            
        </form>
    </section>
</body>

</html>