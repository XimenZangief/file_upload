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

    //上傳的檔案名用a tag 顯示出來
    // echo "<a href='../file/{$newFileName}'>{$_FILES['file']['name']}</a>";

    //如果副檔名為txt或csv，套入自訂函式saveToDB處理
    if($subname=='txt' || $subname=='csv'){
        saveToDB("../file/".$newFileName);
    }
}

function saveToDB($file){
    echo "得到檔案".$file."<br>";
    echo "LOADING<br>";

    //直接顯示檔案內容
    $display=fopen($file,'a+');
    while(!feof($display)){
        echo fgets($display)."<br>";
    }
    //  \r\n斷行
    fwrite($display,"6,GAMERBEE,SFV,FTG\r\n");
    fclose($display); //關閉檔案(重要)
}
?>