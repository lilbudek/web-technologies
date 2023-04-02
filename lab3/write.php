<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';

    $time = time();
    $name = $_POST['name'];
    $fam = $_POST['fam'];
    $faculty = $_POST['faculty'];
    $mood = $_POST['mood'][0];
    $yes = $_POST['yes'];
    $superyes = $_POST['superyes'];

    if (isset($yes)) {
        $yes = "Да!";
    }

    if (isset($superyes)) {
        $superyes = "Конечно, да!";
    }

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }


    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    ) {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    rename("$target_file", "images/image$time.$imageFileType");

    // echo "Данные из опроса: <br>";
    // echo "Имя: $name <br>";
    // echo "Фамилия: $fam <br>";
    // echo "Факультет: $faculty <br>";
    // echo "Настроение: $mood <br>";
    // echo "Любит свой университет? $yes $superyes <br>";

    $fd = fopen("dates/data.dat", 'a') or die("не удалось создать файл");
    fwrite($fd, "$name|");
    fwrite($fd, "$fam|");
    fwrite($fd, "$faculty|");
    fwrite($fd, "$mood|");
    fwrite($fd, "$yes$superyes|");
    fwrite($fd, "<a href='images/image$time.$imageFileType'>image$time.$imageFileType</a><div class='pictures'><img class='pic' src='images/image$time.$imageFileType' title='image$time.$imageFileType'/></div> \n");
    fclose($fd);
}
