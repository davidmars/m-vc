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
<h1><?=$vv->title?></h1>
<?if($vv->param1):?>
    <h3>The first parameter in your url is <?=$vv->param1?></h3>
<?else:?>
    <h3>pas de param1</h3>
<?endif?>
<?if($vv->param2):?>
    <h3>And the second one is <?=$vv->param2?></h3>
<?else:?>
    <h3>pas de param2</h3>
<?endif?>
 
    <h2 class="section">comment créer une page...</h2>
    <p>Pour chaque page il faut créer :
    <ul>
        <li>un controller dans le répertoire /c/ qui se nomme "c_NomDeMaPage.php"</li>
        <li>un template dans le répertoire /v/ qu'on nommera "NomDeMaVue.php"</li>
    </ul>
    <p>Note : si un seul template pour un controller, autant l'appeler comme le controller pour plus de clareté</p>
    <h2 class="section">Le controller doit avoir cette forme :</h2>
    <pre class="prettyprint linenums lang-php">

        class Nom_de_ma_pageController extends Controller {
            public function index($param1=null,$param2=null)
            {
                //on peut faire une method index différente : 
                //sans arg, ou alors avec un seul arg $page et faire un traitement différent

                //if too much arguments redirect to the best page url
                if(func_num_args()>2){
                    $this->redirect302($this->routeToFunction."/$param1/$param2");
                }
                //création et appel de la vue correspondant à la page
                $vv=new VV_fmk_page();
                $vv->htmlHeader=new VV_html_header();
                $vv->htmlHeader->author="you@you.com";
                $vv->htmlHeader->title="Ma première page";
                $vv->param1=$param1;
                $vv->param2=$param2;
                $vv->title="Ma première page en racine de fmk";
                $view=new View("NomDeMaVue", $vv); //ecriture en dur du template à afficher
                return $view;
            }

        }
    </pre>
    
    <h2 class="section">La vue doit avoir cette forme :</h2>
    <pre class="prettyprint linenums lang-php">
        <?=htmlentities('
        <?$vv=new VV_fmk_page($_vars);?>
        <?$this->inside("fmk-default/layout/commonPage")?>
        <h1>
            <?=$vv->title?>
        </h1>
        <!-- Reste de la page en html -->
        ')?>
    </pre>
    <hr/>
    <h3 class="section">Voilà, je teste une page...</h3>
    <p>son url c'est <em>lolo/index/</em><br /><br />
        "lolo" car c'est le nom de mon controller<br />
        "index" pour appeler la method index() qui va chercher mon template
    <hr/>
    <h2 class="section">Afficher une variable :</h2>
    <pre class="prettyprint linenums lang-php">
        <?=htmlentities('<?=$this->myAttribute?>')?>
    </pre>
    exemple : <code><?=htmlentities('<?=$vv->title ?>')?></code>affiche le titre de la page : <?=$vv->title ?>
    
    <h2 class="section">Insérer du code PHP dans le template :</h2>
    <pre class="prettyprint linenums lang-php">
        <?=htmlentities('
<?if($vv->param1):?>
    <h3>The first parameter in your url is <?=$vv->param1?></h3>
<?else:?>
    <h3>pas de param1</h3>
<?endif?>
')?>
    </pre>
    exemple : <code><?=htmlentities('<? if($vv->title):?>Titre <?=$vv->title?><?endif?>')?></code>
    affiche : <? if($vv->title):?>Titre <?=$vv->title?><?endif?>
    
    <hr/>
    <h2 class="section">et je mets une image car je sais faire!... ou pas...</h2>
    <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200)?>"/>
    
    <h2 class="section">et du coup j'essaye d'inclure le fichier doc/for-hipsters/urls.php avec la method render()</h2>
<?=$this->render("doc/pages/for-hipsters/urls",$vv)?>