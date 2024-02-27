<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servisio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_tel.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/user.css">
    <link rel="stylesheet" href="css/add_servic1.css">
    <link rel="website icon" type="png" href="icon/main-icon.png">
    <script src="js.js"></script>

</head>

<?php

require_once 'BD/db.php';
session_start();

// if(isset($_POST['img'])){
//     header('Location: ' ."http://rabotady/add_servic.php?img=".$_POST['img']);
//      die();}

if (isset($_POST['name_ooo'])) {
    $flag = true;
    $a = "SELECT * FROM BD_Servic";
    if ($result = $conn->query($a)) {
        foreach ($result as $row) {
            if ($row['Denomination'] == $_POST['name_ooo']) {
                echo    'Такое название уже существует';
                $flag = false;
                break;
            }
        }
    }
    if (isset($_POST['send']) && $flag) {


        mysqli_query(
            $conn,
            "INSERT INTO `BD_Servic` (`ID`, `ID_Person`, `Denomination`, `Experience`, `Address`, `Opening`, `Skils`, `ImgHref`,`Inf`, `TAG`, `Check_admin`)
             VALUES (NULL,  '" . $_SESSION['ID_Person'] . "', '" . $_POST['name_ooo'] . "', '" . $_POST['experience'] . "', '" . $_POST['address'] . "', '" . $_POST['opening'] . "','" . $_POST['skil'] . "' ,  '" . $_POST['img'] . "','" . $_POST['inf'] . "','" . $_POST['tag'] . "','0');"
        );
        $sql = "SELECT MAX(ID) FROM BD_Servic ";
        if ($result = $conn->query($sql)) {
            foreach ($result as $id) {

                for ($i = 0; $i < count($_POST['price']); $i++) {
                    mysqli_query(
                        $conn,
                        "INSERT INTO `BD_Price` (`ID`, `ID_Servic`, `Name`, `Time`, `Price`)
                     VALUES (NULL, '" . $id['MAX(ID)'] . "', '" . $_POST['name_price'][$i] . "', '" . $_POST['time'][$i] . "' , '" . $_POST['price'][$i] . "');"
                    );
                }

                $url = 'http://rabotady/user.php?m=' . $id['MAX(ID)'];
                header('Location: ' . $url);
                die();
            }
        }
    }
}
?>

<body>
    <h3>Добавление услуги</h3>
    <form action="" method="POST">
        <section class="form_reg">

            <section class="rg_main">
                <div class="img">
                    <input type="file" class="file" id="image-upload" />
                    <img id="image-preview" src="icon/img.png">

                    <script>
                        var input = document.getElementById('image-upload');
                        input.addEventListener('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();
                            reader.onloadend = function() {
                                document.getElementById('image-preview').src = reader.result;
                            }
                            reader.readAsDataURL(file);
                        });
                    </script>
                </div>
                <div class="rg_main_input">
                    <input type="text" placeholder="Название орагнизации" name="name_ooo" class="name" required>
                    <input type="number" placeholder="Опыт работы" class="experience" name="experience" required>
                    <input type="text" placeholder="Адрес" class="address" name="address" required>
                    <input type="text" placeholder="Часы работы" class="Opening" name="opening">
                </div>
                <div class="select" name='tag'>
                    <span>Категория:</span><br>
                    <select name='tag'>
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


            <section class="skils">
                <span>Ключевые навыки:</span>
                <textarea class="skil" name="skil" value="" placeholder="Перечислите ключевые навыки через запятную"></textarea>
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
                    <tr>
                        <td><input placeholder="рубли" maxlength="3" name="price[]"></td>
                        <td><input placeholder="мин" maxlength="3" name="time[]"></td>
                        <td><input class="servic" maxlength="60" name="name_price[]"></td>
                    </tr>
                </table>
                </div>
                <button onclick="addRow(); return false;">Добавить</button>
                <script>
                    function addRow() {
                        // var container = document.getElementById("prices");
                        var container = document.getElementById("prices").getElementsByTagName("tbody")[0];
                        var newRow = document.createElement("tr");
                        newRow.innerHTML = '<td><input placeholder="рубли" maxlength="3" name="price[]"></td><td><input placeholder="мин" maxlength="3" name="time[]"></td><td><input class="servic" maxlength="60" name="name_price[]"></td>';
                        container.appendChild(newRow);
                    }
                </script>
            </section>

                <section class="inf_block">
                    <span>Общая информация:</span>
                    <textarea class="skil" name="inf" value="" placeholder="Добавьте любую информацию"></textarea>
                </section>
            <button class="two" type="submit" name='send'>Зарегистрировать</button>
            <!-- <button class="skil"> Сохранить</button> -->
        </section>
    </form>
</body>


</html>