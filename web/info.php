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
    h2{
        text-align: center;
        text-transform: uppercase;
        font-size: 1.6em;
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
    $result = doQuery(array("sql" => "SELECT cards.uid AS 'Uid', cards.money AS 'money', cards.name AS 'name', COUNT(history.step) AS 'darab',AVG(history.money) AS 'avgprice', MIN(history.money) AS 'minprice', MAX(history.money) AS 'maxprice', SUM(history.money) AS 'osszartermek', history.step AS 'termeknev' FROM cards INNER JOIN history ON history.uid = cards.uid WHERE cards.uid=:uid GROUP BY history.step", "attr" => array("uid" => $_GET['uid'])))->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo "<h2>Jelenleg még nem készíthető statisztika</h2>";
    } else {
        echo "<h2>" . $result[0]['name'] . "</h2>";
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['termeknev'] == "BUY_1" || $result[$i]['termeknev'] == "BUY_2" || $result[$i]['termeknev'] == "BUY_3") {
                $result[$i]['termeknev'] = str_replace("BUY_", "", $result[$i]['termeknev']);
                $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $result[$i]['termeknev'])))->fetch(PDO::FETCH_ASSOC);
                echo "<div class='table'><div class='tbody'>";
                echo "<div class='tr' style='background:black;'>"
                . "<div class='td'><b><u>Vásárolt termék:</u></b></div>"
                . "<div class='td'>" . $prod['name'] . "</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Vásárolt darab:</div>"
                . "<div class='td'>" . $result[$i]['darab'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Összesen elköltött pénz erre a termékre:</div>"
                . "<div class='td'>" . $result[$i]['osszartermek'] . " Ft</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Legdrágább vásárlási ár:</div>"
                . "<div class='td'>" . $result[$i]['maxprice'] . " Ft / db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Legolcsóbb vásárlási ár:</div>"
                . "<div class='td'>" . $result[$i]['minprice'] . " Ft / db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Átlag vásárlási ár:</div>"
                . "<div class='td'>" . $result[$i]['avgprice'] . " Ft / db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Jelenlegi vásárlási ár:</div>"
                . "<div class='td'>" . $prod['price'] . " Ft / db</div>"
                . "</div>";
                echo "</div></div>";
            }
            if ($result[$i]['termeknev'] == "UPLOAD_MONEY") {
                $result[$i]['termeknev'] = "Pénz feltöltés";
                $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $result[$i]['termeknev'])))->fetch(PDO::FETCH_ASSOC);
                echo "<div class='table'><div class='tbody'>";
                echo "<div class='tr' style='background:black;'>"
                . "<div class='td'><b><u>Pénz feltöltés:</u></b></div>"
                . "<div class='td'></div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Jelenlegi egyenleg:</div>"
                . "<div class='td'>" . $result[$i]['money'] . " Ft</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Összes pénz feltöltés:</div>"
                . "<div class='td'>" . $result[$i]['darab'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Összesen feltöltött pénz:</div>"
                . "<div class='td'>" . $result[$i]['osszartermek'] . " Ft</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Legnagyobb feltöltött összeg:</div>"
                . "<div class='td'>" . $result[$i]['maxprice'] . " Ft</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Legkisebb feltöltött összeg:</div>"
                . "<div class='td'>" . $result[$i]['minprice'] . " Ft</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Átlagosan feltöltött összeg:</div>"
                . "<div class='td'>" . $result[$i]['avgprice'] . " Ft</div>"
                . "</div>";
                echo "</div></div>";
            }
        }
    }
}
if (isset($_GET['pid'])) {
    $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $_GET['pid'])))->fetch(PDO::FETCH_ASSOC);
    $result = doQuery(array("sql" => "SELECT products.pid AS 'Pid', products.name AS 'name', prod_history.step AS 'lepes', MIN(prod_history.money) as 'minprice', MAX(prod_history.money) as 'maxprice', AVG(prod_history.money) as 'avgprice', COUNT(prod_history.step) as 'darab' FROM products INNER JOIN prod_history ON prod_history.pid = products.pid WHERE products.pid=:pid GROUP BY prod_history.step", "attr" => array("pid" => $_GET['pid'])))->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo "<h2>Jelenleg még nem készíthető statisztika</h2>";
    } else {
        echo "<h2>" . $result[0]['name'] . "</h2>";
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['lepes'] == "NEW_PRICE") {
                echo "<div class='table'><div class='tbody'>";
                echo "<div class='tr' style='background:black;'>"
                . "<div class='td'><b><u>Termék ár változás:</u></b></div>"
                . "<div class='td'></div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Jelenlegi ár:</div>"
                . "<div class='td'>" . $prod['price'] . " Ft / db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Összes árváltozás száma:</div>"
                . "<div class='td'>" . $result[$i]['darab'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Legmagasabb ár:</div>"
                . "<div class='td'>" . $result[$i]['maxprice'] . " Ft / db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Legalacsonyabb ár:</div>"
                . "<div class='td'>" . $result[$i]['minprice'] . " Ft / db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Átlagos ár:</div>"
                . "<div class='td'>" . $result[$i]['avgprice'] . " Ft / db</div>"
                . "</div>";
                echo "</div></div>";
            }
            if ($result[$i]['lepes'] == "NEW_COUNT") {
                echo "<div class='table'><div class='tbody'>";
                echo "<div class='tr' style='background:black;'>"
                . "<div class='td'><b><u>Termék készlet feltöltés:</u></b></div>"
                . "<div class='td'></div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Jelenlegi darabszám:</div>"
                . "<div class='td'>" . $prod['count'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Összes feltöltések száma:</div>"
                . "<div class='td'>" . $result[$i]['darab'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Minimum feltöltött darabszám:</div>"
                . "<div class='td'>" . $result[$i]['minprice'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Maximum feltöltött darabszám:</div>"
                . "<div class='td'>" . $result[$i]['maxprice'] . " db</div>"
                . "</div>";
                echo "<div class='tr'>"
                . "<div class='td'>Átlagosan feltöltött darabszám:</div>"
                . "<div class='td'>" . number_format($result[$i]['avgprice'], 2) . " db</div>"
                . "</div>";
                echo "</div></div>";
            }
        }
    }
}
?>



