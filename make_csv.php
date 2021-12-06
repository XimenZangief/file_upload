<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=s1100422";
$pdo= new PDO($dsn,'s1100422','s1100422');
// $file=fopen('display.csv','w+');
if(isset($_GET['do'])){
    switch($_GET['do']){
        case 'KOF':
            $rows=$pdo->query("SELECT * from `gamers` where `title`='KOF'")->fetchALL();
            break;
        case 'SFV':
            $rows=$pdo->query("SELECT * from `gamers` where `title`='SFV'")->fetchALL();
            break;
        case 'LOL':
            $rows=$pdo->query("SELECT * from `gamers` where `title`='LOL'")->fetchALL();
            break;
    }
    $file=fopen('display.csv','w+');
}else{
    $rows=$pdo->query("SELECT * from gamers")->fetchALL();
}

echo "<ul>";
foreach($rows as $key => $row){
    echo "<li>";
    echo $row[0]. "," .$row[1]. "," .$row[2]. "," .$row[3];
    echo "</li>";
    fwrite($file,$row[0]. "," .$row[1]. "," .$row[2]. "," .$row[3]."\r\n");
}
echo "</ul>";
fclose($file);
?>

<a href="?do=KOF">do KOF</a><br>
<a href="?do=SFV">do SFV</a><br>
<a href="?do=LOL">do LOL</a><br>
<?php
if(file_exists('display.csv')){
    echo "<a href='display.csv' download>下載檔案</a>";
}
?>