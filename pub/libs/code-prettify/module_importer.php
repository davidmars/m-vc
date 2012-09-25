<?php

//vkbeautify (to manage formating like indentation in xmls)
//JS::addAfterBody("pub/libs/code-prettify/vkbeautify.0.98.01.beta.js");
//google code
JS::addAfterBody("pub/libs/code-prettify/google-code-prettify/prettify.js");
CSS::addToHeader("pub/libs/code-prettify/google-code-prettify/prettify.css");
//our class that manage both stuff
JS::addAfterBody("pub/libs/code-prettify/Prettify.js");