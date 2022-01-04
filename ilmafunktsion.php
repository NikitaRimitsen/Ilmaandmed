<?php
$yhendus=new mysqli("localhost", "nikitarim", "123456", "nikitarim");

function ilmaAndmed(){
    global $yhendus;
    $kask=$yhendus->prepare("SELECT ilmatemperatuuri.id, temperatuur, kuupaev_kellaaeg, maakonnanimi, maakonnakeskus
 FROM ilmatemperatuuri, maakondade
 WHERE ilmatemperatuuri.maakonna_id=maakondade.id;
");
    //echo $yhendus->error;
    $kask->bind_result($id, $temperatuur, $kuupaev_kellaaeg, $maakonnanimi, $maakonnakeskus);
    $kask->execute();
    $hoidla=array();
    while($kask->fetch()){
        $ilma=new stdClass();
        $ilma->id=$id;
        $ilma->temperatuur= $temperatuur;
        $ilma->kuupaev_kellaaeg=htmlspecialchars($kuupaev_kellaaeg);
        $ilma->maakonnanimi=htmlspecialchars($maakonnanimi);
        $ilma->maakonnakeskus=htmlspecialchars($maakonnakeskus);
        array_push($hoidla, $ilma);
    }
    return $hoidla;
}



function looRippMenyy($sqllause, $valikunimi, $valitudid=""){
    global $yhendus;
    $kask=$yhendus->prepare($sqllause);
    $kask->bind_result($id, $sisu);
    $kask->execute();
    $tulemus="<select name='$valikunimi'>";
    while($kask->fetch()){
        $lisand="";
        if($id==$valitudid){$lisand=" selected='selected'";}
        $tulemus.="<option value='$id' $lisand >$sisu</option>";
    }
    $tulemus.="</select>";
    return $tulemus;
}

function maakonnanimilisamine($grupinimi){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO maakondade (maakonnanimi)
                      VALUES (?)");
    $kask->bind_param("s", $grupinimi);
    $kask->execute();
}

function ilmalisamine($nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO
       kaubad (nimetus, kaubagrupi_id, hind)
       VALUES (?, ?, ?)");
    $kask->bind_param("sid", $nimetus, $kaubagrupi_id, $hind);
    $kask->execute();
}

function kustutusid($kauba_id){
    global $yhendus;
    $kask=$yhendus->prepare("DELETE FROM kaubad WHERE id=?");
    $kask->bind_param("i", $kauba_id);
    $kask->execute();
}

function muutmine($kauba_id, $nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE kaubad SET nimetus=?, kaubagrupi_id=?, hind=?
                      WHERE id=?");
    $kask->bind_param("sidi", $nimetus, $kaubagrupi_id, $hind, $kauba_id);
    $kask->execute();
}
