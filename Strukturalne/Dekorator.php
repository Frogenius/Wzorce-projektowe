<?php 

// Przepis na hamburgery    
class Hamburger      
{     
    public $bread  = 'Chleb';      
    public $cutlet = 'Kotlet'; 
    
    public $hamburger;    
  
    public function compile()     
    {      
        $this->hamburger[] = $this->bread;    
           
        $this->hamburger[] = $this->cutlet;    
         
        $this->hamburger[] = $this->bread;    
    }  

   
    public function create()   
    {   
        return implode('<br>', $this->hamburger);   
    }  
}     
 
class HamburgersDecorator    
{  
    protected $sandwich;  
    protected $ingredients = array();  
      
     
    public function __construct($sandwich)       
    {       
        $this->sandwich = $sandwich;  
    }   
      
    
    public function addIngridients($ingredients = array())       
    {   
        $this->ingredients = $ingredients;      
    }   
      
     
    public function compile()      
    {       
        $this->sandwich->hamburger[] = $this->sandwich->bread;     
          
        foreach  ($this->ingredients as $product) {      
            $this->sandwich->hamburger[] = $product;      
        }     
           
        $this->sandwich->hamburger[] = $this->sandwich->cutlet;      
        $this->sandwich->hamburger[] = $this->sandwich->bread;     
    }   
     
    public function __call($method, $args = '')       
    {   
        return $this->sandwich->$method($args);      
    }       
}     
     
    $hamburger = new HamburgersDecorator( new Hamburger() );  
    $hamburger->addIngridients(array('Pomidor', 'Sos','Ser', 'Ogorek'));  
    $hamburger->compile();  
    echo $hamburger->create(); 