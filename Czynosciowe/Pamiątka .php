<?php

class Originator
{
   
    private $state;

    public function __construct(string $state)
    {
        $this->state = $state;
        echo "Pomysłodawca: Mój stan początkowy to: {$this->state} </br>";
    }

    public function doSomething(): void
    {
        echo "Pomysłodawca: Robię coś ważnego. </br>";
        $this->state = $this->generateRandomString(30);
        echo "Pomysłodawca: a mój stan zmienił się na: {$this->state} </br>";
    }

    private function generateRandomString(int $length = 10): string
    {
        return substr(
            str_shuffle(
                str_repeat(
                    $x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    ceil($length / strlen($x))
                )
            ),
            1,
            $length,
        );
    }

    
    public function save(): Memento
    {
        return new ConcreteMemento($this->state);
    }

   
    public function restore(Memento $memento): void
    {
        $this->state = $memento->getState();
        echo "Twórca: Mój stan zmienił się na: {$this->state} </br>";
    }
}

interface Memento
{
    public function getName(): string;

    public function getDate(): string;
}


class ConcreteMemento implements Memento
{
    private $state;

    private $date;

    public function __construct(string $state)
    {
        $this->state = $state;
        $this->date = date('Y-m-d H:i:s');
    }

    
    public function getState(): string
    {
        return $this->state;
    }

 
    public function getName(): string
    {
        return $this->date . " / (" . substr($this->state, 0, 9) . "...)";
    }

    public function getDate(): string
    {
        return $this->date;
    }
}


class Caretaker
{
   
    private $mementos = [];

    private $originator;

    public function __construct(Originator $originator)
    {
        $this->originator = $originator;
    }

    public function backup(): void
    {
        echo "</br> Opiekun: Ratowanie stanu Twórcy...</br>";
        $this->mementos[] = $this->originator->save();
    }

    public function undo(): void
    {
        if (!count($this->mementos)) {
            return;
        }
        $memento = array_pop($this->mementos);

        echo "Opiekun: Przywracanie stanu do: " . $memento->getName() . "</br>";
        try {
            $this->originator->restore($memento);
        } catch (\Exception $e) {
            $this->undo();
        }
    }

    public function showHistory(): void
    {
        echo "Opiekun: Oto lista pamiątek:</br>";
        foreach ($this->mementos as $memento) {
            echo $memento->getName() . "</br>";
        }
    }
}

$originator = new Originator("Super-puper-super-puper-super.");
$caretaker = new Caretaker($originator);

$caretaker->backup();
$originator->doSomething();

$caretaker->backup();
$originator->doSomething();

$caretaker->backup();
$originator->doSomething();

echo "</br>";
$caretaker->showHistory();

echo "</br>Klient: Teraz wycofajmy się!</br></br>";
$caretaker->undo();

echo "</br>Klient: Jeszcze raz! </br></br>";
$caretaker->undo();