<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabotaDy</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="website icon" type="png" href="icon/time-is-money2.png">
    <script src="js.js"></script>
</head>
<?php
require_once 'BD/db.php';
if (isset($_POST['yes'])) {
    $ssql = "UPDATE BD_Servic SET Check_admin =1 WHERE BD_Servic.ID=" . $_POST['yes'];
    if ($result = $conn->query($ssql)) {
        foreach ($result as $row) {
        }
    } else {
        echo "<br>Ошибка: " . $conn->error;
    }
} else if (isset($_POST['no'])) {
    $ssql = "DELETE FROM BD_Servic  WHERE ID=" . $_POST['no'];
    if ($conn->query($ssql)) {
        print($_POST['id_seller']);
        $sql = "INSERT INTO `Messages` (`ID`, `ID_Sender`, `ID_Recipient`, `Text`, `Date`) 
        VALUES (NULL, '100', '" . $_POST['id_seller'] . "', 'Заявка на регистрацию ваших услуг была откланена', '" . date('Y-m-j') . "')";
    } else {
        echo "<br>Ошибка: " . $conn->error;
    }
}
?>

<body>
    <nav>
        <div class="logo" onclick="go('index.php')"><img src="img/logo.png" /></div>
        <ul class="menu">
            <li id="menu-categor" onclick="go('admin_BD.php')">БАЗА ДАННЫХ</li>
            <li id="menu-like" onclick="go('admin_applications.php')">ЗАЯВКИ</li>
        </ul>
    </nav>
    <div class="nav_tel">
        <div class="BD" onclick="go('admin_BD.php')">БАЗА</div>
        <div class="zaiavki" onclick="go('admin_applications.php')">ЗАЯВКИ</div>
    </div>

    <section class="content">

        <div class="tabs">
            <input class="input" name="tabs" type="radio" id="tab-1" checked="checked" />
            <label class="label" for="tab-1">Добавить</label>
            <div class="panel">
                <h1>Заяки на добавление:</h1>
                <div class="service__block">
                    <form method="POST" action="">
                        <?php
                        $sql = 'SELECT  BD_Customer.*, BD_Servic.* FROM BD_Servic 
                        INNER JOIN BD_Customer ON BD_Servic.ID_Person = BD_Customer.ID WHERE Check_admin=0';
                        if ($result = $conn->query($sql)) {

                            if ($rowsCount = mysqli_num_rows($result) != 0) {

                                foreach ($result as $row) {
                                    $id_person = $row['ID_Person'];
                                    $name_person = $row['Name'];
                                    $surname = $row['surname'];
                                    $midname = $row['Middle_Name'];
                                    $id = $row['ID'];
                                    $src =  $row['ImgHref'];
                                    $name = $row['Denomination'];
                                    $ad = $row['Address'];
                                    $stage = $row['Experience'];
                                    $open = $row['Opening'];
                                    $ssql = 'SELECT  round(AVG(Value),2) AS Value FROM BD_Reviews WHERE ID_Servic =' . $id;
                                    if ($result = $conn->query($ssql)) {
                                        foreach ($result as $cout) {
                                            break;
                                        }
                                    }
                                    echo ' <div class="card">
                            <div class="card_img"><img src="img/'.$src.'"></div>
                            <div class="main_inf">
                                <b><label>' . $name . '</label></b>
                                <label>' . $surname . ' ' . $name_person . ' ' . $midname . '</label>
                                <label>' . $ad . '</label>
                                <label>' . $open . '</label>
                            </div>
                            <div class="prices">';
                                    $sql = "SELECT * FROM BD_Price WHERE ID_Servic=" . $row['ID'];
                                    if ($result = $conn->query($sql)) {
                                        foreach ($result as $pr) {
                                            echo ' 
                                            <div class="price">
                                            <label   label class="num">'.$pr['Price'].' руб</label>
                                            <label class="h">'.$pr['Time'].' мин</label>
                                            <label class="s">'.$pr['Name'].'</label>
                                            </div>';
                                        }
                                    }

                                    echo '</div>
                            <input type="text" name="id_seller" style="display:none" value="' . $id_person . '">
                            <textarea disabled=disabled class="inf" readonly> ' . $row['Inf'] . '</textarea>
                            <button class="yes" name="yes" type="submit" value="' . $id . '" >ok</button>
                            <button class="no" name="no" type="submit" value="' . $id . '">delete </button>
                        </div>
                        ';
                                }
                            } else print('Ничего не найдено');
                        }
                        ?>
                    </form>
                </div>
            </div>
            <!-- <input class="input" name="tabs" type="radio" id="tab-2" />
            <label class="label" for="tab-2">Редактировать</label>
            <div class="panel">
                <h1>Заявки на редактирование:</h1>
                <div class="service__block">
                    <div class="card"> 
                        <div class="service__card" onclick="go('servic.html')">
                            <img class="card_img" src="img/img.png" alt="маникюр">
                            <div class="card__title">Серая мышь</div>
                            <div class="card_inf">Колесниково 28-11</div>
                            <div class="line_card">
                                <div id="stag" data-tooltip="стаж"><img src="icon/time.png" alt="">2</div>
                                <div id="star" data-tooltip="оценка"><img src="icon/star-black.png" alt="">5</div>
                                
                            </div>
                            <div class="card_master">
                                <img src="img/img3.png">
                                <span>Арина</span>
                            </div>
                        </div>
                    </div>
                    <div class="card"> 
                        <div class="service__card" onclick="go('servic.html')">
                            <img class="card_img" src="img/img.png" alt="маникюр">
                            <div class="card__title">Серая мышь</div>
                            <div class="card_inf">Колесниково 28-11</div>
                            <div class="line_card">
                                <div id="stag" data-tooltip="стаж"><img src="icon/time.png" alt="">2</div>
                                <div id="star" data-tooltip="оценка"><img src="icon/star-black.png" alt="">5</div>
                            S
                            </div>
                            <div class="card_master">
                                <img src="img/img3.png">
                                <span>Арина</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <input class="input" name="tabs" type="radio" id="tab-3" />
            <label class="label" for="tab-3">Удалить</label>
            <div class="panel">
                <h1>Заявки на удаление:</h1>
                <div class="service__block">
                    <div class="card"> 
                        <div class="service__card" onclick="go('servic.html')">
                            <img class="card_img" src="img/img.png" alt="маникюр">
                            <div class="card__title">Серая мышь</div>
                            <div class="card_inf">Колесниково 28-11</div>
                            <div class="line_card">
                                <div id="stag" data-tooltip="стаж"><img src="icon/time.png" alt="">2</div>
                                <div id="star" data-tooltip="оценка"><img src="icon/star-black.png" alt="">5</div>
                            </div>
                            <div class="card_master">
                                <img src="img/img3.png">
                                <span>Арина</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- </div> -->
    </section>
</body>

</html>