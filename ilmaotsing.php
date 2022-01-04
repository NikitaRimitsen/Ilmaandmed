<?php
require("ilmafunktsion.php");
$ilmad=ilmaAndmed();
?>
<!Doctype html>
<html lang="et">
<head>
    <title>Ilma andmed leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<table>
    <tr>
        <th>Temperatuur</th>
        <th>Kuupaev_kellaaeg</th>
        <th>Maakonnanimi</th>
        <th>Maakonnakeskus</th>
    </tr>
    <?php foreach($ilmad as $ilma): ?>
        <tr>
            <td><?=$ilma->temperatuur ?></td>
            <td><?=$ilma->kuupaev_kellaaeg ?></td>
            <td><?=$ilma->maakonnanimi ?></td>
            <td><?=$ilma->maakonnakeskus ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
