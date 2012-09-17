<?=$this->inside("doc/samples/mytemplate")?>
    <h1>Hello world</h1>
    <p>This is my first template</p>
    <ul>
        
        <?for($i=0;$i<=3;$i++):?>
        <?$k=$i*10?>
        <?=$this->render("doc/samples/list-item",array("toto"=>$i,"titi"=>$k))?>
        <?endfor?>
    </ul>
<?if($this->viewVariables->title):?> <!--checks if the variable $this->variable exists-->
    <p>The variable does exist! it is: "<?=$this->viewVariables->title?>"</p> <!--line to display if it does exists-->
<?else:?>
    <p>sorry, the variable doesn't exist.</p>
<?endif?>
