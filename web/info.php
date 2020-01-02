<style>
    :root{
        --black:#1b1b1b;
        --light-black: #424242;
        --light-black2: #373737;
        --grey:#6d6d6d; 
        --light-grey:#c2c2c2;
        --white:#eeeeee;
        --light-white:#fff;
        --red:#c50a1d;
        --orange:#ffca28;
        --blue:#42a5f5;
        --green:#8bc34a;

    }
    .table{
        line-height: 2em;
        display:table;
        width:90%;
        margin:20px auto;
        border-radius: 3px;
        background:var(--black);
        color: var(--white);
        text-align: center;
    }
    .thead{
        display:table-row-group;
        font-weight: bold;
        border-bottom: 2px solid var(--light-black2);
    }
    .tbody{
        display:table-row-group;
    }
    .tr{
        display:table-row;
        background-color: var(--light-black2);
        transition: .3s all linear;
    }
    .tbody .tr:nth-child(2n+1){
        background-color: var(--light-black);
    }
    .td, .th{
        display: table-cell;
    }
    .td{
        vertical-align: middle;
        padding:20px 15px;
    }
    .th{
        padding:15px;    
    }
    .btn{
        text-decoration: none;
        color:var(--white);
        padding:10px 10px;
        margin:10px 5px;
        display:block;
        border-radius: 3px;
        background-color:var(--blue);
        transition: .3s all linear;
        cursor:pointer;
        white-space: nowrap;
        text-align: center;
        font-weight: 700;
    }
    .btn.orange{
        background-color:var(--orange);
    }
    .btn.red{
        background-color:var(--red);
    }
    .btn:hover{
        background-color:var(--black);
    }
    input, select, textarea{
        padding:10px 10px;
        font-family: 'Open Sans', sans-serif;
        border:1px solid transparent;
        transition: .3s all linear;
        border-radius: 3px;
        margin:10px 15px;
        color:var(--white);
        background-color:var(--black);
    }
    input:disabled, input:read-only, textarea:disabled, textarea:read-only, select:disabled{
        background:repeating-linear-gradient(45deg,var(--black),var(--black) 10px,var(--red) 10px,var(--red) 20px);
        font-weight: 700;
    }
    input:disabled, input:-moz-read-only, textarea:disabled, textarea:-moz-read-only, select:disabled{
        background:repeating-linear-gradient(45deg,var(--black),var(--black) 10px,var(--red) 10px,var(--red) 20px);
        font-weight: 700;
    }
    input:focus, textarea:focus, select:focus{
        border:1px solid var(--red);
    }
</style>

<?php
require_once 'db.php';

