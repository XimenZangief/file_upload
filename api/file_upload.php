<?php

//if($_FILES['file']['error']==0)
//如果tmp_name存在表示上傳成功
if(!empty($_FILES['file']['tmp_name'])){

    //md5編碼函式
    $filename=md5(time());
    //抓取*檔名+副檔名*，並將檔名與副檔名拆分成陣列
    //explode(".",a.txt) =>  ['a','txt']
    $subname=$_FILES['file']['name'];
    $subname=explode(".",$subname)[1];

    $newFileName=$filename.".".$subname;

    echo "new=>".$newFileName."<br>";
    echo "tmp_name=>".$_FILES['file']['tmp_name']."<br>";
    echo "original filename=>".$_FILES['file']['name']."<br>";

    move_uploaded_file($_FILES['file']['tmp_name'],"../file/".$newFileName);
}
?>