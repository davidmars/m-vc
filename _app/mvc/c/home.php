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
            return $this->defaultView->run($this->data);
	}
    	public function view()
	{
            $this->data["title"]=$this->routeParams[0];
            return $this->defaultView->run($this->data);
	}
}

