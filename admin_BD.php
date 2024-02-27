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
    <link rel="stylesheet" href="css/registr.css">
    <link rel="stylesheet" href="css/add_servic1.css">
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="website icon" type="png" href="icon/time-is-money2.png">
    <script src="js.js"></script>
    <style>
        .Form_registr {
            position: fixed;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
        }

        .table-wrapper {
            margin: auto;
            box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.2);
            width: 90%;
            margin-bottom: 10px;
            overflow-x: auto;
        }

        .head {
            display: flex;
            justify-content: center;
            margin: -10px auto 15px;
        }

        .button_mini {
            background-color: #e2e2e2;
            border: none;
            width: 2vw;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
        }

        button:hover,
        button:focus {
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25) inset;
        }

        .button_mini img {
            width: 100%;

        }

        .td {
            text-overflow: ellipsis;
        }
        .form_reg {
            width: 80vw;  
            margin: 10vh  0px  0px 9vw;
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

        #chat-text {
            width: 70%;
        }

        .Message {
            position: fixed;
            padding: 40px;
            left: 35%;
            top: 35%;
            border-radius: 20px;
            background-color: #FFF;
            box-shadow: 0px 5px 30px rgba(0, 0, 0, 0.55);
            z-index: 3;
        }

        .submit {
            background-color: var(--color-button-dark);
            margin-top: 10px;
            padding: 10px 30px;
        }
    </style>
</head>
<?php
require_once 'BD/db.php';
if (isset($_POST['send_edit'])) {
    $sql = "UPDATE `BD_Customer` SET `Name` = '" . $_POST['name'] . "', `Surname` = '" . $_POST['surname'] . "', 
    `Middle_Name` = '" . $_POST['patronymic'] . "', `E-mail` = '" . $_POST['e-mail'] . "' 
    WHERE ID =" . $_POST['send_edit'];
    if ($conn->query($sql)) {
        Message("Данные изменены");

    }
}
// function Message($text)
// {
//     echo '<div class="Message" style="width:auto">
//         <label>' . $text . '</label><br>
//         <button class="submit" onclick="go(\'admin_BD.php\')">ОК</button>
//     </div>
//     ';
// }

function Message_yes($text)
{
    echo '<form action="" method="POST"
    <div class="Message" style="width:auto">
        <label>' . $text . '</label><br>
        <button class="submit" name="ok">Да</button>
        <button class="submit" >Нет</button>
    </div></form>
    ';
    if (isset($_POST['ok'])) {
        return true;
    } else {
        return false;
    }
}
if (isset($_POST['edit_person'])) {
    $sql = "SELECT * FROM   `BD_Customer` WHERE ID=" . $_POST['edit_person'];
    if ($result = $conn->query($sql)) {
        foreach ($result as $row) {
            echo ' <section class="Form_registr">
        <form action="" method="POST">
        <div class="head">
            <label>Редактирование:</label>
        </div>
        <div class="fio">
            <div class="input-data">
                <input required type="text" name="name" placeholder="Имя" value="' . $row['Name'] . '" pattern="[A-Za-zА-Яа-яЁё]{3,}">
                <span>Имя</span>
            </div>

            <div class="input-data">
                <input required type="text" name="surname" placeholder="Фамилия" value="' . $row['Surname'] . '" pattern="[A-Za-zА-Яа-яЁё]{2,}">
                <span>Фамилия</span>
            </div>
            <div class="input-data">
                <input required type="text" name="patronymic" placeholder="Отчество" value="' . $row['Middle_Name'] . '" pattern="[A-Za-zА-Яа-яЁё]{3,}">
                <span>Отчество</span>
            </div>
        </div>
        <div class="input-data">
            <input required type="text" name="e-mail" placeholder="MAIL@mail.ru" value="' . $row['E-mail'] . '" pattern="\S+@mail\.ru|gmail\.com">
            <span>E-mail</span>
        </div>
        <button id="submit" type="submit" name="send_edit" value="' . $row['ID'] . '">Изменить</button>
        <a href="http://rabotady/admin_BD.php" class="two">Отмена</a>
    </form>
</section>';
        }
    }
}

