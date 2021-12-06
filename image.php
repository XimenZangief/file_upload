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

if (isset($_FILES['img']['tmp_name'])) {
    move_uploaded_file($_FILES['img']['tmp_name'], 'img/' . $_FILES['img']['name']);
    switch ($_FILES['img']['type']) {
        case "image/jpeg":
            $oldImage = imagecreatefromjpeg('img/' . $_FILES['img']['name']);
            break;
        case "image/png":
            $oldImage = imagecreatefrompng('img/' . $_FILES['img']['name']);
            break;
        case "image/gif":
            $oldImage = imagecreatefromgif('img/' . $_FILES['img']['name']);
            break;
        case "image/bmp":
            $oldImage = imagecreatefrombmp('img/' . $_FILES['img']['name']);
            break;
    }

    //取得影像尺寸，並以陣列形式回傳
    //["寬px","高px","圖像類型int(下方參考)","width='px' height='px'","顏色位元數","channels(RGB預設3)","mime"]
    // 1 = GIF
    // 2 = JPG
    // 3 = PNG
    // 4 = SWF
    // 5 = PSD
    // 6 = BMP
    // 7 = TIFF(intel byte order)
    // 8 = TIFF(motorola byte order)
    //9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM
    $info = getimagesize('img/' . $_FILES['img']['name']);
    $raito = $_POST['rate'];
    $dwidth = $info[0] * $raito;
    $dheight = $info[1] * $raito;

    //邊框厚度=處理後的寬*0.1/2
    //若沒勾選擇邊框=0
    if (isset($_POST['border'])) {

        $border = ceil(($dwidth * 0.1 / 2));
    } else {
        $border = 0;
    }

    //重新建立圖片並加上邊框
    $new_w = $dwidth - ($border * 2);
    $new_h = $gheight - ($border * 2);
    //建立一個dwidth*dheight的黑色圖像
    $newImage = imagecreatetruecolor($dwidth, $dheight);
    //指定圖像顏色imagecolorallocate(圖片, R, G, B);
    $black = imagecolorallocate($newImage, 0, 0, 0);
    //區域填充imagefill(圖片,x起始點,y起始點,color(從imagecolorallocate設定))
    imagefill($newImage, 0, 0, $black);
    //copy圖片並調整大小
    //imagecopyresampled(目標圖片,來源圖片, 目標x起始, 目標y起始, 來源x起始, 來源y起始, 目標寬px, 目標高px, 來源寬px, 來源高px);
    imagecopyresampled($newImage, $oldImage, $border, $border, 0, 0, $new_w, $new_h, $info[0], $info[1]);
    //產生PNG圖並賦予檔名_border.png
    $filename = 'img/' . explode(".", $_FILES['img']['name'] . "_border.png");
    imagepng($newImage, $filename);
}

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
<form action="?" method="post" enctype="multipart/form-data">
    <input type="checkbox" name="border" value="1">是否有邊框<br>
    <select name="rate" >
        <option value="0.25">縮小四分之一</option>
        <option value="0.5">縮小一半</option>
        <option value="2">放大2倍</option>
    </select>
     <p><input type="file" name="img" ></p>
     <p><input type="submit" value="上傳"></p>
</form>

</form>


<!----縮放圖形----->
<!-- endif寫法 -->
<?php if (isset($_FILES['img']['tmp_name'])): ?>
<div>圖片：</div>
<img src="img/<?=$_FILES['img']['name']?>">
<div>縮放後</div>
<img src="<?=$filename?>">
<?php endif?>
<!----圖形加邊框----->


<!----產生圖形驗證碼----->



</body>
</html>