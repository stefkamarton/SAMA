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
.btn:hover{
    background-color:var(--black);
}
</style>

<?php

require_once 'db.php';

$result = doQuery(array("sql" => "SELECT cards.uid AS 'Uid', cards.name AS 'name', cards.email AS 'email', cards.money AS 'money', COUNT(history.step) AS 'transaction_count' FROM history INNER JOIN cards ON history.uid = cards.uid GROUP BY cards.uid", "attr" => array()))->fetchAll(PDO::FETCH_ASSOC);
echo "<div class='table'>"
 .      "<div class='thead'>"
        .   "<div class='tr'>"
        .       "<div class='th'>Uid</div>"
        .       "<div class='th'>Név</div>"
        .       "<div class='th'>E-mail</div>"
        .       "<div class='th'>Jelenlegi egyenleg</div>"
        .       "<div class='th'>Tranzakciók száma</div>"
        .       "<div class='th'>#</div>"
        .   "</div>"
        . "</div>"
        . "<div class='tbody'>";
for($i=0;$i<count($result);$i++){
        echo "<div class='tr'>"
                . "<div class='td'>".$result[$i]['Uid']."</div>"
                . "<div class='td'>".$result[$i]['name']."</div>"
                . "<div class='td'>".$result[$i]['email']."</div>"
                . "<div class='td'>".$result[$i]['money']."</div>"
                . "<div class='td'>".$result[$i]['transaction_count']."</div>"
                . "<div class='td'><a class='btn' href='".getDomain()."/info.php?uid=".$result[$i]['Uid']."'>Részletek</a><a class='btn orange' href='".getDomain()."/edit.php?uid=".$result[$i]['Uid']."'>Módosítás</a></div>"
            . "</div>";

}
echo         "</div>"
    . "</div>";
?>



