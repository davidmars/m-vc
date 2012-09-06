<?
/**
 * this is defined in the controller 
 */
$vv=new VV_fmk_page($_vars);
?>
<?
/*
 * we put this content in the framework default layout page...so we will get:
 * 
 * -twitter bootstrap
 * -jquery
 * -framework stylesheet default 
 * 
 * 
 */


?>
<?$this->inside("fmk-default/layout/commonPage")?>
<h1>
    <?=$vv->title?>
</h1>
<?if($vv->param1):?>
    <h2>The first parameter in your url is <?=$vv->param1?></h2>
<?endif?>
<?if($vv->param2):?>
    <h2>And the second one is <?=$vv->param2?></h2>
<?endif?>
    <h3 class="section">
        Here we test urls...
    </h3>
    <ul class="nav-list">
        
        <?
        $urls=array(
            "home/index/toto",
            "home/index/titi",
            "home/index/toto/titi",
            "i-am/not-a/valid-page",
            "pub/app/fmk/img/logo.png",
            "app/fmk/img/logo.png",
            "pub/app/fmk/img/i-not-a-real-file.png",
            "http://www.google.com",
            "https://www.google.com",
            "http://i-am-not-a-real-website-url", //will display it normaly cause it's an absolute url.
            );
        ?>
        <li class="nav-header">Relatives urls</li>

        
        <?foreach($urls as $url):?>
            <?$convertedUrl=GiveMe::url($url)?>
            <li>The url <b><?=$url?></b> will be converted to : <a href="<?=$convertedUrl?>"><?=$convertedUrl?></a></li>
        <?endforeach?>
            
        <li class="nav-header">Absolute urls</li>
        
        
        <?foreach($urls as $url):?>
            <?$convertedUrl=GiveMe::url($url,true)?>
            <li>The url <b><?=$url?></b> will be converted to : <a href="<?=$convertedUrl?>"><?=$convertedUrl?></a></li>
        <?endforeach?>
    </ul>
    

    <h2>Image manipulations</h2>

    <?
    $params=array(
        array("w"=>50,"h"=>50,"bgColor"=>"000000"),
        array("w"=>300,"h"=>300,"bgColor"=>"000000"),
        array("w"=>800,"h"=>800,"bgColor"=>"000000"),
        array("w"=>400,"h"=>300,"bgColor"=>"000000"),
        array("w"=>300,"h"=>400,"bgColor"=>"000000"),
        array("w"=>1600,"h"=>900,"bgColor"=>"000000"),
        array("w"=>900,"h"=>1600,"bgColor"=>"000000"),


    )
    ?>
    
        <h3>imageSized</h3>
        <?foreach($params as $p):?>
        <div>
            <h5>Resize to <?=$p["w"]?>x<?=$p["h"]?>px</h5>
            <?
            $img=GiveMe::imageSized("pub/app/fmk/img/logo.png", $p["w"], $p["h"]);
            ?>
            <img class="toshop" src="<?=$img?>"/>
        </div>
        <hr/>
        <?endforeach?>
        
        <h3>imageSizedWithoutCrop</h3>
        
        <?foreach($params as $p):?>
        <div>
            <h5>Resize to <?=$p["w"]?>x<?=$p["h"]?>px</h5>
            <?
            $img=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png", $p["w"], $p["h"]);
            ?>
            <img class="toshop" src="<?=$img?>"/>
        </div>
        <hr/>
        <?endforeach?>
        
        <?foreach($params as $p):?>
        <div>
            <h5>Resize to <?=$p["w"]?>x<?=$p["h"]?>px</h5>
            <?
            $img=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png", $p["w"], $p["h"],"ff0000");
            ?>
            <img class="toshop" src="<?=$img?>"/>
        </div>
        <hr/>
        <?endforeach?>
        
        <?foreach($params as $p):?>
        <div>
            <h5>Resize to <?=$p["w"]?>x<?=$p["h"]?>px</h5>
            <?
            $img=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png", $p["w"], $p["h"],"transparent","png");
            ?>
            <img class="toshop" src="<?=$img?>"/>
        </div>
        <hr/>
        <?endforeach?>
        
        <h3>imageSizedMirror</h3>
        

  

