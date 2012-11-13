<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VV_share
 *
 * @author francoisrai
 */
class VV_share extends VV_layout {
    /**
     *
     * @var IdField
     */
    public $idPost;

    public function init($id) {
        $this->idPost = $id;
    }
}

?>
