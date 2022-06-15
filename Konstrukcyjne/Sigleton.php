<?php
class Db
{
	private static $db=null;
	
	public function conect()
	{
		if (self::$db===null)
		{
			self::$db=new self();
			echo "POŁĄCZENIE...<br>\n";
		}
		else
		{
			echo "ŁĄCZENIE W TOKU, PROSZĘ CZEKAĆ<br>\n";
		}
		
		return self::$db;
	}

	public function f1()
	{
		echo "Przepraszamy, uruchom ponownie komputer, masz wirusa na swoim urządzeniu<br>\n";
    
	}

	private function __construct() {}
	private function __clone() {}    
	private function __wakeup() {}   
}

$ob=Db::conect();
Db::conect();
Db::conect();
Db::conect();
Db::conect();
Db::conect();
$ob->f1();   


?>