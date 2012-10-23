<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class M_block extends M_ {

    /**
     *
     * @var TextField the model type named  
     */
    public $modelType;
    
    /**
     *
     * @var TextField the model id  
     */
    public $modelId;
    
    /**
     *
     * @return type 
     */
    public function getContent() {
                
        $manager = Manager::getManager($this->modelType);
        if (!$manager) {
            return null;
        }
                     
        return $manager->get($this->modelId);
    }    
}

?>
