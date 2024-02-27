<?php
require_once 'BD/db.php';
session_start();
$text="";
if (isset($_POST['login'])) {
    $BD = 'BD_Customer';
    if ($_POST['customer'] == '1') {
        // $BD = 'BD_Seller';
        $url = "http://rabotady/add_servic.php?img=img";
    } else {
        // $BD = 'BD_Customer';
        $url = 'http://rabotady/user.php';
    }
    $a = "SELECT * FROM $BD";
    $flag = true;
    if ($result = $conn->query($a)) {
        foreach ($result as $row) {
            if ($row['Login'] == $_POST['login']) {
                global $text;
                $text='Такой логин уже существует';
                $flag = false;
                break;
            } else if ($_POST['password'] != $_POST['proverka']) {
                $text= 'пароль не совпадает';
                break;
            }

           
        }
        if ($flag) {
            if (isset($_POST)) {
                mysqli_query(
                    $conn,
                    "INSERT INTO $BD (`ID`, `Name`, `Surname`, `Middle_Name`, `E-mail`, `Login`, `Password`, `Img`, `Seller`) 
   VALUES (NULL,'" . $_POST['name'] . "', '" . $_POST['surname'] . "', '" . $_POST['patronymic'] . "', 
   '" . $_POST['e-mail'] . "', '" . $_POST['login'] . "', '" . $_POST['password'] . "', NULL, '".$_POST['customer']."');"
                );

                ////////авторизация
              
                $log = $_POST['login'];
                $pas = $_POST['password'];
                $sql = "SELECT `ID`,`Login`,`Password`, `Seller` FROM $BD WHERE `Login`='$log' AND `Password` = '$pas' ";
                if ($result = $conn->query($sql)) {
                   
                    foreach ($result as $row) {
                        $url = 'http://rabotady/user.php';

                        // if ($row['Seller'] == '1') {
                        //     // $BD = 'BD_Seller';
                        //     // $url = "http://rabotady/servic.php?;
                        // } else {
                        //     // $BD = 'BD_Customer';
                        //     $url = 'http://rabotady/user.php';
                        // }
                        $_SESSION['ID_Person'] = $row["ID"];
                    }
                    header('Location: ' . $url);
                    die();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servisio</title>
    <link rel="stylesheet" href="css/registr.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_tel.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="website icon" type="png" href="icon/main-icon.png">
    <script src="js.js"></script>
</head>

<body>
    <section class="Form_registr">
        <form action="" method="POST">
            <div class="head">
                <label>Регистрация:</label>

                <input type="checkbox" id="switch" name='customer' value='1'>
                <label class="label" for="switch">
                    <div class="toggle" for="switch"></div>
                    <div class="names">
                        <p class="light">Клиент</p>
                        <p class="dark">Исполнитель</p>
                    </div>
                </label>
            </div>
            <div class="fio">
                <div class="input-data">
                    <input required type="text" name='name' placeholder="Имя" pattern="[A-Za-zА-Яа-яЁё]{3,}">
                    <span>Имя</span>
                </div>

                <div class="input-data">
                    <input required type="text" name='surname' placeholder="Фамилия" pattern="[A-Za-zА-Яа-яЁё]{2,}">
                    <span>Фамилия</span>
                </div>
                <div class="input-data">
                    <input required type="text" name='patronymic' placeholder="Отчество" pattern="[A-Za-zА-Яа-яЁё]{3,}">
                    <span>Отчество</span>
                </div>
            </div>
            <div class="input-data">
                <input required type="text" name='e-mail' placeholder="MAIL@mail.ru" pattern="\S+@mail\.ru|gmail\.com">
                <span>E-mail</span>
            </div>
            <div class="input-data">
                <input required type="text" name='login' placeholder="Логин">
                <span>Логин</span>
            </div>
            <div class="password">
                <div class="input-data">
                    <input required type="text" name='password' placeholder="Пароль" >
                    <span>Пароль</span>
                </div>
                <div class="input-data">
                    <input required type="text" name='proverka' placeholder="Подтверждение пароля">
                    <span>Подтверждение пароля</span>
                </div>
            </div>
            <span style="color:red; text-align: center;"><?php echo $text?></span>
            <input id="submit" type="submit" name='send' value="Зарегестрироваться">
            <a href="index.php" class='href'>Войти</a>

        </form>
    </section>
</body>

</html>