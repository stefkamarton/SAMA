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

echo "<a href='".getDomain()."/list.php"."' style='max-width:200px;' class='btn red'>Vissza</a>";
if (isset($_GET['uid'])) {
    $result = doQuery(array("sql" => "SELECT cards.uid AS 'Uid', cards.name AS 'name', cards.email AS 'email', cards.money AS 'money' FROM cards WHERE uid=:uid", "attr" => array("uid" => $_GET['uid'])))->fetch(PDO::FETCH_ASSOC);
    echo "<div class='table'>"
    . "<form action='' method='post' class='tbody'>"
    . "<div class='tr'>"
    . "<div class='td'>Uid:</div>"
    . "<div class='td'><input value='" . $result['Uid'] . "' readOnly required /></div>"
    . " </div><div class='tr'>"
    . "<div class='td'>Név:</div>"
    . "<div class='td'><input type='text' name='name' value='" . $result['name'] . "' required/></div>"
    . " </div><div class='tr'>"
    . "<div class='td'>E-mail:</div>"
    . "<div class='td'><input type='email' name='email' value='" . $result['email'] . "' required /></div>"
    . " </div><div class='tr'>"
    . "<div class='td'>Jelenlegi egyenleg:</div>"
    . "<div class='td'><input type='number' name='money' value='" . $result['money'] . "' required /></div>"
    . " </div><div class='tr'>"
    . "<div class='td'></div>"
    . "<div class='td'><button name='save' style='display:block;width:100%;' class='btn red'>Mentés</button></div>"
    . " </div>"
    . "</form></div>";
}
if (isset($_POST['save'])) {
    if (!empty($_POST['name']) && !empty($_POST['money']) && !empty($_POST['email'])) {
        if (doQuery(array("sql" => "UPDATE cards SET money=:money, name=:name, email=:email WHERE uid=:uid", "attr" => array("uid" => $_GET['uid'], "money" => $_POST['money'], "name" => $_POST['name'], "email" => $_POST['email'])))) {
            echo "<script>alert('Sikeres módosítás!')</script>";
        } else {
            echo "<script>alert('Sikertelen módosítás! SQL hiba')</script>";
        }
    }
    header("REFRESH:0");
}
?>



