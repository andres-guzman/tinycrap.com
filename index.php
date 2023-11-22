<?php
session_start();

// Unique visits counter
$visitorLog = 'visitor_log.txt';
$ip = $_SERVER['REMOTE_ADDR'];

// Read the current visitor log
$log = file_get_contents($visitorLog);
$visitorData = json_decode($log, true);

// Get the current month and year
$currentMonth = date('n');
$currentYear = date('Y');

// Check if the visitor has already been recorded for the current month and year
if (!isset($visitorData[$currentYear][$currentMonth][$ip])) {
    // Record the visitor for the current month and year
    $visitorData[$currentYear][$currentMonth][$ip] = true;

    // Save the updated visitor log
    file_put_contents($visitorLog, json_encode($visitorData));

    // Increment the unique visitor count
    $uniqueVisitorCount = count($visitorData[$currentYear][$currentMonth]);
} else {
    $uniqueVisitorCount = count($visitorData[$currentYear][$currentMonth]);
}

//Loads a random image from folder
$root = '';
$path = 'void/';

function getImagesFromDir($path) {
    $images = array();
    if ($img_dir = @opendir($path)) {
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
    if (empty($ar)) {
        return false;
    }
    $num = array_rand($ar);
    return $ar[$num];
}

$imgList = getImagesFromDir($root . $path);

// Define the error message variable
$errorMessage = "";

// Check if the "images/" folder is empty
if (empty($imgList)) {
    $errorMessage = "No images available. Folder is empty!";
}

// Check if an image has already been selected for this session
if (isset($_SESSION['selected_image']) && !empty($imgList)) {
    $selectedImage = $_SESSION['selected_image'];

    // Remove the selected image from the list
    if (($key = array_search($selectedImage, $imgList)) !== false) {
        unset($imgList[$key]);
    }

    // If all images have been shown in this session, reset the list
    if (empty($imgList)) {
        $imgList = getImagesFromDir($root . $path);
    }
}

// Select a new random image
$img = getRandomFromArray($imgList);

// Store the selected image in the session
$_SESSION['selected_image'] = $img;
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tinycrap - Totally Random</title>
	<link rel="stylesheet" href="styles/tinycrap.min.css">
	<meta name="description" content="Random image loader. Try it for fun x1000!">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Tinycrap">
	<meta property="og:description" content="Fun basic fun loader of random images!">
	<meta property="og:url" content="https://www.tinycrap.com">
	<meta property="og:image" content="https://www.tinycrap.com/index.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta name="twitter:card" content="summary_large_image">
	<meta property="twitter:domain" content="tinycrap.com">
	<meta property="twitter:url" content="https://www.tinycrap.com/">
	<meta name="twitter:title" content="Tinycrap">
	<meta name="twitter:description" content="Fun basic fun random image loader.">
	<meta name="twitter:image" content="https://www.tinycrap.com/index.png">
	<link rel="icon" href="/icon.png" type="image/png">
	<link rel="icon" href="/icon.svg" type="image/svg+xml" sizes="any">
	<link rel="preload" href="fonts/PFArmaFive.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="fonts/JetBrainsMono-Bold.woff2" as="font" type="font/woff2" crossorigin>
	<script src="scripts/tinycrap.min.js" defer></script>
	<meta name="theme-color" content="#631bde">
</head>

<body>
	<div id="page">
		<section id="intro">
			<a id="logo--button" class="random--button">
				<svg version="1.1" id="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 312.6 49" style="enable-background:new 0 0 312.6 49;" xml:space="preserve">
					<g>
						<path d="M29.9,13.5l-3.7-5.8l-8.3,13.9l-8.5-4.9l8.2-14.2c0.7-1.2,1.2-2.3,2.6-2.4L30.2,0c1.4-0.2,2.8,0.6,3.8,1.8l3.6,5.6l2.8-1.7 l-2.3,12.5L27,15.1L29.9,13.5z"/>
						<path d="M12.6,29.3l-3.2,6l16.2,0.5l-0.2,9.9L9,45.3c-1.4,0-2.6,0-3.3-1.1l-4.9-8.8c-0.9-1.1-0.9-2.7-0.2-4.2l3.2-5.9l-2.8-1.6 l12-4.1L15.5,31L12.6,29.3z"/>
						<path d="M36.2,35.9l6.8-0.3l-7.9-14.2l8.6-4.9l8.2,14.3c0.7,1.2,1.4,2.2,0.8,3.4l-5,8.7c-0.5,1.3-1.9,2.1-3.5,2.4l-6.7,0.3l0,3.3 l-9.7-8.2l8.3-8.1V35.9z"/>
					</g>
					<g>
						<path d="M97.8,7.7v6.9h-9.2v26.6h-7.2V14.7H72V7.7H97.8z"/>
						<path d="M114.1,14.7v19.6h3.6v6.9h-14.4v-6.9h3.6V14.7h-3.6V7.7h14.5v6.9H114.1z"/>
						<path d="M144.3,14.7H133v26.6h-7.2V7.7h18.5V14.7z M144.3,41.2V14.7h7.2v26.6L144.3,41.2L144.3,41.2z"/>
						<path d="M183.6,7.7v33.5h-24.5v-6.9h17.2v-5.4h-10.8v-6.9h-7.2V7.7h7.2v14.2h10.8V7.7H183.6z"/>
						<path d="M198,34.3h16.8v6.9h-24.1V7.7h17.5v6.9H198L198,34.3L198,34.3z M208.2,21.7v-7h7.2v7H208.2z"/>
						<path d="M240.3,25.1v7h-10.8v9.1h-7.2V7.7h18v6.9h-10.8v10.4L240.3,25.1L240.3,25.1z M240.3,25.1V14.7h7.2v10.4H240.3z M240.3,41.2 v-9.1h7.2v9.1H240.3z"/>
						<path d="M279.6,14.7v26.6h-7.2v-9.1h-10.2v9.1h-7.2V7.7h17.5v6.9h-10.2v10.4h10.2V14.7H279.6z"/>
						<path d="M312.6,14.7v17.4h-18v9.1h-7.2V7.7h18v6.9h-10.8v10.4h10.8V14.7H312.6z"/>
					</g>
				</svg>
			</a>

			<header>
				<h1>A very large collection of random images/gifs</h1>
				<p class="is--visible">This website randomly loads funny, weird, creepy and just plain dumb images. They've been collected over a 16 year period, and they keep coming. Useless? you bet!</p>
				<p class="is--visible">Unique visits this month: <?php echo number_format($uniqueVisitorCount, 0, '.', '.'); ?></p>
			</header>

			<footer class="is--visible">
				<p>Note: WebP image format is way more efficient than JPEG. This website uses WebP exclusively. If you're having trouble viewing the images it's because you're using an ancient browser. Please upgrade.</p>
				<p>Visitor IP: <?php echo $ip; ?> - (© <?php echo date("Y"); ?> Made by <a target="_blank" href="https://twitter.com/jovenchurro">Andres</a>)</p>
			</footer>
		</section>

		<main>
			<div class="image--wrapper">
				<p>Click the image to load more...</p>
				<a id="image" class="random--button">
					<img id="random--image" alt="Totally Random Image" src="<?php echo $path . $img ?>">
				</a>
				<p id="emptyFolder__message"><?php echo $errorMessage; ?></p>
			</div>
		</main>
	</div>

	<script async src="https://www.googletagmanager.com/gtag/js?id=G-39CLJVGJNS"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-39CLJVGJNS');
	</script>
</body>
</html>