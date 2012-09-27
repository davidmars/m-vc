<?php
$vv = new VV_doc_page($_vars);
?>

<p>
    Sometimes, you may have to add bits of PHP code to your template. For instance you may want to display variables.
    To find out what variables are available to display, use autocompletion (see the 'Get started' section to know more about autocompletion). 
</p>


<div class="">
    <h3 class="section">Displaying a variable</h3>
    <p>For the example we will use a variable that is always available. (path of the current page)</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=$this->path?>')?>
    </pre>
    <p>This will generate the following display: <?=$this->path?><br /><br />
        <span class='label'>Note</span> There are two ways to add PHP code in a template:
    </p>
    <ul>
        <li><code><?=htmlentities('<?= ... ?>')?></code> is used to display the value of a variable (or the result of a function).</li>
        <li><code><?=htmlentities('<? ... ?>')?></code> is used to add a piece of code that will be executed.</li>
    </ul>

</div>

<div class="">
    <h3 class="section">Basic PHP codes</h3>
    <p>Sometimes you may need to change the display of a line or two of your template, depending on a condition.</p>
</div>
<div class="">
    <h4 class="section">IF statement</h4>
    <p>You can use PHP IF statement to execute some code only if a specified condition is true.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?if($this->variable):?> <!--checks if the variable $this->variable exists-->
    <p>The variable does exist!</p> <!--line to display only if it does exists-->
<?endif?>')?>
    </pre>
    <p>Let's try an exemple using the same variable as before.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?if($this->path):?> <!--checks if the variable $this->path exists-->
    <b>The path</b> is : <?=$this->path?>
<?endif?>')?>
    </pre>
    <p>This will display the following line:<br/><b>The path</b> is : <?=$this->path?></p>
</div>
<div class="">
     <h4 class="section">IF...ELSE statement</h4>
     <p>Use this statement to execute some code if a condition is true and another code if the condition is false.</p>
     <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?if($this->variable):?> <!--checks if the variable $this->variable exists-->
    <p>The variable does exist!</p> <!--line to display if it does exists-->
    <?else:?>
    <p>sorry, the variable doesn\'t exist.</p>
<?endif?>')?>
    </pre>
     <p>Since the variable $this->variable doesn't exist, this code will generate the following line:</p>
<?if($this->variable):?> <!--checks if the variable $this->variable exists-->
    <p>The variable does exist!</p> <!--line to display if it does exists-->
<?else:?>
    <p>sorry, the variable doesn't exist.</p>
<?endif?>
</div>

<div class="">
    <h4 class="section">IF...ELSEIF...ELSE statement</h4>
    <p>Use this statement to select one of several blocks of code to be executed.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?if($this->variable1):?> <!--checks if the variable $this->variable1 exists-->
        <p>Variable1 does exist!</p> <!--line to display if it does exists-->
    <?elseif($this->variable2):?> <!--only if variable1 doesn\'t exist we check if variable2 exists-->
        <p>Variable1 doesn\'t exist, but variable2 does exist.</p>
    <?else:?>
        <p>sorry, neither variable1 nor variable2 exist.</p>
<?endif?>')?>
    </pre>
    <p>Since neither $this->variable1 nor $this->variable2 exist, this code will generate the following line:</p>
<?if($this->variable1):?>
        <p>Variable1 does exist!</p>
    <?elseif($this->variable2):?>
        <p>Variable1 doesn't exist, but variable2 does exist.</p>
    <?else:?>
        <p>sorry, neither variable1 nor variable2 exist.</p>
<?endif?>
</div>

<div class="">
    <h4 class="section">Need to repeat something? Use the FOR loop</h4>
    <p>This loop will let your repeat some piece of code as many times as you want.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?for($i=0;$i<3;$i++):?> <!--sets the start and end of the loop-->
    This is a line.<br /> <!--code to be repeated-->
<?endfor?>')?>
    </pre>
    <p>This code will generate the same line 3 times:<br />
<?for($i=0;$i<3;$i++):?>
    This is a line.<br />
<?endfor?>
    </p>
    <p>Let's explain the first line of the code:</p>
    <ul>
        <li>$i=0 // $i is a variable that is created and starts at 0.</li>
        <li>$i<3 // is a condition evaluated at each loop iteration. The loop will go on as long as the condition is true.</li>
        <li>$i++ // tells the loop to increment $i at every loop iteration (same as $i+1)</li>
    </ul>
    <p>So basically, the loop will execute the code with $i=0, then with $i=1, 
        then with $i=2 and then will stop because $i=3 and the condition $i<3 isn't true anymore.
    This code will be executed 3 times.</p>
    <p><span class="label">NOTE</span> $i is a variable that exists only in the loop. It can be displayed but only in the loop.<p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?for($i=0;$i<3;$i++):?>
    This is line number <?=$i?>.<br />
<?endfor?>')?>
    </pre>
    <p>This code will display the following:<br />
<?for($i=0;$i<3;$i++):?>
    This is line number <?=$i?>.<br />
<?endfor?>
    </p>
    <div class="alert alert-info">
        <h4>Important</h4> 
        Make sure that the condition you use in the loop <b>isn't always true</b> or else the loop will never end, therefore crashing the system.<br>
        For the same reason, never write the condition with just <code>$i=3</code>, always use <code>$i<3</code>.
    </div>
</div>
<div class="">
     <h4 class="section">example : IF...ELSE statement in a FOR loop</h4>
     <p>In a FOR loop, we create a variable. Why not adding a condition depending on that variable?</p>
     <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?for($i=0;$i<3;$i++):?>
    <?if($i==2):?>
        This is the last line!
    <?else:?>
        This is line number <?=$i?>.<br />
    <?endif?>
<?endfor?>')?>
    </pre>
    <p>This code will display the following:<br />
<?for($i=0;$i<3;$i++):?>
    <?if($i==2):?>
        This is the last line!
    <?else:?>
        This is line number <?=$i?>.<br />
    <?endif?>
<?endfor?>
    </p>
</div>

<div class="">
    <h4 class="section">Using FOREACH loop</h4>
    <p>
        Sometimes the variables available in the template are arrays of values.
        In this case you will need to execute the same code for each value in the array. 
        To do so, we will use the FOREACH loop.
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?$fruits=array("apple","banana","cherry");?>
<!-- this creates a variable $fruits that is an array of values -->
<ul>
    <?foreach ($fruits as $item):?>
    <!-- for each item in this array we execute the following code -->
        <li><?=$item?></li>
    <?endforeach?>
</ul>')?>
    </pre>
    <p>This will display:<br />   
<?$fruits=array("apple","banana","cherry");?>
<!-- this creates a variable $fruits that is an array of values -->
<ul>
    <?foreach ($fruits as $item):?>
    <!-- for each item in this array we execute the following code -->
        <li><?=$item?></li>
    <?endforeach?>
</ul>
    </p>
</div>
