<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
if (!isset($_POST['sent'])) {
    ?>
    <form action="ad.php" method="post" enctype="multipart/form-data">
        <input type="text" name="namevacant" placeholder="Відіть назву ваканції"><br>
        <input type="number" name="zarplata" placeholder="Відіте зарплату"><br>
        <textarea name="opis" placeholder="Відіте опісанія"></textarea><br>
        <input type="text" name="namefirm" placeholder="Відіте названія фірми"><br>
        <input type="number" name="phone" placeholder="Відіте номер тіліфона"><br>
        <h1>Вибіріть логотіп</h1><br>
        <input type="file" name="logo"><br>
        <input type="submit" name="sent" value="Потвердіть"><br>
    </form>
    <?php
}
elseif (isset($_POST['sent'],$_POST['namevacant'],$_POST['zarplata'],$_POST['opis'],$_POST['namefirm'],$_POST['phone']) && !empty($_POST['namevacant']) && !empty($_POST['zarplata']) && !empty($_POST['opis']) && !empty($_POST['namefirm']) && !empty($_POST['phone']))
{
    $namevarcant=$_POST['namevacant'];
    $zarplata=$_POST['zarplata'];
    $opis=$_POST['opis'];
    $namefirm=$_POST['namefirm'];
    $phone=$_POST['phone'];
    require_once ("admin/param.php");
    if (($_FILES['logo']['error']==0))
    {
        $filenemetmp=$_FILES['logo']['tmp_name'];
        $filename=time().$_FILES['logo']['name'];
        move_uploaded_file($filenemetmp,"img/$filename");
        $qvere="INSERT into vacant (namevacant,zarplata,opis,namefirm,phone,logo) VALUES ('$namevarcant','$zarplata','$opis','$namefirm','$phone','$filename') ";
    }
    else
    {
        $qvere="INSERT into vacant (namevacant, zarplata, opis, namefirm, phone) VALUES ('$namevarcant','$zarplata','$opis','$namefirm','$phone')";
    }
    $rezult=mysqli_query($dbs,$qvere) or die("error 1");
    echo "Ваши даниє успешно добавлени<a href='ad.php'>Назад</a>";
    mysqli_close($dbs);
}
else
{
    echo "Ваши даниє неудалось добавіть<a href='ad.php'>Назад</a>";
}
?>
</body>
</html>