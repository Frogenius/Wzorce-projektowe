<?php

class User {
	
	protected $_username = "";
	
	public function __construct($username) {
		$this->_username = $username;
	}
	
	public function getProfilePage() {
		$profile  = "\n<h2>Wszedłeś do aplikacji muzycznej, podziel się swoimi upodobaniami </h2>\n";
		$profile .= "Ulubiony gatunek: ";
		$profile .= "{{myCD.getTytul}} </br>";
    $profile .= "Ulubiony zespol: ";
    $profile .= "{{myCD.getZespol}} </br> ";
    $profile .= "Ulubiona piosenka: ";
    $profile .= "{{myCD.getSong}} ";
		
		return $profile;
	}
}

class userCD {
	
	protected $_user = NULL;
	
	public function setUser(User $user) {
		$this->_user = $user;
	}
	
	public function getTytul() {
		$title = "Lubię różne rodzaje muzyki";
		
		return $title;
	}
  public function getZespol() {
		$title = "Morrissey";
		
		return $title;
	}
  public function getSong() {
		$title = "I Have Forgiven Jesus";
		
		return $title;
	}
}

class userCDInterpreter {
	
	protected $_user = NULL;
	
	public function setUser(User $user) {
		$this->_user = $user;
	}
	
	public function getInterpreted() {
		$profile = $this->_user->getProfilePage();
		
		if (preg_match_all('/\{\{myCD\.(.*?)\}\}/', $profile, $triggers, PREG_SET_ORDER)) {
			$replacements = array();
			
			foreach ($triggers as $trigger) {
				$replacements[] = $trigger[1];
			}
			
			$replacements = array_unique($replacements);
			
			$myCD = new userCD();
			$myCD->setUser($this->_user);
			
			foreach ($replacements as $replacement) {
				$profile = str_replace("{{myCD.{$replacement}}}", call_user_func(array($myCD, $replacement)), $profile);
			}
		}
		
		return $profile;
	}
	
}

$username = "Irina Frolova";
$user = new User($username);
$interpreter = new userCDInterpreter();
$interpreter->setUser($user);

print "<h1>Dzien dobry: {$username} </h1>";
print $interpreter->getInterpreted();