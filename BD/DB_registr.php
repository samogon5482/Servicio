<?php
if (isset($_POST['send'])) { 

    if ($_POST['customer']=='Yes') {
        $BD='BD_Seller';
        $url='http://rabotady/add_servic.php';
        $a=$authorization_Seller;
    } else {
        $BD='BD_Customer';
        $url='http://rabotady/main.php';
        $a=$authorization_Customer;
    }
    if ($result = $conn->query($a)) {
        foreach ($result as $row) {
            print($row['Login']== $_POST['login']);
            if ($row['Login']== $_POST['login']) {
                echo    'Такой логин уже существует';
                break;
            } else if ($_POST['password'] != $_POST['proverka']) {
                echo'пароль не совпадает';
              break;
            } else if(isset($_POST)){
                mysqli_query(
                    $conn,
                    "INSERT INTO $BD (`ID`, `Name`, `Surname`, `Middle_Name`, `E-mail`, `Login`, `Password`) 
       VALUES (NULL,'" . $_POST['name'] . "', '" . $_POST['surname'] . "', '" . $_POST['patronymic'] . "', 
       '" . $_POST['e-mail'] . "', '" . $_POST['login'] . "', '" . $_POST['password'] . "');"
                );
                unset($_POST);
               header('Location: ' . $url);
               die();
            }
        }
    }
}


?>