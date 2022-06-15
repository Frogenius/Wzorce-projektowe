<?php


abstract class PrototypKsiazki {
    protected $title;
    protected $topic;
    abstract function __clone();
    function getTitle() {
        return $this->title;
    }
    function setTitle($titleIn) {
        $this->title = $titleIn;
    }
    function getTopic() {
        return $this->topic;
    }
}
 

class PHPPrototypKsiazki extends PrototypKsiazki {
    function __construct() {
        $this->topic = 'PHP a programowanie obiektowe';
    }
    function __clone() { 
    }
}

class SQLPrototypKsiazki extends PrototypKsiazki {
    function __construct() {
        $this->topic = 'podstawy wiedzy o relacyjnych bazach danych, ich rodzajach oraz o jezyku SQL';
    }
    function __clone() { 
    }
}
  
  writeln('WZORZEC PROTOTYP NA PRZYKLADZIE KOPIOWANIA KSIAZEK');
  writeln('');
 
  $phpProto = new PHPPrototypKsiazki();
  $sqlProto = new SQLPrototypKsiazki();
 
/*Klonowanie obiektu książki SQL*/
  $book1 = clone $sqlProto;
  $book1->setTitle('Pierwsze kroki z SQL. Praktyczne podejscie dla poczatkujacych');
  writeln('Temat ksiazki 1: '.$book1->getTopic());
  writeln('Tytul ksiazki 1: '.$book1->getTitle());
  writeln('');
 
/*Klonowanie obiektu książki PHP*/
  $book2 = clone $phpProto;
  $book2->setTitle('PHP. Wzorce Projektowe'); 
  writeln('Temat ksiazki 2: '.$book2->getTopic());  
  writeln('Tytul ksiazki 2: '.$book2->getTitle());
  writeln('');
 
  $book3 = clone $sqlProto;
  $book3->setTitle('Nauka SQL'); 
  writeln('Temat ksiazki 3: '.$book3->getTopic());
  writeln('Tytul ksiazki 3: '.$book3->getTitle());
  writeln('');
  
    $book4 = clone $phpProto;
  $book4->setTitle('Nauka PHP'); 
  writeln('Temat ksiazki 4: '.$book4->getTopic());
  writeln('Tytul ksiazki 4: '.$book4->getTitle());
  writeln('');
 
  writeln('KONIEC');
 
  function writeln($line_in) {
    echo $line_in."<br/>";
  }
 
?>