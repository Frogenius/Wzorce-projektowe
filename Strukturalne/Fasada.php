<?php

class MaszynaDoKawy
{
    public function cappuccino()
    {
        return 'Cappuccino';
    }
	public function latte()
    {
        return 'Latte';
    }
}


class TV
{
    protected $kanaly = [
        1 => '1tv',
        2 => 'RenTv',
        3 => 'MatchTv'
    ];

    public function przelacznikKanalow($num)
    {
        return $this->kanaly[$num];
    }
}


class MasazerDoStop
{
    public function dodajZimnaWode()
    {
        return 'zimna Woda';
    }
    
    public function dodajGoracaWode()
    {
        return 'goraca woda';
    }
}

class SmartHouse
{
   

    public function __construct($MaszynaDoKawy, $TV, $MasazerDoStop)
    {
        $this->MaszynaDoKawy = $MaszynaDoKawy;
        $this->TV = $TV;
        $this->MasazerDoStop = $MasazerDoStop;
    }
    
    public function sweetHome()
    {   
        $cofee = $this->MaszynaDoKawy->latte();
        $football = $this->TV->przelacznikKanalow(3);
        $water = $this->MasazerDoStop->dodajGoracaWode();
        
        return '1.Wypic '. $cofee . '</br>'
              .'2.Ogladac '. $football . '</br>'
              .'3.Wlozyc stopy do masazera, gdzie '. $water;
    }
}


    $MaszynaDoKawy = new MaszynaDoKawy;
    $TV = new TV;
    $MasazerDoStop = new MasazerDoStop;
    

    $smartHouse = new SmartHouse($MaszynaDoKawy, $TV, $MasazerDoStop);
  
    echo $smartHouse->sweetHome();

 
