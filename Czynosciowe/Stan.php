<?php

class Context
{
    private $stan;

    public function __construct(Stan $stan)
    {
        $this->transitionTo($stan);
    }

   
    public function transitionTo(Stan $stan): void
    {
        echo "Kontekst: przejście do " . get_class($stan) . "</br>";
        $this->stan = $stan;
        $this->stan->setContext($this);
    }

    public function request1(): void
    {
        $this->stan->handle1();
    }

    public function request2(): void
    {
        $this->stan->handle2();
    }
}


abstract class Stan
{
    
    protected $context;

    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    abstract public function handle1(): void;

    abstract public function handle2(): void;
}


class StanBetonuA extends Stan
{
    public function handle1(): void
    {
        echo "StanBetonuA obsługuje request1. </br>";
        echo "StanBetonuA chce zmienić stan kontekstu. </br>";
        $this->context->transitionTo(new StanBetonuB);
    }

    public function handle2(): void
    {
        echo "StanBetonuA obsługuje request2. </br>";
    }
}

class StanBetonuB extends Stan
{
    public function handle1(): void
    {
        echo "StanBetonuB obsluguje request1. </br>";
    }

    public function handle2(): void
    {
        echo "StanBetonuB obsługuje request2. </br>";
        echo "StanBetonuB chce zmienić stan kontekstu. </br>";
        $this->context->transitionTo(new StanBetonuA);
    }
}


$context = new Context(new StanBetonuA);
$context->request1();
$context->request2();