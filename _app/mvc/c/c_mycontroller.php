<?php
class MycontrollerController extends Controller {
        /**
         * This is an example created for the doc.
         * @param string a parameter sent in url
         * @return \View 
         */
    	public function index()
	{
            $view=new View("new-template");
            return $view;
	}  
        /**
         * This is an example created for the doc.
         * @return \View 
         */
        public function write()
        {
            echo "This is my method write() speaking!";
            $view=new View("new-template",$param);
            return $view;
        }
        
        public function read($parameter1=null, $parameter2=null)
        {
            echo "This is my method read() speaking!<br />";
            echo "my first parameter is: ".$parameter1;
            echo "<br />my second parameter is: ".$parameter2;
            $view=new View("new-template");
            return $view;
        }
}
?>
