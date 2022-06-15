<?php

class CD {
	
	public $band  = '';
	public $title = '';
	protected $_mediator;
	
	public function __construct(MusicContainerMediator $mediator = NULL) {
		$this->_mediator = $mediator;
	}
	
	public function save() {
		// konkretna implementacja do ustalenia
		var_dump($this);
	}
	
	public function changeBandName($bandname) {
		if ( ! is_null($this->_mediator)) {
			$this->_mediator->change($this, array("band" => $bandname));
		}
		$this->band = $bandname;
		$this->save();
	}
}

//MP3Archive
class MP3Archive {
	
	protected $_mediator;
	
	public function __construct(MusicContainerMediator $mediator = NULL) {
		$this->_mediator = $mediator;
	}
	
	public function save() {
		
		var_dump($this);
	}
	
	public function changeBandName($bandname) {
		if ( ! is_null($this->_mediator)) {
			$this->_mediator->change($this, array("band" => $bandname));
		}
		$this->band = $bandname;
		$this->save();
	}
}

class MusicContainerMediator {
	
	protected $_containers = array();
	
	public function __construct() {
		$this->_containers[] = "CD";
		$this->_containers[] = "MP3Archive";
	}
	
	public function change($originalObject, $newValue) {
		$title = $originalObject->title;
		$band  = $originalObject->band;
		
		foreach ($this->_containers as $container) {
			if ( ! ($originalObject instanceof $container)) {
				$object = new $container;
				$object->title = $title;
				$object->band  = $band;
				
				foreach ($newValue as $key => $val) {
					$object->$key = $val;
				}
				
				$object->save();
			}
		}
	}
}


$titleFromDB = "</br> Waste of a Rib ";
$bandFromDB  = "</br> Never Again ";

$mediator = new MusicContainerMediator();

$cd = new CD($mediator);
$cd->title = $titleFromDB;
$cd->band  = $bandFromDB;

$cd->changeBandName("</br>Maybe Once More");