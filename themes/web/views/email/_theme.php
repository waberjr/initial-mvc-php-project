<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?= theme("/assets/styles". VERSION .".css") ?>"  media="screen,projection"/>
    <link rel="icon" href="<?= theme("/assets/images/dsaf.png") ?>" />
    <title><?= $title ?></title>
</head>
<body>
<table>
    <tr>
        <td>
            <div>
                <?= $v->section("content"); ?>
            </div>
        </td>
    </tr>
</table>
<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="<?= theme("/assets/scripts". VERSION .".js") ?>"></script>
<?= $v->section("scripts") ?>
<script>
    flash(<?= flash(); ?>);
</script>
</body>
</html>