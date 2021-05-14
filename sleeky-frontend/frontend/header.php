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

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400|Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo siteURL ?>/frontend/assets/css/base.css">
    <link rel="stylesheet" href="<?php echo siteURL ?>/frontend/assets/css/mobile.css">
    <link rel="stylesheet" href="<?php echo siteURL ?>/frontend/assets/css/tablet.css">
    <link rel="stylesheet" href="<?php echo siteURL ?>/frontend/assets/css/desktop.css">

    <?php if (defined('backgroundImage')) : ?>
      <style>
        body,
        .success-screen {
          background: url(<?php echo backgroundImage ?>) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      </style>
    <?php elseif (defined('colour')) : ?>
      <style>
        body {
          background-color: <?php echo colour ?>;
        }

        input[type="submit"],
        .short-url-button {
          background-color: <?php echo colour ?>;
        }

        input[type="submit"]:hover,
        .short-url-button:hover {
          background-color: <?php echo adjustBrightness(colour, -15) ?>;
        }

        .success-screen {
          background-color: <?php echo colour ?>;
        }
      </style>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js" integrity="sha512-sIqUEnRn31BgngPmHt2JenzleDDsXwYO+iyvQ46Mw6RL+udAUZj2n/u/PGY80NxRxynO7R9xIGx5LEzw4INWJQ==" crossorigin="anonymous"></script>

    <!-- Add extra support of older browsers -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" integrity="sha512-xay60hbqdH7N5W+TBcPxupebVU7o/2G5j+cDkLNS2CSbzJ2+vbzlBP6PqF3ZHTTFDfAWFfmOz93/N8YJ5YkhjA==" crossorigin="anonymous"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" integrity="sha512-IvQusQF5BtnzHhcWCL3w+ItYY6fn+g4bo24AyKlQa7FxpE8A41kIX4xmC+H67jbKFcmiLtgwX3UBnF9t+4oO3A==" crossorigin="anonymous"></script>
    <![endif]-->

  </head>

 
