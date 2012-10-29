<?php

/**
 * This controller handle the admin models management.
 *
 * @author David Marsalone
 */
class C_admin_model extends Controller{

    /**
     * Display the login page.
     * @param bool $returnUrl
     * @return C_admin_model
     */
    public static function login($returnUrl=false){

        if($returnUrl){
            $c = new C_admin_model();
            return $c->url();
        }

        $c=new C_admin_model();
        POV_CssAndJs::adminSettings();
        $c->resultView=new View("admin/login");
        return $c;
    }

    /**
     * Will display a list of models of the given type.
     * @param string $modelType the model 
     * @return C_admin_model
     */
    public static function listModels($modelType,$returnUrl=false){

        if($returnUrl){
            $c = new C_admin_model();
            return $c->url();
        }
        //check if the user is logged in and is an admin
        if(!M_user::currentUser()->canWrite()){
            return self::login();
        }

	    $c=new C_admin_model();
        POV_CssAndJs::adminSettings();
        //unexisting model
        if(!class_exists($modelType)){
            $c->setHeader404();
            return $c;
        }
        //get the model class
        $vv=new VV_admin_model_list();
        $vv->init($modelType);
        $c->resultView=new View("admin/model-list", $vv);
        return $c;
    }
    /**
     * Will display a form to create or update a model.
     * @param string $modelType The type of the target model
     * @param string $modelId The id of the target model, if null an emty form of the requested model will be returned. 
     */
    public static function editModel($modelType,$modelId=null,$returnUrl=false){

        if($returnUrl){
            $c = new C_admin_model();
            return $c->url();
        }

        //check if the user is logged in and is an admin
        if(!M_user::currentUser()->canWrite()){
            return self::login();
        }
        
	    $c=new C_admin_model();
        POV_CssAndJs::adminSettings();
        //unexisting model
        if(!class_exists($modelType)){
            $c->setHeader404();
            return $c;
        }
        if($modelId && $modelType){
	    $manager = Manager::getManager($modelType);
	    $m=$manager->get($modelId);
	}else if(isset ($modelType) && class_exists($modelType) && in_array ("Model", class_parents($modelType))){
	    $m=new $modelType();
	}
	if($m){
            $vv=new VV_admin_model();
            $vv->init($m);
            $c->resultView=new View("admin/model-form",$vv);
	}
	return $c;
        
    }

    
    
}
