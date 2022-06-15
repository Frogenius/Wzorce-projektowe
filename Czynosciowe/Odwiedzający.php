<?php

abstract class Customer {
    protected $customerId;

    protected $customerName;
    public abstract function accept( ServiceRequestVisitor $visitor );
}

class EnterpriseCustomer extends Customer {
    public function accept( ServiceRequestVisitor $visitor ) {
        $visitor->visitEnerpriseCustomer($this);
    } 
}

class PersonalCustomer extends Customer {
    public function accept( ServiceRequestVisitor $visitor ) {
        $visitor->visitPersonalCustomer($this);
    }
}

interface Visitor {
    public function visitEnerpriseCustomer( EnterpriseCustomer $ec );
    public function visitPersonalCustomer( PersonalCustomer $pc );
}


class ServiceRequestVisitor implements Visitor {
   
    public function visitEnerpriseCustomer( EnterpriseCustomer $ec ) {
        echo $ec->name."Zapytania biznesowe o usługi </br>";
    }

    
    public function visitPersonalCustomer( PersonalCustomer $pc ) {
        echo 'Klient: '.$pc->name." Złóż wniosek. </br> "; 
    }
}


class ObjectStructure {
    private $obj = array(); 
    public function addElement( $ele ) {
        array_push($this->obj, $ele); 
    }


    public function handleRequest( Visitor $visitor ) {
      
        foreach( $this->obj as $ele ) {
            $ele->accept( $visitor );
        } 
    }
}

header('Content-Type: text/html; charset=utf-8');

$os = new ObjectStructure();

$ele1 = new EnterpriseCustomer();
$ele1->name = 'Grupa ABC </br>';
$os->addElement( $ele1 );

$ele2 = new EnterpriseCustomer();
$ele2->name = 'Grupa DEF </br>';
$os->addElement( $ele2 );

$ele3 = new PersonalCustomer();
$ele3->name = 'Irina Frolova </br>';
$os->addElement( $ele3 );


$serviceVisitor = new ServiceRequestVisitor();
$os->handleRequest( $serviceVisitor );