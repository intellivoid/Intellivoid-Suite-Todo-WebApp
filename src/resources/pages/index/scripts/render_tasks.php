<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\Color;
use Todo\Abstracts\SearchMethods\GroupSearchMethod;
use Todo\Exceptions\DatabaseException;
use Todo\Objects\Group;
use Todo\Objects\Task;
    use Todo\Todo;

    HTML::importScript("define_todo");


    /**
     * Returns tasks that are currently incomplete and not deleted
     *
     * @return Task[]
     * @throws DatabaseException
     */
    function getTasks(): array
    {
        $target_group = null;

        if(isset(DynamicalWeb::$globalObjects["selected_group"]))
        {
            /** @var Group $target_group */
            $target_group = DynamicalWeb::getMemoryObject("selected_group");
        }

        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        if($target_group == null)
        {
            $Tasks = $TodoManager->getTasksManager()->getTasks(WEB_ACCOUNT_ID);
        }
        else
        {
            $Tasks = $TodoManager->getTasksManager()->getTasks(WEB_ACCOUNT_ID, $target_group->ID);
        }

        $Results = array();

        if(count($Tasks) > 0)
        {
            foreach($Tasks as $task)
            {
                if($task->Properties->IsDeleted)
                {
                    if((int)time() > $task->Properties->TimeTillTrueDeleted)
                    {
                        $task->IsDeleted = true;

                        try
                        {
                            $TodoManager->getTasksManager()->updateTask($task);
                        }
                        catch(Exception $e)
                        {
                            unset($e);
                        }

                        continue;
                    }
                }

                switch(TASKS_FILTER)
                {
                    case "deleted":
                        if($task->Properties->IsDeleted)
                        {
                            $Results[] = $task;
                        }
                        break;

                    case "completed":
                        if($task->IsCompleted)
                        {
                            if($task->Properties->IsDeleted == false)
                            {
                                $Results[] = $task;
                            }
                        }
                        break;

                    case "uncompleted":
                        if($task->IsCompleted == false)
                        {
                            if($task->Properties->IsDeleted == false)
                            {
                                $Results[] = $task;
                            }
                        }
                        break;

                    default:
                        if($task->Properties->IsDeleted == false)
                        {
                            $Results[] = $task;
                        }
                        break;
                }

            }
        }

        return $Results;
    }

    /**
     * Renders the tasks depending on the filter and task type, this will update the
     * task properties
     *
     * @param Task[] $tasks
     */
    function renderTasks(array $tasks)
    {
        foreach($tasks as $task)
        {
            renderTaskItem($task);
        }
    }

    /**
     * Renders the HTML code for the task item
     *
     * @param Task $task
     */
    function renderTaskItem(Task $task)
    {
        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        ?>
        <li class="todo-item<?PHP if($task->IsCompleted){ HTML::print(" completed"); } ?>" data-toggle="modal" data-target="#editTaskModal">
            <data hidden="hidden" class="todo-item-id" value="<?PHP HTML::print($task->PublicID); ?>"></data>
            <div class="todo-title-wrapper d-flex justify-content-between mb-0">
                <div class="todo-title-area d-flex align-items-center">
                    <div class="title-wrapper d-flex">

                        <div class="vs-checkbox-con">
                            <input class="todo-check" type="checkbox" value="<?PHP if($task->IsCompleted){ HTML::print("true"); }else{ HTML::print("false"); } ?>" <?PHP if($task->IsCompleted){ HTML::print(" checked"); } ?>>
                            <span class="vs-checkbox vs-checkbox-sm">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                        </div>
                        <h6 class="todo-title mt-50 mx-50"><?PHP HTML::print($task->Title); ?></h6>
                    </div>
                    <?PHP
                        if($task->GroupID !== 0 || $task->GroupID !== null)
                        {
                            $AssociatedGroup = null;

                            if(isset(DynamicalWeb::$globalObjects["group_" . $task->GroupID]) == false)
                            {
                                $GroupObject = null;

                                try
                                {
                                    $GroupObject = $TodoManager->getGroupManager()->getGroup(GroupSearchMethod::byId, $task->GroupID);
                                }
                                catch(Exception $e)
                                {
                                    unset($e);
                                }

                                if($GroupObject !== null)
                                {
                                    if($GroupObject->AccountID == WEB_ACCOUNT_ID)
                                    {
                                        if($GroupObject->IsDeleted == false)
                                        {
                                            DynamicalWeb::setMemoryObject("group_" . $task->GroupID, $GroupObject);
                                            $AssociatedGroup = $GroupObject;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                /** @var Group $AssociatedGroup */
                                $AssociatedGroup = DynamicalWeb::getMemoryObject("group_" . $task->GroupID);
                            }

                            if($AssociatedGroup !== null)
                            {
                                ?>
                                <div class="chip-wrapper">
                                    <div class="chip mb-0">
                                        <div class="chip-body">
                                            <?PHP
                                                $GroupParameters = $_GET;
                                                $GroupParameters["group"] = $AssociatedGroup->PublicID;
                                            ?>
                                            <a class="chip-text" href="<?PHP DynamicalWeb::getRoute("index", $GroupParameters, true); ?>">
                                                <!-- <span class="bullet bullet-danger bullet-xs"></span> -->
                                                <?PHP HTML::print($AssociatedGroup->Title); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?PHP
                            }
                        }
                    ?>
                </div>
                <div class="float-right todo-item-action d-flex" style="justify-content: flex-end;">
                    <?PHP
                        $TaskColorClass = null;
                        $TaskColorCSS = null;

                        switch($task->Color)
                        {
                            case Color::Pink:
                                $TaskColorClass = "color-pink";
                                $TaskColorCSS = "color: #ff0198;";
                                break;

                            case Color::Green:
                                $TaskColorClass = "color-green";
                                $TaskColorCSS = "color: #28c76f;";
                                break;

                            case Color::Yellow:
                                $TaskColorClass = "color-yellow";
                                $TaskColorCSS = "color: #ff9f43;";
                                break;

                            case Color::Blue:
                                $TaskColorClass = "color-blue";
                                $TaskColorCSS = "color: #00cfe8;";
                                break;

                            case Color::Red:
                                $TaskColorClass = "color-red";
                                $TaskColorCSS = "color: #ea5455;";
                                break;

                            case Color::None:
                            default:
                                $TaskColorClass = "color-none";
                                $TaskColorCSS = "color: #c2c6dc;";
                                break;
                        }
                    ?>
                    <a class="todo-item-color <?PHP HTML::print($TaskColorClass); ?> mr-1" style="<?PHP HTML::print($TaskColorCSS, false); ?>">
                        <i class="feather icon-circle"></i>
                    </a>
                    <?PHP
                        if($task->Properties->IsDeleted)
                        {
                            ?>
                            <a class="todo-item-restore text-light mr-1">
                                <i class="feather icon-rotate-cw"></i>
                            </a>
                            <a class="todo-item-perma-delete text-light">
                                <i class="feather icon-trash"></i>
                            </a>
                            <?PHP
                        }
                        else
                        {
                            ?>
                            <a class="todo-item-delete text-light">
                                <i class="feather icon-trash"></i>
                            </a>
                            <?PHP
                        }
                    ?>
                </div>
            </div>
            <p class="todo-desc truncate mb-0"><?PHP HTML::print($task->Description); ?></p>
        </li>
        <?php
    }