<?php

/**
 * Description of francois
 *
 * @author francoisrai
 */
class FrancoisController extends Controller {

    /**
     * Control the routes matching this-file-path/francois/index/my-first-param/my-second-param.
     * This controller should display a beautiful page. 
     * @param $urlParam1 string Describe it!!!
     * @param $urlParam2 string Describe it!!!
     * @return View 
     */
    public function index($urlParam1=null, $urlParam2=null) {

        //Create the view variables object...for sure use an extended Class of ViewVariables to get it clean.
        $vv = new ViewVariables();
        //add variables in anarchy cause I'm lazy.
        $vv->anarchy["variableInTheView1"] = $urlParam1;
        $vv->anarchy["variableInTheView2"] = $urlParam2;

        return new View("your/path/to/the/view-file", $vv);
    }

}