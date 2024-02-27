<?php
require_once 'BD/db.php';
define('DB_HOST', 'localhost');
define('DB_USER', 'darina');
define('DB_PASSWORD', '31082005');
define('DB_NAME', 'BD_Customer');
// Имя: a0908355_BD_Servisio
// Пользователь: a0908355_BD_Servisio
// Пароль: 31082005
// Адрес хоста: localhost
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}

function Message($text)
{
    echo '<div class="Message" style="width:auto">
        <label>' . $text . '</label><br>
        <button class="submit" onclick="go(\'admin_BD.php\')">ОК</button>
    </div>';
}

function Person($id)
{
    $sql = "SELECT * FROM BD_Customer  WHERE  ID=" . $id;
    $ssql = "SELECT * FROM BD_Servic WHERE Check_admin=1 AND ID_Person=" . $id;
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($result = $conn->query($sql)) {
        foreach ($result as $row) {
            if ($row['Seller'] == 1) {
                echo '
    <div class="profile_view">
        <div class="profile">
            <div class="img"> <img src="' . $row['Img'] . '"></div>
            <div class="name">' .$row['Surname'] . ' ' . $row['Name'] .' '. $row['Middle_Name']. '</div>
            <div class="mail" name="e-mail">' . $row['E-mail'] . '</div>
            <a href="chat.php?person=' . $row['ID'] . '" class="exit">x</a>
          
        </div>
        <div class="servic_block">';

                if ($res = $conn->query($ssql)) {
                    foreach ($res as $r) {
                        $sssql = 'SELECT  round(AVG(Value),0) AS Value FROM BD_Reviews WHERE ID_Servic ='.$r['ID'];
                        if ($res2 = $conn->query($sssql)) {
                            foreach ($res2 as $cout) {
                                break;
                            }
                        }
                        echo '
            <a href="servic.php?id=' . $r['ID'] . '" class="servic">
                <img src="' . $r['ImgHref'] . '">
                <div class="inf">
                    <span><b>' . $r['Denomination'] . '</b></span>
                    <span>' . $r['Opening'] . '</span>
                    <span>' . $r['Address'] . '</span>
                </div>
                <div class="star"><img src="icon/' . $cout['Value'] . '.png"></div>
            </a>';
                    }
                }
                echo '
        </div>
    </div>
    ';
            }
        }
    }
}
