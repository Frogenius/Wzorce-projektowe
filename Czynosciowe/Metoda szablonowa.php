<?php

abstract class TemplateBase
{
    public function Method1()
    {
        echo"abstract Method1 </br>";
    }

    public function Method2()
    {
        echo"abstract Method2 </br>";
    }

    public function Method3()
    {
        echo"abstract Method3 </br>";
    }

    public function doSomeThing()
    {
        $this->Method1();
        $this->Method2();
        $this->Method3();
    }
}

class TemplateObject extends TemplateBase
{
}

class TemplateObject1 extends TemplateBase
{
    public function Method3()
    {
        echo"TemplateObject1 Method3 </br>";
    }
}

class TemplateObject2 extends TemplateBase
{
    public function Method2()
    {
        echo"TemplateObject2 Method2 </br>";
    }
}


$objTemplate=new TemplateObject();
$objTemplate1=new TemplateObject1();
$objTemplate2=new TemplateObject2();

$objTemplate->doSomeThing();
$objTemplate1->doSomeThing();
$objTemplate2->doSomeThing();