echo "<a href='" . getDomain() . "/list.php" . "' style='max-width:200px;' class='btn red'>Vissza</a>";
if (isset($_GET['uid'])) {
    $result = doQuery(array("sql" => "SELECT cards.uid AS 'Uid', cards.name AS 'name', COUNT(history.step) AS 'darab',AVG(history.money) AS 'avgprice', MIN(history.money) AS 'minprice', MAX(history.money) AS 'maxprice', SUM(history.money) AS 'osszartermek', history.step AS 'termeknev' FROM cards INNER JOIN history ON history.uid = cards.uid WHERE cards.uid=:uid GROUP BY history.step", "attr" => array("uid" => $_GET['uid'])))->fetchAll(PDO::FETCH_ASSOC);
    echo "<div class='table'>"
    . "<form action='' method='post' class='tbody'>"
    . "<div class='tr'>"
    . "<div class='td'>Vásárlási statisztika:</div>"
    . "<div class='td'>" . $result[0]['name'] . "</div>"
    . " </div>";
    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]['termeknev'] == "BUY_1" || $result[$i]['termeknev'] == "BUY_2" || $result[$i]['termeknev'] == "BUY_3") {
            $result[$i]['termeknev'] = str_replace("BUY_", "", $result[$i]['termeknev']);
            $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $result[$i]['termeknev'])))->fetch(PDO::FETCH_ASSOC);
            echo "<div class='tr'>"
            . "<div class='td'><b><u>Termék:</u></b><br>Vásárolt darab:<br>Összesen elköltött pénz erre a termékre:<br>Legdrágább vásárlási ár:<br>Legolcsóbb vásárlási ár:<br>Átlag vásárlási ár:<br>Jelenlegi ár:</div>"
            . "<div class='td'>" . $prod['name'] . "<br>" . $result[$i]['darab'] . " db<br>" . $result[$i]['osszartermek'] . " Ft<br>" . $result[$i]['maxprice'] . " Ft / db<br>" . $result[$i]['minprice'] . " Ft / db<br>" . $result[$i]['avgprice'] . " Ft / db<br>" . $prod['price'] . " Ft / db</div>"
            . " </div>";
        }
        if ($result[$i]['termeknev'] == "UPLOAD_MONEY") {
            $result[$i]['termeknev'] = "Pénz feltöltés";
            $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $result[$i]['termeknev'])))->fetch(PDO::FETCH_ASSOC);
            echo "<div class='tr'>"
            . "<div class='td'><b><u>Pénz feltöltés:</u></b><br>Összes pénz feltöltés:<br>Összesen feltöltött pénz:<br>Legnagyobb feltöltött összeg:<br>Legkisebb feltöltött összeg:<br>Átlagosan feltöltött összeg:</div>"
            . "<div class='td'>" . $prod['name'] . "<br>" . $result[$i]['darab'] . " db<br>" . $result[$i]['osszartermek'] . " Ft<br>" . $result[$i]['maxprice'] . " Ft<br>" . $result[$i]['minprice'] . " Ft<br>" . $result[$i]['avgprice'] . " Ft</div>"
            . " </div>";
        }
    }

    echo "</form></div>";
}
if (isset($_GET['pid'])) {
    $result = doQuery(array("sql" => "SELECT products.pid AS 'Pid', products.name AS 'name' FROM products WHERE products.pid=:pid", "attr" => array("pid" => $_GET['pid'])))->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    echo "<div class='table'>"
    . "<form action='' method='post' class='tbody'>"
    . "<div class='tr'>"
    . "<div class='td'>Vásárlási statisztika:</div>"
    . "<div class='td'>" . $result[0]['name'] . "</div>"
    . " </div>";
    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]['termeknev'] == "BUY_1" || $result[$i]['termeknev'] == "BUY_2" || $result[$i]['termeknev'] == "BUY_3") {
            $result[$i]['termeknev'] = str_replace("BUY_", "", $result[$i]['termeknev']);
            $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $result[$i]['termeknev'])))->fetch(PDO::FETCH_ASSOC);
            echo "<div class='tr'>"
            . "<div class='td'><b><u>Termék:</u></b><br>Vásárolt darab:<br>Összesen elköltött pénz erre a termékre:<br>Legdrágább vásárlási ár:<br>Legolcsóbb vásárlási ár:<br>Átlag vásárlási ár:<br>Jelenlegi ár:</div>"
            . "<div class='td'>" . $prod['name'] . "<br>" . $result[$i]['darab'] . " db<br>" . $result[$i]['osszartermek'] . " Ft<br>" . $result[$i]['maxprice'] . " Ft / db<br>" . $result[$i]['minprice'] . " Ft / db<br>" . $result[$i]['avgprice'] . " Ft / db<br>" . $prod['price'] . " Ft / db</div>"
            . " </div>";
        }
        if ($result[$i]['termeknev'] == "UPLOAD_MONEY") {
            $result[$i]['termeknev'] = "Pénz feltöltés";
            $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $result[$i]['termeknev'])))->fetch(PDO::FETCH_ASSOC);
            echo "<div class='tr'>"
            . "<div class='td'><b><u>Pénz feltöltés:</u></b><br>Összes pénz feltöltés:<br>Összesen feltöltött pénz:<br>Legnagyobb feltöltött összeg:<br>Legkisebb feltöltött összeg:<br>Átlagosan feltöltött összeg:</div>"
            . "<div class='td'>" . $prod['name'] . "<br>" . $result[$i]['darab'] . " db<br>" . $result[$i]['osszartermek'] . " Ft<br>" . $result[$i]['maxprice'] . " Ft<br>" . $result[$i]['minprice'] . " Ft<br>" . $result[$i]['avgprice'] . " Ft</div>"
            . " </div>";
        }
    }

    echo "</form></div>";
}
?>



