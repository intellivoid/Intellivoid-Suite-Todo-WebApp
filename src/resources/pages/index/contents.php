<?php

    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;

    HTML::importScript("create_task");
    HTML::importScript("render_alert");
    HTML::importScript("check_filter");

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
                                    ?>
                                    <div class="list-group list-group-filters font-medium-1">
                                        <?PHP $FilterParameters["filter"] = "all"; ?>
                                        <a href="<?PHP \DynamicalWeb\DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0 pt-0<?PHP if(TASKS_FILTER == "all"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-mail mr-50"></i> All
                                        </a>
                                    </div>
                                    <hr>
                                    <h5 class="mt-2 mb-1 pt-25">Filters</h5>
                                    <div class="list-group list-group-filters font-medium-1">
                                        <?PHP $FilterParameters["filter"] = "uncompleted"; ?>
                                        <a href="<?PHP \DynamicalWeb\DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "uncompleted"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-alert-circle mr-50"></i> Uncompleted
                                        </a>
                                        <?PHP $FilterParameters["filter"] = "completed"; ?>
                                        <a href="<?PHP \DynamicalWeb\DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "completed"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-check-circle mr-50"></i> Completed
                                        </a>
                                        <?PHP $FilterParameters["filter"] = "deleted"; ?>
                                        <a href="<?PHP \DynamicalWeb\DynamicalWeb::getRoute("index", $FilterParameters, true); ?>" class="list-group-item list-group-item-action border-0<?PHP if(TASKS_FILTER == "deleted"){ HTML::print(" active"); } ?>">
                                            <i class="font-medium-5 feather icon-trash mr-50"></i> Trashed
                                        </a>
                                    </div>
                                    <hr>
                                    <h5 class="mt-2 mb-1 pt-25">Labels</h5>
                                    <div class="list-group list-group-labels font-medium-1">
                                        <a href="#" class="list-group-item list-group-item-action border-0 d-flex align-items-center">
                                            <span class="bullet bullet-primary mr-1"></span> Frontend
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action border-0 d-flex align-items-center">
                                            <span class="bullet bullet-warning mr-1"></span> Backend
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action border-0 d-flex align-items-center">
                                            <span class="bullet bullet-success mr-1"></span> Doc
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action border-0 d-flex align-items-center">
                                            <span class="bullet bullet-danger mr-1"></span> Bug
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <?PHP HTML::importScript("add_task_modal"); ?>
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
                                            <div class="sidebar-toggle d-block d-lg-none"><i class="feather icon-menu"></i></div>
                                            <fieldset class="form-group position-relative has-icon-left m-0">
                                                <input type="text" class="form-control" id="todo-search" placeholder="Search..">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search"></i>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="todo-task-list list-group">
                                            <ul class="todo-task-list-wrapper media-list">
                                                <?PHP
                                                    HTML::importScript("render_tasks");
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
                            <!-- Modal -->
                            <?PHP HTML::importScript("edit_task_modal"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>
        <?PHP Javascript::importScript("application"); ?>
    </body>
</html>