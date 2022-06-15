<?php
interface Wiadomosc
{
    public function wyslij(string $msg);
}

interface Push
{
    public function wyslij(string $msg);
}

interface WiadomoscFabryka
{
    public function stworzWiadomosc();

    public function stworzPush();
}

class FrogeniCloudWiadomosc implements Wiadomosc
{
    public function wyslij(string $msg)
    {
        return 'Wiadomosci w chmurze Frogeni wyslane pomyslnie! </br>
         Tresc wiadomosci: '.$msg;
    }
}

class FirmaJedenWiadomosc implements Wiadomosc
{
    public function wyslij(string $msg)
    {
        return '</br> Wiadomosci SMS B wyslane pomyslnie! </br>
                    Tresc wiadomosci: '.$msg;
    }
}

class FirmaDwaWiadomosc implements Wiadomosc
{
    public function wyslij(string $msg)
    {
        return ' </br> Wiadomosci SMS A wyslane pomyslnie! </br>
                    Tresc wiadomosci: '.$msg;
    }
}

class FrogeniCloudPush implements Push
{
    public function wyslij(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return '</br> Frogeni chmurza Android i iOS push wyslane pomyslnie! </br>
          Przeslij tresc: '.$msg;

    }
}

class FirmaJedenPush implements Push
{
    public function wyslij(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return '</br> Baidu Android & iOS cloud push wyslano pomyslnie! </br>
         Przeslij tresc: '.$msg;

    }
}

class FirmaDwaPush implements Push
{
    public function wyslij(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return '</br> Aurora push wyslano pomyslnie! </br>
         Przeslij tresc: '.$msg;

    }
}

class FrogeniCloudFabryka implements WiadomoscFabryka
{
    public function stworzWiadomosc()
    {
        return new FrogeniCloudWiadomosc();
    }

    public function stworzPush()
    {
        return new FrogeniCloudPush();
    }
}

class FirmaJedenFabryka implements WiadomoscFabryka
{
    public function stworzWiadomosc()
    {
        return new FirmaJedenWiadomosc();
    }

    public function stworzPush()
    {
        return new FirmaJedenPush();
    }
}

class FirmaDwaFabryka implements WiadomoscFabryka
{
    public function stworzWiadomosc()
    {
        return new FirmaDwaWiadomosc();
    }

    public function stworzPush()
    {
        return new FirmaDwaPush();
    }
}


$fabryka = new FrogeniCloudFabryka();
// $fabryka = new FirmaJedenFabryka();
// $fabryka = new FirmaDwaFabryka();
$wiadomosc = $fabryka->stworzWiadomosc();
$push = $fabryka->stworzPush();
echo $wiadomosc->wyslij('Dawno sie nie logowales,
                nie zapomnij wrocic!');
echo $push->wyslij('Otrzymales nowa czerwona koperte,
                Sprawdz to!');