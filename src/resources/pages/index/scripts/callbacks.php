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

            case 106:
                RenderAlert("The task color is invalid", "danger", "icon-alert-triangle");
                break;

            case 107:
                RenderAlert("The requested task cannot be found", "danger", "icon-alert-triangle");
                break;

            case 108:
                RenderAlert("Invalid request, missing parameter 'task_id'", "danger", "icon-alert-triangle");
                break;

            case 109:
                RenderAlert("Invalid request, missing parameter 'color'", "danger", "icon-alert-triangle");
                break;

            case 110:
                RenderAlert("Invalid request, missing parameter 'title'", "danger", "icon-alert-triangle");
                break;

            case 111:
                RenderAlert("Invalid request, missing parameter 'description'", "danger", "icon-alert-triangle");
                break;

            case 112:
                RenderAlert("You don't have the proper permissions to view this content", "danger", "icon-alert-triangle");
                break;

            case 113:
                RenderAlert("The task cannot be permanently deleted without being in the trash first", "danger", "icon-alert-triangle");
                break;

            case 114:
                RenderAlert("The task cannot be restored because it isn't deleted", "danger", "icon-alert-triangle");
                break;
        }
    }