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
$ssql = "SELECT  COUNT(*) AS View FROM Messages WHERE ID_Recipient =" . $ID_Person . " AND View=0";
if ($result = $conn->query($ssql)) {
    foreach ($result as $cout) {
    }
}
if (isset($_POST['yes'])) {
    $A = "" . $_POST['denom'] . ".<br>" . $_POST['text'] . $_POST['time'] . "";
    $sql = "INSERT INTO Messages (`ID`, `ID_Sender`, `ID_Recipient`, `Text`, `Date`)
    VALUES (NULL, '" . $_SESSION['ID_Person'] . "' , '" . $_POST['ID_S'] . "', '" . $A . "', '" . Date('Y-m-d H:i:s') . "')";
    if ($conn->query($sql)) {
    }
    $sql = "DELETE FROM BD_Application  WHERE ID=" . $_POST['yes    '];
    if ($conn->query($sql)) {
    }
}
if (isset($_POST['no'])) {
    $A = "" . $_POST['denom'] . ".<br>Ваша запись отменена";

    $sql = "INSERT INTO Messages (`ID`, `ID_Sender`, `ID_Recipient`, `Text`, `Date`)
    VALUES (NULL, '" . $_SESSION['ID_Person'] . "' , '" . $_POST['ID_S'] . "', '" . $A . "', '" . Date('Y-m-d H:i:s') . "')";
    if ($conn->query($sql)) {
    }
    $sql = "DELETE FROM BD_Application  WHERE ID=" . $_POST['no'];
    if ($conn->query($sql)) {
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
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/add_servic1.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/user.css">
    <link rel="stylesheet" href="css/user_add.css">

    <link rel="website icon" type="png" href="icon/main-icon.png">
    <script src="js.js"></script>
    <style>
        /* .card {
            display: flex;
            flex-direction: column;
        }

        .service__card {
            grid-template-rows: 110px 15px 40px 20px;
            border-radius: 20px 20px 0px 0px;
        }

        .line_card {
            border-bottom: none;
            display: flex;
            justify-content: space-around;
            padding: 0px 10px;
            height: 40px;
            background-color: #FFF;
            border-radius: 0px 0px 20px 20px;
        }

        .form_reg {
            width: 60%;
            margin: 0px 15vw 0px 0px;
            position: fixed;
            box-shadow: 5px 5px 25px rgba(0, 0, 0, 0.45);
            background-color: #f1f1f1;
            padding-bottom: 10px;
            grid-gap: 0.8vw;
        }

        .rg_main_input {
            gap: 0.5vw;
        }

        .two {
            grid-column: 1/3;
            grid-row: 3;
        }

        section span {
            font-size: var(--size-text);
            font-weight: normal;
        }
        .table_block{
            height: 50%;
        overflow-y: auto;
        } */

        .input_time {
            background-color: var(--color-white);
            border: 1px solid gray;
            border-radius: 10px;
            transition: 0.3s all;

        }

        .input_time:hover,
        .input_time:focus {
            box-shadow: 2px 2px 7px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body ые>
    <script>
        function addRow() {
            var container = document.getElementById("prices").getElementsByTagName("tbody")[0];
            var newRow = document.createElement("tr");
            newRow.innerHTML = '<td><input placeholder="руб" maxlength="3" name="price[]"></td><td><input placeholder="мин" maxlength="3" name="time[]"></td><td><input class="servic" maxlength="60" name="name_price[]"></td>';
            container.appendChild(newRow);
        }
    </script>

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
                    <?php if ($cout['View'] > 0) {
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
    <div class="profile">
        <div class="img"> <img src='<?php echo $row['Img'] ?>'></div>
        <div class="name"><?php echo $row['Surname'] . " " . $row['Name'] . " " . $row['Middle_Name'] ?></div>
        <!-- <div class="inf" name='inf'>inf</div> -->
        <div class="mail" name='e-mail'><?php echo $row['E-mail'] ?></div>
        <!-- <div class="edit"><img src="icon/edit.png" alt="edit" /></div> -->
        <!-- <div class="spoti"><img src="icon/notification.png" alt="notification" /></div> -->
        <div class="button_menu">
            <div class="my" onclick="go('user.php')"><img src="icon/list.png"><?php echo $text ?></div>
            <div class="setting" onclick="go('user_setting.php')"><img src="icon/setting.png">настройки</div>
            <div class="setting" onclick="go('index.php')"><img src="icon/exit.png">выйти</div>
        </div>
    </div>
    <div class="button_menu_tel">
        <div class="my" onclick="go('user.php')"><img src="icon/list.png"><?php echo $text ?></div>
        <div class="setting" onclick="go('user_setting.php')"><img src="icon/setting.png">найстройки</div>
        <div class="setting" onclick="go('index.php')"><img src="icon/exit.png">выйти</div>
    </div>
    <form method="POST" action="">

        <section class="content">
            <?php
            if (isset($_POST['delete_servic'])) {
                $sql = "DELETE FROM   `BD_Servic` WHERE ID=" . $_POST['delete_servic'];
                if ($conn->query($sql)) {
                    Message("Сервис удалён");
                }
            }

            if (isset($_POST['edit_servic'])) {
                $sql = "SELECT * FROM   `BD_Servic` WHERE ID=" . $_POST['edit_servic'];
                if ($result = $conn->query($sql)) {
                    foreach ($result as $row) {
                        echo '<form action="" method="POST">
            <section class="form_reg">
                <section class="rg_main">
                    <div class="img">
                    <input type="file"class="file"  id="image-upload"/>
                    <img id="image-preview" src="' . $row['ImgHref'] . '">

                   <script>
                       var input = document.getElementById("image-upload");
                       input.addEventListener("change", function() {
                           var file = this.files[0];
                           var reader = new FileReader();
                           reader.onloadend = function() {
                               document.getElementById("image-preview").src = reader.result;
                           }
                           reader.readAsDataURL(file);
                       });
                   </script>
                    </div>
                    <div class="rg_main_input">
                        <input type="text" value="' . $row['Denomination'] . '" placeholder="Название орагнизации" name="name_ooo" class="name" required>
                        <input type="number" value="' . $row['Experience'] . '" placeholder="Опыт работы" class="experience" name="experience" required>
                        <input type="text" value="' . $row['Address'] . '" placeholder="Адрес" class="address" name="address" required>
                        <input type="text" value="' . $row['Opening'] . '" placeholder="Часы работы" class="Opening" name="opening">
                    </div>
                    <div class="select" name="tag">
                        <span>Категория:</span>
                        <select name="tag">
                        <option value="' . $row['TAG'] . '">' . $row['TAG'] . ' </option> 
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
                </section>
    
    
                <section class="skils" name="skils[]">
                    <span>Ключевые навыки:</span>
                    <textarea  class="skil"  name="skil"  placeholder="Перечислите ключевые навыки через запятную" >' . $row['Skils'] . '</textarea>
                </section>
    
                <section class="price-block">
                <span>Цены:</span>
                <div class="table_block">
                <table class="prices" id="prices">
                    <tr class="name_row">
                        <td><b>Цена</b></td>
                        <td><b>Время</b></td>
                        <td><b>Услуга</b></td>
                    </tr>
                   ';
                        $sql = "SELECT * FROM BD_Price WHERE ID_Servic=" . $row['ID'];
                        if ($result = $conn->query($sql)) {
                            foreach ($result as $pr) {
                                echo '  <tr><td><input value="' . $pr['Price'] . '" placeholder="рубли" maxlength="3" name="price[]"></td>
                            <td><input value="' . $pr['Time'] . '" placeholder="минуты" maxlength="3" name="time[]"></td>
                            <td><input value="' . $pr['Name'] . '" class="servic" maxlength="60" name="name_price[]"></td>
                            ';
                            }
                        }

                        echo '
                </table>
                </div>
                <button onclick="addRow(); return false;">Добавить</button>
                </section>
                <section class="inf_block">
                    <span>Общая информация:</span>
                    <textarea class="skil" name="inf" value="" placeholder="Добавьте любую информацию">' . $row['Inf'] . ' </textarea>
                </section>
                <button class="two" type="submit" name="send_edit_servic" value="' . $row['ID'] . '">Изменить</button><p>
                <a  href="http://rabotady/user.php" class="href">Отмена</a></p>
            </section>
        </form>';
                    }
                }
            }
            if (isset($_POST['name_ooo'])) {
                if (isset($_POST['send_edit_servic'])) {

                    mysqli_query(
                        $conn,
                        $sqll = "UPDATE BD_Servic SET 
            Denomination = '" . $_POST['name_ooo'] . "',
            Experience = '" . $_POST['experience'] . "', 
            Address = '" . $_POST['address'] . "',
            Opening = '" . $_POST['opening'] . "', 
            Skils = '" . $_POST['skil'] . "',
            Inf = '" . $_POST['inf'] . "', 
            `TAG` = '" . $_POST['tag'] . "' WHERE ID=" . $_POST['send_edit_servic']
                    );
                    mysqli_query(
                        $conn,
                        "DELETE FROM BD_Price WHERE ID_Servic=" . $_POST['send_edit_servic']
                    );
                    for ($i = 0; $i < count($_POST['price']); $i++) {
                        mysqli_query(
                            $conn,
                            "INSERT INTO `BD_Price` (`ID`, `ID_Servic`, `Name`, `Time`, `Price`)
                     VALUES (NULL, '" . $_POST['send_edit_servic'] . "', '" . $_POST['name_price'][$i] . "', '" . $_POST['time'][$i] . "' , '" . $_POST['price'][$i] . "');"
                        );
                    }
                    Message("Данные изменены");
                }
            }




            if ($text == "услуги") {
                echo ' <div class="service__block" style="padding-top:35px">';



                $sql = 'SELECT BD_Servic.*, BD_Customer.Name FROM BD_Servic 
            INNER JOIN BD_Customer ON BD_Servic.ID_Person = BD_Customer.ID WHERE Check_admin=1 AND BD_Servic.ID_Person=' . $ID_Person;

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
                   
                            echo ' 
                <div class="card"> 
                    <div onclick="go(\'servic.php?id=' . $id . '\')" class="service__card" >
                        <img  class="card_img" src="' . $src . '" alt="маникюр">
                        <a href="categorii.php?tag=' . $row['TAG'] . '">#' . $row['TAG'] . '</a>
                        <div class="card__title">' . $name . '</div>
                        <div class="card_inf">' . $ad . '</div>
                    </div>
                    <div class="line_card" >
                        <button class="button_mini" name="edit_servic" value="' . $row['ID'] . '"><img src="icon/edit.png"></button>
                        <button class="button_mini" name="delete_servic" value="' . $row['ID'] . '"><img src="icon/delete.png"></button>
                    </div>
                </div>
                    
              ';
                        }
                    } else print('Ничего не найдено');
                }



                echo '</div>
                <button class="button" onclick="go(\'add_servic.php\')">Добавить услугу</button>';

                $sql = 'SELECT *,BD_Application.ID AS "ID_APP",BD_Customer.ID AS "ID_ID", DATE_FORMAT(BD_Application.Time, "%H:%i") AS `Time`,DATE_FORMAT(BD_Application.Time2, "%H:%i") AS `Time2`,
                BD_Application.Name AS "N"
                 FROM BD_Application 
                 INNER JOIN BD_Customer ON BD_Application.ID_Person=BD_Customer.ID
                 INNER JOIN BD_Servic ON BD_Servic.ID = BD_Application.ID_Servic
                 WHERE BD_Servic.ID_Person=' . $ID_Person;

                if ($result = $conn->query($sql)) {
                    if ($rowsCount = mysqli_num_rows($result) != 0) {
                        echo '
                        <h2>Заявки</h2>
            
                    <div class="application_block">
                        ';
                        foreach ($result as $row) {
                            if ($row['Time2'] != NULL) {
                                echo '  <form method="POST" action="">
                                <div class="application">
                            <input type="text" style="display:none" name="ID_S" value="' . $row['ID_ID'] . '  ">
                            <input type="text" style="display:none" name="denom" value="' . $row['Denomination'] . '  ">
                                <input type="text" style="display:none" name="text" value="Вы записаны ' . $row['Date'] . ' ">                         
                                <div class="inf"><a href="chat.php?person=' . $row['ID_ID'] . '">' . $row['Surname'] . ' ' . $row['Name'] . '</a> 
                                <label> "' . $row['Denomination'] . '" </label></b> <i>' . $row["N"] . '</i></div>
                                <div class="time">' . $row['Date'] . ' <br>' . $row['Time'] . ' - ' . $row['Time2'] . ' 
                                <span style="margin-left:20px"> Выберите время записи:</span> 
                                <input name="time" class="input_time" type="time"  value="' . $row['Time'] . '" min="' . $row['Time'] . '" max="' . $row['Time2'] . '" require></div>
                                <button class="yes" name="yes" value="' . $row['ID_APP'] . '">Записать</button>
                                <button class="no" name="no" value="' . $row['ID_APP'] . '">Отменить</button>
                            </div>
                            </form>';
                            } else {
                                echo '<form method="POST" action="">
                            <div class="application">
                            <input type="text" style="display:none" name="ID_S" value="' . $row['ID_ID'] . '  ">
                            <input type="time" style="display:none" name="time" value="' . $row['Time'] . '  ">
                            <input type="text" style="display:none" name="denom" value="' . $row['Denomination'] . '  ">
                            <input type="text" style="display:none" name="text" value="Вы записаны ' . $row['Date'] . '  ">
                            <div class="inf"><a href="chat.php?person=' . $row['ID_ID'] . '">' . $row['Surname'] . ' ' . $row['Name'] . '</a>
                            "' . $row['Denomination'] . '" </label></b> <i>' . $row["N"] . '</i></label></div>
                            <div class="time">' . $row['Date'] . ' <br>' . $row['Time'] . '</div>
                            <button class="yes" name="yes" value="' . $row['ID_APP'] . '">Записать</button>
                            <button class="no" name="no" value="' . $row['ID_APP'] . '">Отменить</button>
                        </div>
                        </form>';
                            }
                        }
                    }
                }
            }
            ?>
            </div>
    </form>
    </section>

</body>

</html>