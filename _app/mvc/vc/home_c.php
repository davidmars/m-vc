<?php

/**
 * Description of home
 *
 * @author david marsalone
 */
class HomeControler extends Controler {
    
    	public function index()
	{
            $this->data["title"]="home page";
            $this->defaultView->run($this->$data);
	}
}

