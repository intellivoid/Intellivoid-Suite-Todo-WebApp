<?php

    if(isset($_GET["filter"]))
    {
        switch(strtolower($_GET["filter"]))
        {
            case "deleted":
                define("TASKS_FILTER", "deleted");
                break;

            case "completed":
                define("TASKS_FILTER", "completed");
                break;

            case "uncompleted":
                define("TASKS_FILTER", "uncompleted");
                break;

            default:
                define("TASKS_FILTER", "all");
                break;
        }
    }
    else
    {
        define("TASKS_FILTER", "all");
    }