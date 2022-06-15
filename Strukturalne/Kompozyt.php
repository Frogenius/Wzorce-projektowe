<?php 

class EkspresDoKawy 
{ 
    public function get() 
    { 
        return 'kawa'; 
    } 
} 

class EkspresDoKremu
{ 
    public function get() 
    { 
        return 'krem'; 
    } 
} 

class EkspresDoLody 
{ 
    public function __construct()
    {
        $hydraulika = new Hydraulika;
        $this->woda = $hydraulika->get();
    }
 
    public function get() 
    { 
        return $this->zamrazarka(); 
    } 
    
    protected function zamrazarka() 
    { 
        return str_replace('woda', 'lod', $this->woda); 
    } 
} 


class Hydraulika 
{ 
    public function get() 
    { 
        return 'woda'; 
    } 
} 

class MaszynaDoKawy  
{ 
    protected $units = [];

    public function add($ingredient) 
    {   
        $this->units[] = $ingredient;
    }    
 
    public function getCoffe() 
    { 
        $skladniki = [];
       
        foreach ($this->units as $ingredient) { 
            $skladniki[] = $ingredient->get();
        }
        
        return implode(' + ', $skladniki); 
    } 
} 


$mashin = new MaszynaDoKawy;
$mashin->add(new EkspresDoKawy);
$mashin->add(new EkspresDoKremu);
$mashin->add(new EkspresDoLody);

echo $mashin->getCoffe();