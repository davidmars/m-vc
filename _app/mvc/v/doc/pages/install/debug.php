<?php
$vv = new VV_doc_page($_vars);
?>

<p>
    This framework comes with a PHP debugging function based on Chrome PHP extension.<br />
    This function will help you to create your own logs, warnings and error messages that will be available in the Chrome console.
</p>
<div class="">
    <h3 class="section">Get set</h3>
    <p>
        First you must <a href="https://chrome.google.com/extensions/detail/noaneddfkdjfnfdakjjmocngnfkfehhd" target="_blank">install</a> 
        the ChromePHP extension from the Google Chrome Extension Gallery.<br />
        Click the extension icon to enable logging for the current tab's domain (it should be grey when it's off, blue otherwise).<br /><br />
        <img style="border:1px solid;" src="<?=GiveMe::url("pub/app/doc/img/chrome-click.png")?>"/><br /><br />
        Then press F12 to access the console.
    </p>
</div>

<div class="">
    <h3 class="section">Create debug messages</h3>
    <p>
        You can create a message everywhere you want in PHP files<br />
    </p>
    <pre class="prettyprint linenums lang-php">
        <?=htmlentities('<? 
            Human::log("content", "title", Human::TYPE); 
            ?>')?>
    </pre>
    <p>
        The function <code>Human::log()</code> has <b>three</b> parameters.
    </p>
    <ul>
        <li>'content' is the message you want to display (required)</li>
        <li>'title' is the title of the message (optional, default value is 'Php Trace')</li>
        <li>'TYPE' is the type of message: (optional, default value is 'Human::TYPE_WARN'). 3 possible values:
            <ul>
                <li>Human::TYPE_LOG</li>
                <li>Human::TYPE_ERROR</li>
                <li>Human::TYPE_WARN</li>
            </ul>
        </li>
    </ul>
</div>

<div class="">
    <h3 class="section">Let's try!</h3>
    <p>
        Just type in the following code in any page of your app:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=Human::log("content of the log", "title ->", Human::TYPE_LOG)?>
<?=Human::log("content of the error", "title ->", Human::TYPE_ERROR)?>
<?=Human::log("content of the warning", "title ->", Human::TYPE_WARN)?>')?>
    </pre>
    <p>
        This code will create the following lines in the Chrome console:<br /><br />
        <img style="border:1px solid;" src="<?=GiveMe::url("pub/app/doc/img/Chrome-testing.PNG")?>"/>
    </p>
</div>
