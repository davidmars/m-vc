ok...here are your controlers and views...yes they are in the same folder!

Why? because ergonomy. When you work on a controler, you need to edit the view in the same time, isn't it?
Putting views and controlers in the same place prevent your editor to swicth from a folder to an other one.

Your controllers are classes. File names always end with "_c.php"

For exemple :

-home_c.php // this is the controler of the page "home". It will manage URLs like /home/what-to-do/what-parameter/. 
-home.php // this is the default view of the page "home". In fact it can be different if home_c.php manage it differently. 
-item.php // this is a simple template cause there is no related controler.