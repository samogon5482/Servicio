<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabotaDy</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/categorii.css">
    <link rel="stylesheet" href="css/style_tel.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="website icon" type="png" href="icon/time-is-money2.png">
    <script src="js.js"></script>
</head>
<?php
session_start();
require_once 'BD/db.php';
$ID_Person = $_SESSION['ID_Person'];
$_SESSION['Person_tag'] = $_GET['tag'];
if (!isset($_SESSION['Person_tag'])) {
    $_SESSION['Person_tag'] = "Категории";
}



$flag = false;
$value = $_POST['score'];
if (isset($_SESSION['Person_tag']) || isset($_POST['tag'])) {
   
    if ($_POST['tag'] != "Категории") {
        if (isset($_POST['tag'])) {
            $_SESSION['Person_tag'] = $_POST['tag'];
        }
        $sql = 'SELECT BD_Servic.*, BD_Customer.Name, BD_Customer.Img FROM BD_Servic 
        INNER JOIN BD_Customer ON BD_Servic.ID_Person = BD_Customer.ID  WHERE Check_admin=1 AND
    BD_Servic.TAG = "' . $_SESSION['Person_tag'] . '"';
        $flag = true;
    }
    if ($_POST['stag'] != "") {
        $sql = $sql . ' AND BD_Servic.Experience' . $_POST['stag'];
    }

    // if ($_POST['score'] != "") {
    //     $sql = $sql . ' AND BD_Servic.Experience' . $_POST['stag'];
    // }
    // $sql= $sql .' WHERE Check_admin=1 AND
    // BD_Servic.TAG = "' . $_SESSION['Person_tag'] . '"';
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
        <div style="margin: auto;">
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A39cff12ba39a6b53b675c68669378c9d8baa4b1eff0cb79972fc7bacbeb72b00&amp;width=508&amp;height=240&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>
        <form action="" method="POST">
            <div class="filter">
                <div class="select" style=" width: 38em;">
                    <select name='tag'>
                        <?php echo "<option value='" . $_SESSION['Person_tag'] . "'>" . $_SESSION['Person_tag'] . "</option> " ?>
                        <option value="Web-услуги">Web-услуги</option>
                        <option value="Авто и мото услуги">Авто и мото услуги</option>
                        <option value="Деловые услуги">Деловые услуги</option>
                        <option value="Дизайнеры">Дизайнеры</option>
                        <option value="Компьютеры и IT">Компьютеры и IT</option>
                        <option value="Красота и здоровье">Красота и здоровье</option>
                        <option value="Организация мероприятий">Организация мероприятий</option>
                        <option value="Охрана и детективы">Охрана и детективы</option>
                        <option value="Перевозки и курьеры">Перевозки и курьеры</option>
                        <option value="Ремонт и строительство">Ремонт и строительство</option>
                        <option value="Ремонт и установка техники">Ремонт и установка техники</option>
                        <option value="Репетиторы и обучение">Репетиторы и обучение</option>
                        <option value="Спорт и фитнес">Спорт и фитнес</option>
                        <option value="Туризм и путешествия">Туризм и путешествия</option>
                        <option value="Услуги для животных">Услуги для животных</option>
                        <option value="Финансовые услуги">Финансовые услуги</option>
                        <option value="Фото, видео, аудио">Фото, видео, аудио</option>
                        <option value="Хозяйство и уборка">Хозяйство и уборка</option>
                        <option value="Эзотерические услуги">Эзотерические услуги</option>
                        <option value="Юридические услуги">Юридические услуги</option>
                    </select>
                </div>

                <div class="select">
                    <select name='stag'>
                        <option value="">Стаж</option>
                        <option value="<=3">меньше 3 лет</option>
                        <option value=">=4">4 года и больше</option>
                        <option value=">=6">6 лет и больше</option>
                        <option value=">=8">8 лет и больше</option>
                    </select>
                </div>
                <div class="select">
                    <select name='score'>
                        <option value="">Оценки</option>
                        <option value="1">больше 1</option>
                        <option value="2">больше 2</option>
                        <option value="3">больше 3</option>
                        <option value="4">больше 4</option>
                        <option value="5">больше 5</option>
                    </select>
                </div>

            </div>
            <input type="submit" name="send_serch" class="send" value="Поиск">
        </form>

        <section class="content">
            <?php

            //  $sql = '';
            if ($flag) {
                if ( $result = $conn->query($sql)) {
                   
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
                            if($value!="" && $cout['Value'] < $value)
                            {
                                continue;
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
                                <img src="' . $row['Img'] . '" alt="аватрака мастера">
                                <span>' . $name_person . '</span>
                            </div>
                        </div>
                        </div>
                        ';
                        }
                    }
                    else{
                    print("ничего не найдено");
                                    }
                }
            }
            else{
            print("Выберите категорию поиска");
            }
            ?>

            </div>
        </section>
    </section>
</body>

</html>