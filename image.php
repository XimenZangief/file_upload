<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳圖案機制
 * 3.取得圖檔資源
 * 4.進行圖形處理
 *   ->圖形縮放
 *   ->圖形加邊框
 *   ->圖形驗證碼
 * 5.輸出檔案
 */

if(isset($_FILES['img']['tmp_name'])){
    move_uploaded_file($_FILES['img']['tmp_name'], 'img/'.$_FILES['img']['name']);
    switch($_FILES['img']['type']){
        case "image/jpeg":
            $img=imagecreatefromjpeg('img'.$_FILES['img']['name']);
            break;
        case "image/png":
            $img=imagecreatefrompng('img'.$_FILES['img']['name']);
            break;
        case "image/gif":
            $img=imagecreatefromgif('img'.$_FILES['img']['name']);
            break;
        case "image/bmp":
            $img=imagecreatefrombmp('img'.$_FILES['img']['name']);
            break;
    }
}

//建立一個240*180的黑色圖像
$dstimg=imagecreatetruecolor(240,180); 
//指定dsgimg為RGB的顏色
$white=imagecolorallocate($dsgimg,255,255,255);
imagefill($dstimg,0,0,$white);
imagecopyresampled($dstimg,$img,0,0,0,0,240,180,799,532);
$filename='img/'.explode(".",$_FILES['img']['name']."_small");
imagepng($img,$filename);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="header">圖形處理練習</h1>
<!---建立檔案上傳機制--->
<form action="image.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" >選擇檔案
    <input type="submit" value="送出">
</form>


<!----縮放圖形----->
<?php
if(isset($_FILES['img']['tmp_name'])){ ?>
<div>圖片：</div>
<img src="img/<?= $_FILES['img']['name'] ?>" alt="">
<div src="<?= $filename ?>"> 縮放後</div>

<?php } ?>

<!----圖形加邊框----->


<!----產生圖形驗證碼----->



</body>
</html>