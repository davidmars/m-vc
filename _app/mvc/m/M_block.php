<?php

/**
 * Well, Blocks are very special models.
 * Their main function is to be a relationship with an other model.
 * They are used in general to do associations between a model and various other models.
 */
class M_block extends M_ {
    /**
     * @var Manager the dedicated manager to this object.
     */
    public static $manager;
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
     * return the related model to the block.
     * @return M_
     */
    public function getContent() {
                
        $manager = Manager::getManager($this->modelType);
        if (!$manager) {
            return null;
        }
                     
        return $manager->get($this->modelId);
    }

    /**
     * Return a string that help to understand what this block is related to.
     * @return string most of time it will be Block / related model type / related model name.
     */
    public function humanName(){
        $m=$this->getContent();
        if($m){
            return "Block ".$m->modelName." / ".$m->humanName();
        }else{
            return "Block related content not found";
        }

    }
}

?>
