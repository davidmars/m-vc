<?php

/**
 * Description of c_testModels
 *
 * @author David Marsalone
 */
class c_testModels extends Controller{
    
    public function post($id=null){
        M_::initModel("M_post");
        $list= M_post::$manager->select()->all();
        foreach($list as $p){
            echo $p->title."<br>";
        }
        $p=new M_post();
        $p->title="test1";
        $p->sticky=false;
        $p->save();
        
        $p=new M_post();
        $p->title="test2";
        $p->sticky=true;
        $p->save();
        
        
        
        die("end of test");
        
        
    }
    public function basic($id=null){
        $p=new M_dataBase();
        $p->save();
        die("end of test basic");
    }
}
