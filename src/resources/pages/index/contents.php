<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;

    HTML::importScript("create_task");
    HTML::importScript("create_group");
    HTML::importScript("edit_group_name");
    HTML::importScript("delete_group");
    HTML::importScript("render_alert");
    HTML::importScript("check_filter");

    HTML::importScript("get_group");
    HTML::importScript("render_tasks");
    HTML::importScript("render_groups");

?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title>Todo</title>
    </head>
    <body class="horizontal-layout horizontal-menu dark-layout content-left-sidebar todo-application navbar-floating footer-static" data-open="hover" data-menu="horizontal-menu" data-col="2-columns" data-layout="dark-layout">
        <?PHP HTML::importSection('main_nav'); ?>
        <div class="app-content content">
            <div class="content-overlay"></div>
            <?PHP HTML::importScript("callbacks"); ?>
            <div class="content-area-wrapper">
                <div class="sidebar-left">
                    <div class="sidebar">
                        <div class="sidebar-content todo-sidebar d-flex">
                            <span class="sidebar-close-icon">
                                <i class="feather icon-x"></i>
                            </span>
                            <div class="todo-app-menu">
                                <div class="form-group text-center add-task">
                                    <button type="button" class="btn btn-primary btn-block my-1" data-toggle="modal" data-target="#addTaskModal">Add Task</button>
                                </div>
                                <div class="sidebar-menu-list">
                                    <?PHP
                                        $FilterParameters = $_GET;
                                        $CurrentGroup = "main";

                                        if(isset($_GET["group"]))
                                        {
                                            $CurrentGroup = $_GET["group"];
                                        }

                                    ?>
                                    <div class="list-group list-group-filters font-medium-1">
                                        <?PHP $FilterParameters["filter"] = "all"; ?>
                                        <?PHP $FilterParameters["group"] = "main"; ?>
                                        <a href="<?PHP DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0 pt-0<?PHP if($CurrentGroup == "main"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-home mr-50"></i> Overview
                                        </a>
                                    </div>
                                    <hr>
                                    <h5 class="mt-2 mb-1 pt-25">Filters</h5>
                                    <div class="list-group list-group-filters font-medium-1">
                                        <?PHP $FilterParameters["filter"] = "all"; ?>
                                        <?PHP $FilterParameters["group"] = $CurrentGroup; ?>
                                        <a href="<?PHP DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "all"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-menu mr-50"></i> All
                                        </a>
                                        <?PHP $FilterParameters["filter"] = "uncompleted"; ?>
                                        <?PHP $FilterParameters["group"] = $CurrentGroup; ?>
                                        <a href="<?PHP DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "uncompleted"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-alert-circle mr-50"></i> Uncompleted
                                        </a>
                                        <?PHP $FilterParameters["filter"] = "completed"; ?>
                                        <?PHP $FilterParameters["group"] = $CurrentGroup; ?>
                                        <a href="<?PHP DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "completed"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-check-circle mr-50"></i> Completed
                                        </a>
                                        <?PHP $FilterParameters["filter"] = "deleted"; ?>
                                        <?PHP $FilterParameters["group"] = $CurrentGroup; ?>
                                        <a href="<?PHP DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "deleted"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-trash mr-50"></i> Trashed
                                        </a>
                                    </div>
                                    <hr>
                                    <h5 class="mt-2 mb-1 pt-25">
                                        Groups
                                        <a class="float-right d-flex" data-toggle="modal" data-target="#addGroupModal" style="justify-content: flex-end;">
                                            <i class="feather icon-plus-square"></i>
                                        </a>
                                    </h5>
                                    <div class="list-group list-group-labels font-medium-1">
                                        <?PHP renderGroups(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?PHP HTML::importScript("add_task_modal"); ?>
                        <?PHP HTML::importScript("create_group_modal"); ?>
                        <?PHP HTML::importScript("delete_group_modal"); ?>
                    </div>
                </div>
                <div class="content-right">
                    <div class="content-wrapper">
                        <div class="content-header row">
                        </div>
                        <div class="content-body">
                            <div class="app-content-overlay"></div>
                            <div class="todo-app-area">
                                <div class="todo-app-list-wrapper">
                                    <div class="todo-app-list">
                                        <div class="app-fixed-search">
                                            <div class="sidebar-toggle d-block d-lg-none">
                                                <i class="feather icon-menu"></i>
                                            </div>
                                            <fieldset class="form-group position-relative has-icon-left m-0">
                                                <input type="text" class="form-control" id="todo-search" placeholder="Search..">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search"></i>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <?PHP HTML::importScript("render_group_header"); ?>
                                        <div class="todo-task-list list-group">
                                            <ul class="todo-task-list-wrapper media-list">
                                                <?PHP
                                                    $tasks = getTasks();
                                                    renderTasks($tasks);
                                                ?>
                                            </ul>
                                            <div class="no-results">
                                                <h3 class="mt-2">No results found</h3>
                                                <img src="/assets/images/undraw/no_results_found.svg" alt="No Results" class="img-fluid mt-3" style="height: 256px">
                                            </div>
                                            <div class="no-items<?PHP if(count($tasks) == 0){ HTML::print(" show"); } ?>">
                                                <?PHP
                                                    $NoItemsText = null;
                                                    $NoItemsImageSource = null;
                                                    $NoItemsImageAlt = null;
                                                    switch(TASKS_FILTER)
                                                    {
                                                        case "deleted":
                                                            $NoItemsText = "No deleted tasks here";
                                                            $NoItemsImageSource = "/assets/images/undraw/no_tasks_trashed.svg";
                                                            $NoItemsImageAlt = "No Trashed Tasks";
                                                            break;

                                                        case "completed":
                                                            $NoItemsText = "No completed tasks";
                                                            $NoItemsImageSource = "/assets/images/undraw/no_tasks_uncompleted.svg";
                                                            $NoItemsImageAlt = "No Completed Tasks";
                                                            break;

                                                        case "uncompleted":
                                                        default:
                                                            $NoItemsText = "No tasks for today, continue on!";
                                                            $NoItemsImageSource = "/assets/images/undraw/no_tasks.svg";
                                                            $NoItemsImageAlt = "No Items";
                                                            break;
                                                    }
                                                ?>

                                                <h3 class="mt-2"><?PHP HTML::print($NoItemsText); ?></h3>
                                                <img src="<?PHP HTML::print($NoItemsImageSource); ?>" alt="<?PHP HTML::print($NoItemsImageAlt); ?>" class="img-fluid mt-3" style="height: 256px">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?PHP HTML::importScript("edit_task_modal"); ?>
                            <?PHP HTML::importScript("edit_group_modal"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>
        <?PHP Javascript::importScript("application", $_GET); ?>
    </body>
</html>