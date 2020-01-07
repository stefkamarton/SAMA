<?php
require_once 'db.php';
$result = doQuery(array("sql" => "SELECT * FROM cards WHERE uid=:uid ", "attr" => array("uid" => $_GET['uid'])))->fetch(PDO::FETCH_ASSOC);
if (empty($result)) {
    if (!empty($_GET['uid'])) {
        if (doQuery(array("sql" => "INSERT INTO cards (uid,name,email,money) VALUES (:uid,:name,'',:money)", "attr" => array("uid" => $_GET['uid'], "name" => "New Buyer", "money" => "0")))) {
            if (doQuery(array("sql" => "INSERT INTO history (uid,step,money) VALUES (:uid,:step,:money)", "attr" => array("uid" => $_GET['uid'], "step" => "NEW_BUYER", "money" => "0")))) {
                header('HTTP/1.1 401 Unauthorized');
            }
        }
    }
} else {
    if (!empty($_GET['uid']) && !empty($_GET['product'])) {
        $prod = doQuery(array("sql" => "SELECT * FROM products WHERE pid=:pid", "attr" => array("pid" => $_GET['product'])))->fetch(PDO::FETCH_ASSOC);
        if ($result['money'] - $prod['price'] >= 0) {
            if ($prod['count'] - 1 >= 0) {
                doQuery(array("sql" => "UPDATE products SET count=:count WHERE pid=:pid", "attr" => array("pid" => $_GET['product'], "count" => ($prod['count'] - 1))));
                doQuery(array("sql" => "UPDATE cards SET money=:money WHERE uid=:uid", "attr" => array("uid" => $_GET['uid'], "money" => ($result['money'] - $prod['price']))));
                doQuery(array("sql" => "INSERT INTO history (uid,step,money) VALUES (:uid,:step,:money)", "attr" => array("uid" => $_GET['uid'], "step" => "BUY_" . $_GET['product'], "money" => $prod['price'])));
            } else {
                //elfogyott
                mail("stefkamarton14@gmail.com","Elfogyott az űdítő","FIGYELEM elfogyott az alábbi űdítő: ".$prod['name']);
                header('HTTP/1.1 404 Not Found');
                doQuery(array("sql" => "INSERT INTO history (uid,step,money) VALUES (:uid,:step,:money)", "attr" => array("uid" => $_GET['uid'], "step" => "NO_DRINK", "money" => $prod['price'])));
            }
        } else {
            mail($result['email'],"Fizetési probléma","FIGYELEM nincs elég pénzed az alábbi űdítő: ".$prod['name']." megvásárlásához. Egyenleged:".$result['money']);
            header('HTTP/1.1 403 Forbidden');
            doQuery(array("sql" => "INSERT INTO history (uid,step,money) VALUES (:uid,:step,:money)", "attr" => array("uid" => $_GET['uid'], "step" => "NO_MONEY", "money" => $prod['price'])));
        }
    }
}
?> 