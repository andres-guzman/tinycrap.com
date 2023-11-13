<?php
$root = '';
$path = 'void/';

function getImagesFromDir($path) {
    $images = array();
    if (is_dir($path) && $img_dir = @opendir($path)) {
        while (false !== ($img_file = readdir($img_dir))) {
            if (preg_match("/(\.gif|\.webp)$/", $img_file)) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    }
    return $images;
}

function getRandomFromArray($ar) {
    $num = array_rand($ar);
    return $ar[$num];
}

$imgList = getImagesFromDir($root . $path);

if (count($imgList) > 0) {
    // Select a new random image
    $img = getRandomFromArray($imgList);
    echo $path . $img;
} else {
    echo 'No images available.';
}
?>
<img id="random--image" alt="Totally Random Image" src="<?php echo $path . $img ?>">