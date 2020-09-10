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

            case 103:
                RenderAlert("The group name is invalid, it cannot be larger than 256 characters", "danger", "icon-alert-triangle");
                break;

            case 104:
                RenderAlert("There was an error while trying to get information about the group", "danger", "icon-alert-triangle");
                break;

            case 105:
                RenderAlert("The group cannot be edited, the group doesn't exist", "danger", "icon-alert-triangle");
                break;
        }
    }