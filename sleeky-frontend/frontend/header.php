<?php
    include 'config.php';
    include 'functions.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-patible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo description ?>">
        <link rel="icon" href="<?php echo favicon ?>">

        <title><?php echo title ?></title>

        <link rel="stylesheet" href="<?php echo $YOURLS_SITE ?>/frontend/dist/styles.css">

        <?php if (defined('backgroundImage')) : ?>
            <style>
                body {
                    background: url(<?php echo backgroundImage ?>) no-repeat center center fixed !important; 
                    background-size: cover !important;
                }
            </style>
        <?php else : ?>
            <style>
                body {
                    background-color: <?php echo colour ?>;
                }
            </style>
        <?php endif; ?>

        <style>
            .btn-primary {
                background-color: <?php echo colour ?>;
                border-color: <?php echo colour ?>;
            }

            .btn-primary:hover,
            .btn-primary:focus,
            .btn-primary:active {
                background-color: <?php echo adjustBrightness(colour, -15) ?>;
                border-color: <?php echo adjustBrightness(colour, -15) ?>;
            }
        </style>
    </head>