<?php
    define("UPLOADS_DIR",  __DIR__);

    $submitted = $_REQUEST["submit"] ?? false;
    $filePath = UPLOADS_DIR . "/foods.json";
    $foods = [];

    if($submitted) {
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
    }

    if(file_exists($filePath)) {
        $contents = trim(file_get_contents($filePath));
        if(strlen($contents) > 1)
            $foods = json_decode(file_get_contents($filePath), true) ?? [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <title>BSIT 4-3 | ITEC 106 | Laboratory Activity 3 | PHP File Manipulation</title>
</head>
<body>
    <div id="main-content">
        <?php if(count($foods) > 0) { ?>
            <h1>Your favorite Foods are:</h1>
            <ol id="foods">
                <?php foreach($foods as $key => $food) { ?>
                    <li><?= $food ?></li>
                <?php } ?>
            </ol>
            <br>
        <?php } else if (file_exists($filePath)) { ?>
            <h1>Your uploaded file seems empty. Make sure that you're following the right format.</h1>
            <br>
        <?php } ?>
        <form enctype="multipart/form-data" action="./" method="post">
            <label for="file">Select your JSON File with your favorite foods <i>(e.g. ["Food 1", "Food 2", "Food 3"])</i></label>
            <i class="hint">Your uploaded file will be saved in the server and its contents will be displayed here.</i>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input type="file" name="file" id="file" accept=".json">
            <button type="submit" name="submit" value="1">Submit</button>
        </form>
    </div>
</body>
</html>