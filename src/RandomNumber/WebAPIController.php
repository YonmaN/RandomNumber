<?php
namespace RandomNumber;

use ZendServer\Mvc\Controller\WebAPIActionController;

class WebAPIController extends WebAPIActionController {
	public function randomNumberAction() {
	    $random = new RandomNumber();
	    return array('random' => $random->random());
	}
}
