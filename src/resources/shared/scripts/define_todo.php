<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use Todo\Todo;

    Runtime::import("Todo");

    if(isset(DynamicalWeb::$globalObjects["todo"]) == false)
    {
        DynamicalWeb::setMemoryObject("todo", new Todo());
    }