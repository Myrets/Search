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
<form action="sorchlistalka.php" method="get">
    <input type="text" name="sorch" placeholder="Поіск">
    <input type="submit" name="sent" value="Поіск">
</form>
<?php
echo "<table border='1'><tr>
<th>№</th>
<th>Імя студента</th>
<th>Дата народження</th>
<th>Фамилия</th>
<th>Опис студента</th>
<th>Номер телефону</th>
<th>Фото</th>
</tr>";
require_once ("admin/param.php");
if (isset($_GET['sorch']) && !empty($_GET['sorch']))
{
    $sorch1=$_GET['sorch'];
    $sorch=str_replace(',',' ',$sorch1);
    $word=explode(" ",$sorch);
   // print_r($word);
}
$finalword=array();
if (count($word)>0)
{
    foreach ($word as $tmp)
    {
        if (!empty($tmp))
        {
            $finalword[]=$tmp;
        }
    }
}
 //print_r($finalword);
$rezultword=[];
if (count($finalword)>0)
{
    foreach ($finalword as $tmp2)
    {
        array_push($rezultword," namevacant like '%{$tmp2}%'");
    }
}
//print_r($rezultword);
$zapis=3;
if (count($rezultword)>0)
{
    $whereword=implode(" or ",$rezultword);
}
//echo $whereword;
if (!empty($whereword))
{
    $qvere1="SELECT id from vacant WHERE $whereword";//Вибираєм id професій якіх шукаємо
}
else
    {
        $qvere1="SELECT id from vacant";// Вибірайм id всіх професій
}
$rezult1=mysqli_query($dbs,$qvere1) or die("error 2");
$colvo_zapis=mysqli_num_rows($rezult1);
$colvo_page=ceil($colvo_zapis/$zapis);
if (isset($_GET['page']))
{
    $activ_page=$_GET['page'];
}
else
{
    $activ_page=1;
}
$propusk=($activ_page-1)*$zapis;
if (!empty($whereword))
{
    $qvere="SELECT namevacant,zarplata,opis,namefirm,phone,logo from vacant WHERE $whereword limit $propusk,$zapis";
}
else {
    $qvere = "SELECT namevacant,zarplata,opis,namefirm,phone,logo from vacant limit $propusk,$zapis";
}
echo $qvere;
$rezult=mysqli_query($dbs,$qvere) or die("error 1");
$namber=$propusk+1;
while ($naxt=mysqli_fetch_array($rezult))
{
    $logo=$naxt['logo'];
    if (empty($logo))
    {
        $logo="no-foto1.jpg";
    }
    echo "<tr>
<td>".$namber."</td>
<td>".$naxt['namevacant']."</td>
<td>".$naxt['zarplata']."</td>
<td>".$naxt['opis']."</td>
<td>".$naxt['namefirm']."</td>
<td>".$naxt['phone']."</td>
<td><img width='150xp' src='img/".$logo."'></td>
</tr>";
$namber++;
}
echo "</table>";
echo "<table><tr>";
if ($activ_page==1)
{
    echo "<td> << </td>";
}
else
{
    echo "<td><a href='sorchlistalka.php?page=".($activ_page-1)."&sorch={$_GET['sorch']}'> << </a></td>";
}
for ($i=1; $i<=$colvo_page; $i++) {
    if ($activ_page == $i) {
        echo "<td>$i</td>";
    } else {
        echo "<td><a href='sorchlistalka.php?page=" . $i . "&sorch=".$_GET['sorch']."'>$i</a></td>";
    }
}
    if ($activ_page==$colvo_page)
    {
        echo "<td> >> </td>";
    }
    else
    {
        echo "<td><a href='sorchlistalka.php?page=".($activ_page+1)."&sorch={$_GET['sorch']}'> >> </a></td>";
    }
echo "</table></tr>";
mysqli_close($dbs);
?>
</body>
</html>