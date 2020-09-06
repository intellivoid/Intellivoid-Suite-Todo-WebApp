<?php

    if(isset($_GET["callback"]))
    {
        switch((int)$_GET["callback"])
        {
            case 100:
                RenderAlert("There was an unexpected error with our servers, try again later.", "danger", "icon-alert-triangle");
                break;

            case 101:
                RenderAlert("The task title is invalid, it cannot be empty or larger than 526 characters", "danger", "icon-alert-triangle");
                break;

            case 102:
                RenderAlert("The task description is invalid, it cannot be larger than 2526 characters", "danger", "icon-alert-triangle");
                break;
        }
    }