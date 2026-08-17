<?php
    include __DIR__ . '/config.php';
    include __DIR__ . '/functions.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo htmlspecialchars(description, ENT_QUOTES, 'UTF-8'); ?>">
        <link rel="icon" href="<?php echo htmlspecialchars(favicon, ENT_QUOTES, 'UTF-8'); ?>">

        <title><?php echo htmlspecialchars(title, ENT_QUOTES, 'UTF-8'); ?></title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="/frontend/dist/styles.css">

        <?php if (defined('backgroundImage')) : ?>
            <style>
                body {
                    background: url(<?php echo htmlspecialchars(backgroundImage, ENT_QUOTES, 'UTF-8'); ?>) no-repeat center center fixed !important; 
                    background-size: cover !important;
                }
            </style>
        <?php else : ?>
            <style>
                body {
                    background-color: <?php echo htmlspecialchars(colour, ENT_QUOTES, 'UTF-8'); ?>;
                }
            </style>
        <?php endif; ?>

        <style>
            .btn-primary {
                background-color: <?php echo htmlspecialchars(colour, ENT_QUOTES, 'UTF-8'); ?>;
                border-color: <?php echo htmlspecialchars(colour, ENT_QUOTES, 'UTF-8'); ?>;
            }

            .btn-primary:hover,
            .btn-primary:focus,
            .btn-primary:active {
                background-color: <?php echo adjustBrightness(colour, -15); ?>;
                border-color: <?php echo adjustBrightness(colour, -15); ?>;
            }
        </style>
    </head>
