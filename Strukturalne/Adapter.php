<?php
interface Payments {
    function payment ( $p );
}

class File implements Payments {
    function payment ( $p ){
        echo "Produkt sprzedawany w zwykłej implementacji interfejsu $p\n<br>";
    }
}

class YandexPayments {
    function yandexPay ( $p ){
        echo "Produkt sprzedawany w ulepszonej implementacji  $p\n<br>";
    }
}

class Adapter implements Payments {
    private $pay = null ; 
    function __construct( YandexPayments $ypay){
        $this->pay = $ypay;
    }
    function payment ($p){
        $this->pay->yandexPay($p);
    }
}

$file = new File();
$yandexPayments = new YandexPayments();
$file2 = new Adapter ($yandexPayments ); 

function testPayments(Payments $p){
    $p->payment( 100 );
}

testPayments($file);
testPayments($file2);