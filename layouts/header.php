<?php $host = '//' . $_SERVER['HTTP_HOST'] . '/'; 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> <?php echo $page_title; ?></title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $host; ?>includes/lib/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo $host; ?>includes/lib/css/bootstrap.min.css" />
    <!-- our custom CSS -->
    <link rel="stylesheet" href="<?php echo $host; ?>includes/lib/css/custom.css" />  
    <link rel="shortcut icon" href="<?php echo $host; ?>includes/lib/img/product-hunt-brands.svg" type="image/x-icon">
</head>

<body>

    <!-- container -->
    <div class="container">

        <?php
        // show page header
        echo "<div class='mt-5'>
				<h1>{$page_title}</h1>
			</div><hr class='hr mb-4 mt-4'>";
        ?>