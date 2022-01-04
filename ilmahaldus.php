<?php
require("ilmafunktsion.php");
if(isSet($_REQUEST["maakonnanimilisamine"])){
    maakonnanimilisamine($_REQUEST["uuemakonnanimi"]);
    header("Location: ilmahaldus.php");
    exit();
}
if(isSet($_REQUEST["ilmalisamine"])){
    ilmalisamine($_REQUEST["temperatuur"], $_REQUEST["maakonnanimi"], $_REQUEST["maakonnakeskus"]);
    header("Location: ilmahaldus.php");
    exit();
}
if(isSet($_REQUEST["kustutusid"])){
    kustutusid($_REQUEST["kustutusid"]);
}
if(isSet($_REQUEST["muutmine"])){
    muutmine($_REQUEST["muudetudid"], $_REQUEST["temperatuur"],
        $_REQUEST["maakonnanimi"], $_REQUEST["maakonnakeskus"]);
}
$ilmad=ilmaAndmed();
?>
<!DOCTYPE html>

<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<form action="ilmahaldus.php">
    <h2>Kauba lisamine</h2>
    <dl>
        <dt>Nimetus:</dt>
        <dd><input type="text" name="temperatuur" /></dd>
        <dt>Kaubagrupp:</dt>
        <dd><?php
            echo looRippMenyy("SELECT id, maakonnanimi FROM maakondade",
                "maakonnanimi");
            ?>
        </dd>
        <dt>Hind:</dt>
        <dd><input type="text" name="maakonnakeskus" /></dd>
    </dl>
    <input type="submit" name="ilmalisamine" value="Lisa ilma" />
    <h2>Grupi lisamine</h2>
    <input type="text" name="uuemakonnanimi" />
    <input type="submit" name="maakonnanimilisamine" value="Lisa grupp" />
</form>
<form action="ilmahaldus.php">
    <h2>Kaupade loetelu</h2>
    <table>
        <tr>
            <th>Haldus</th>
            <th>Temperatuur</th>
            <th>Maakonnanimi</th>
            <th>Maakonnakeskus</th>
        </tr>
        <?php foreach($ilmad as $ilma): ?>
            <tr>
                <?php if(isSet($_REQUEST["muutmisid"]) &&
                    intval($_REQUEST["muutmisid"])==$ilma->id): ?>
                    <td>
                        <input type="submit" name="muutmine" value="Muuda" />
                        <input type="submit" name="katkestus" value="Katkesta" />
                        <input type="hidden" name="muudetudid" value="<?=$ilma->id ?>" />
                    </td>
                    <td><input type="text" name="temperatuur" value="<?=$ilma->temperatuur ?>" /></td>
                    <td><?php
                        echo looRippMenyy("SELECT id, maakonnanimi FROM maakondade",
                            "maakonnanimi", $ilma->maakonnanimi);
                        ?></td>
                    <td><input type="text" name="maakonnakeskus" value="<?=$ilma->maakonnakeskus ?>" /></td>
                <?php else: ?>
                    <td><a href="ilmahaldus.php?kustutusid=<?=$ilma->id ?>"
                           onclick="return confirm('Kas ikka soovid kustutada?')">x</a>
                        <a href="ilmahaldus.php?muutmisid=<?=$ilma->id ?>">m</a>
                    </td>
                    <td><?=$ilma->temperatuur ?></td>
                    <td><?=$ilma->maakonnanimi ?></td>
                    <td><?=$ilma->maakonnakeskus ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    </table>
</form>
</body>
</html>
