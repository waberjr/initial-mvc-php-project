<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?= theme("/assets/boot-styles/ajax-load.css") ?>"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="<?= theme("/assets/styles/styles". SCRIPT_VERSION .".css") ?>"  media="screen,projection"/>
    <link rel="icon" href="<?= theme("/assets/images/favicon.png") ?>" />
    <title><?= $title ?></title>
</head>
<body>
    <!-- Ajax Load -->
    <div class="ajax_load"></div>

    <!-- Content -->
    <div class="">
        <?= $v->section("content") ?>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="<?= theme("/assets/boot-scripts/jquery-3.2.1.js") ?>"></script>
    <script type="text/javascript" src="<?= theme("/assets/scripts/scripts". SCRIPT_VERSION .".js") ?>"></script>
    
    <?= $v->section("scripts") ?>

    <script>
        flash(<?= flash(); ?>);
    </script>
</body>
</html>