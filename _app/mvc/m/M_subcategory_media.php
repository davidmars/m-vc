<?php
/**
 * A subcategory media can contain media
 */
class M_subcategory_media extends M_{

    public static $manager;
    /**
     *
     * @var TextField The name of the subcategory
     */
    public $title;    
    
    /**
     *
     * @param int $page It's the current page
     * @return Array<M_media> Return all medias of the current subcategory_Media for the given page
     */
    public function getMediaForPage($page) {
        $offset = 4;

        $limitX = ($page - 1) * $offset;
        $limitY = $page * $offset;
                      
        $medias = M_media::$manager->select()->where('category', $this->id)->orderBy(array("id" => "asc"))->limit($limitX, $offset)->all();        
                             
        return $medias;
    }
    
    /**
     *
     * @return int Return the number of page that this subCategory can be display 
     */
    public function getNbPage() {
        $offset = 4;
        
        return ceil(M_media::$manager->select()->where('category', $this->id)->count() / $offset);
    }
    
    /**
     *
     * @return string text identifier of model M_subcategoryMedia_1
     */
    public function getCategoryId() {
        return $this->modelName . "_" . $this->id;
    }
}



