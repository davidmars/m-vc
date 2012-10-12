<?php
/**
 * A category can contain posts, but a post can have only one category.  
 */
class M_category_post extends M_{

    public static $manager;
    /**
     *
     * @var TextField The name of the category post
     */
    public $title;
    
    /*     
     * @return Array<M_post> Return all the post of the current category
     */
    public function getPosts(){                
        return M_post::$manager->select()->where("category",$this->id)->all();
    }
    
    /**
     *
     * @param int $page It's the current page
     * @return Array<M_post> Return all post of the current blog for the given page
     */
    public function getPostsForPage($page) {
        $offset = 4;

        $limitX = ($page - 1) * $offset;
        $limitY = $page * $offset;
        
        $posts = M_post::$manager->select()->where("category",$this->id)->orderBy(array("id" => "asc"))->limit($limitX, $offset)->all();        
                     
        return $posts;
    }

    /**
     *
     * @return int It's return an array for count how many posts we haves
     */
    public function countPosts() {
        return M_post::$manager->select()->where("category",$this->id)->count();
    }    
    
    /**
     *
     * @return int Return the number of page that this category can be display 
     */
    public function getNbPage() {
        $offset = 4;
        
        return ceil(M_post::$manager->select()->where("category",$this->id)->count() / $offset);
    }
    
    /**
     *
     * @return string text identifier of model M_categoryPost_1
     */
    public function getCategoryId() {
        return $this->modelName . "_" . $this->id;
    }
}



