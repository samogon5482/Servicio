<!DOCTYPE html>
<html lang="en">
<?php
require_once 'BD/db.php';

session_start();
$ID_Person = $_SESSION['ID_Person'];
$text = "понравившиеся";
// $ID_Person = $_GET['ID_Person'];
if ($result = $conn->query('SELECT * FROM  `BD_Customer` WHERE ID=' . $ID_Person)) {
    foreach ($result as $row) {
        if ($row['Seller'] == 1) {
            global $text;
            $text = "услуги";
        }
    }
}

if (isset($_POST['send'])) {
    $sql = "UPDATE `BD_Customer` SET `Name` = '" . $_POST['name'] . "', `Surname` = '" . $_POST['surname'] . "', 
        `Middle_Name` = '" . $_POST['patronymic'] . "', `E-mail` = '" . $_POST['e-mail'] . "'
        WHERE `BD_Customer`.`ID` =" . $ID_Person;
    if ($conn->query($sql)) {
        header('Location: http://rabotady/user_setting.php');
        die();
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servisio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_tel.css">
    <link rel="stylesheet" href="css/add_servic1.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/user.css">
    <link rel="stylesheet" href="css/user_setting.css">
    <link rel="website icon" type="png" href="icon/main-icon.png">
    <script src="js.js"></script>
</head>

<body>
    <form action="" method="POST">
        <nav>
            <div tabindex="1" class="logo" onclick="go('main.php')"><img src="img/logo.png" /></div>
            <div class="serch">
                <img src="icon/zoom-search.svg">
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
                    <?php if ($row['View'] > 0) {
                        echo '
                        <label>
                            ' . $row['View'] . '
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
    <div class="profile">
        <div class="img"> <img src='<?php echo $row['Img'] ?>'></div>
        <div class="name"><?php echo $row['Surname'] . " " . $row['Name'] . " " . $row['Middle_Name'] ?></div>
        <!-- <div class="inf" name='inf'>inf</div> -->
        <div class="mail" name='e-mail'><?php echo $row['E-mail'] ?></div>
        <div class="edit"><img src="icon/edit.png" alt="edit" /></div>
        <div class="spoti"><img src="icon/notification.png" alt="notification" /></div>
        <div class="button_menu">
            <div class="my" onclick="go('user.php')"><img src="icon/list.png"><?php echo $text ?></div>
            <div class="setting" onclick="go('user_setting.php')"><img src="icon/setting.png">настройки</div>
            <div class="my" onclick="go('index.php')"><img src="icon/exit.png">выйти</div>
        </div>
    </div>
    <div class="button_menu_tel">
        <div class="my" onclick="go('user.php')"><img src="icon/list.png"><?php echo $text ?></div>
        <div class="setting" onclick="go('user_setting.php')"><img src="icon/setting.png">найстройки</div>
        <div class="my" onclick="go('index.php')"><img src="icon/exit.png">выйти</div>
    </div>
    <section class="setting_block">
        <div class="profile_edit">
            <form action="" enctype="multipart/form-data" method="POST">
                <p>РЕДАКТИРОВАТЬ:</p>
                <div class="img">
                    <input type="file" class="file" id="image-upload" value=""/>
                    <img id="image-preview" src="<?php echo $row['Img'] ?>">
                    <script>
                        var input = document.getElementById('image-upload');
                        input.addEventListener('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();
                            reader.onloadend = function() {
                                document.getElementById('image-preview').src = reader.result;
                            }
                            reader.readAsDataURL(file); });
                    </script>
                </div>
                <div class="fio">
                    <div class="input-data">
                        <input required pattern="[A-Za-zА-Яа-яЁё]{3,}" type="text" name='name' placeholder="Имя" value="<?php echo $row['Name'] ?>">
                    </div>

                    <div class="input-data">
                        <input required pattern="[A-Za-zА-Яа-яЁё]{2,}" type="text" name='surname' placeholder="Фамилия" value="<?php echo $row['Surname'] ?>">
                    </div>
                    <div class="input-data">
                        <input required pattern="[A-Za-zА-Яа-яЁё]{3,}" type="text" name='patronymic' placeholder="Отчество" value="<?php echo $row['Middle_Name'] ?>">
                    </div>
                </div>
                <div class="input-data">
                    <input required pattern="\S+@mail\.ru|gmail\.com" type="text" name='e-mail' placeholder="E-mail" value="<?php echo $row['E-mail'] ?>">
                </div>
                <input id="submit" class='submit' type="submit" name='send' value="Изменить">
            </form>
        </div>
        <div class="boxs">

            <div class="block">
                <div class="name">Изменить пароль</div>
                <div class="setting">
                    <div class="input-data">
                        <input required type="text" name='old-password' placeholder="Старый пароль">
                        <input required type="text" name='new-password' placeholder="Новый пароль">
                        <input required type="text" name='rapet-password' placeholder="Повторите пароль">
                    </div>

                </div>
            </div>
            <div class="block">
                <div class="name">Contact</div>
                <div class="setting">
                    <ul>
                        <li>NAME@mail.ru</li>
                        <li>NAME@mail.ru</li>
                        <li>NAME@mail.ru</li>
                        <li>NAME@mail.ru</li>
                    </ul>
                </div>
            </div>
        </div>

    </section>
</body>

</html>