if (isset($_POST['delete_person'])) {
    // $flag = Message_yes('Удалить вользователя');
    // if ($flag) {
        $sql = "DELETE FROM   `BD_Customer` WHERE ID=" . $_POST['delete_person'];
        if ($conn->query($sql)) {
            Message('Пользователь удалён');
        }
    // }
}
if (isset($_POST['delete_servic'])) {
    $sql = "DELETE FROM   `BD_Servic` WHERE ID=" . $_POST['delete_servic'];
    if ($conn->query($sql)) {
        Message("Сервис удалён");

    }
}
if (isset($_POST['delete_messages'])) {
    $sql = "DELETE FROM   `Messages` WHERE ID=" . $_POST['delete_messages'];
    if ($conn->query($sql)) {
        Message("Сообщение удалено");

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
                <textarea class="skil" name="inf" value="" placeholder="Добавьте любую информацию"></textarea>
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
?>

<body>
    <script>
        function addRow() {
            var container = document.getElementById("prices").getElementsByTagName("tbody")[0];
            var newRow = document.createElement("tr");
            newRow.innerHTML = '<td><input placeholder="руб" maxlength="3" name="price[]"></td><td><input placeholder="мин" maxlength="3" name="time[]"></td><td><input class="servic" maxlength="60" name="name_price[]"></td>';
            container.appendChild(newRow);
        }
    </script>
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
    <form method="POST" action="">
        <section class="content">

            <h2>Пользователи</h2>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Middle_Name</th>
                            <th>E-mail</th>
                            <th>Login</th>
                            <th>Password</th>
                            <th>Примичание</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql = 'SELECT * FROM   `BD_Customer`';
                        if ($result = $conn->query($sql)) {

                            if ($rowsCount = mysqli_num_rows($result) != 0) {

                                foreach ($result as $row) {
                                    echo '  <tr>
                                <td name="ID_Seller">' . $row['ID'] . '</td>
                                <td>' . $row['Name'] . '</td>
                                <td>' . $row['Surname'] . '</td>
                                <td>' . $row['Middle_Name'] . '</td>
                                <td>' . $row['E-mail'] . '</td>
                                <td>' . $row['Login'] . '</td>
                                <td>' . $row['Password'] . '</td>
                                ';
                                    if ($row['Seller']) {
                                        echo '  <td>Исполнитель</td>';
                                    } else {
                                        echo '  <td>-</td>';
                                    }
                                    echo ' <td>
                           <button class="button_mini" name="edit_person" value="' . $row['ID'] . '"><img src="icon/edit.png"></button>
                           <button class="button_mini" name="delete_person" value="' . $row['ID'] . '"><img src="icon/delete.png"></button>
                           </td>
                           </tr>';
                                }
                            } else print('Ничего не найдено');
                        }
                        ?>
                    <tbody>
                </table>
            </div>



            <h2>Услуги</h2>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID_Person</th>
                            <th>Название</th>
                            <th>Опыт</th>
                            <th>Адрес</th>
                            <th>Время работы</th>
                            <th>Качества </th>
                            <th>Информация</th>
                            <th>TAG</th>
                            <th>Img</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql = 'SELECT * FROM   `BD_Servic`';
                        if ($result = $conn->query($sql)) {

                            if ($rowsCount = mysqli_num_rows($result) != 0) {

                                foreach ($result as $row) {
                                    echo '  <tr>
                                <td name="ID_Seller">' . $row['ID'] . '</td>
                                <td>' . $row['ID_Person'] . '</td>
                                <td>' . $row['Denomination'] . '</td>
                                <td>' . $row['Experience'] . '</td>
                                <td>' . $row['Address'] . '</td>
                                <td>' . $row['Opening'] . '</td>
                                <td> <textarea style="width:100px" disabled=disabled class="inf" readonly>' . $row['Skils'] . '</textarea></td>
                                <td> <textarea style="width:200px" disabled=disabled class="inf" readonly>' . $row['Inf'] . '</textarea></td>
                                <td>' . $row['TAG'] . '</td>
                                <td>' . $row['ImgHref'] . '</td>
                              <td>
                           <button class="button_mini" name="edit_servic" value="' . $row['ID'] . '"><img src="icon/edit.png"></button>
                           <button class="button_mini" name="delete_servic" value="' . $row['ID'] . '"><img src="icon/delete.png"></button>
                           </td>
                           </tr>';
                                }
                            } else print('Ничего не найдено');
                        }
                        ?>
                    <tbody>
                </table>
            </div>




            <h2>Сообщения</h2>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Отправитель</th>
                            <th>Получатель</th>
                            <th id="chat_text">Текст</th>
                            <th>Дата</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql = 'SELECT * FROM   `Messages`';
                        if ($result = $conn->query($sql)) {

                            if ($rowsCount = mysqli_num_rows($result) != 0) {

                                foreach ($result as $row) {
                                    echo '  <tr>
                                <td name="ID_Seller">' . $row['ID'] . '</td>
                                <td>' . $row['ID_Sender'] . '</td>
                                <td>' . $row['ID_Recipient'] . '</td>
                                <td > <textarea  disabled=disabled class="inf" readonly>' . $row['Text'] . '</textarea></td>
                                <td>' . $row['Date'] . '</td>
                                <td>
                           <button class="button_mini" name="delete_messages" value="' . $row['ID'] . '"><img src="icon/delete.png"></button>
                           </td>
                           </tr>';
                                }
                            } else print('Ничего не найдено');
                        }
                        ?>
                    <tbody>
                </table>
            </div>
        </section>
    </form>
</body>

</html>