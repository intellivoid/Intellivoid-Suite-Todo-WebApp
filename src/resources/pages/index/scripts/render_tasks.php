<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Exceptions\DatabaseException;
    use Todo\Objects\Task;
    use Todo\Todo;

    /**
     * Returns tasks that are currently incomplete and not deleted
     *
     * @return Task[]
     * @throws DatabaseException
     */
    function getTasks(): array
    {
        $target_group = null;

        if(isset($_GET["target_group"]))
        {
            $target_group = $_GET["target_group"];
        }

        HTML::importScript("define_todo");
        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        if($target_group == null)
        {
            $Tasks = $TodoManager->getTasksManager()->getTasks(WEB_ACCOUNT_ID);
        }
        else
        {
            // TODO: Add the ability to get tasks by group
            $Tasks = array();
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
        ?>
        <li class="todo-item<?PHP if($task->IsCompleted){ HTML::print(" completed"); } ?>">
            <data hidden="hidden" class="todo-item-id" value="<?PHP HTML::print($task->PublicID); ?>"></data>
            <div class="todo-title-wrapper d-flex justify-content-between mb-50">
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
                    <div class="chip-wrapper">
                        <div class="chip mb-0">
                            <div class="chip-body">
                                <span class="chip-text" data-value="Bug">
                                    <span class="bullet bullet-danger bullet-xs"></span> Bug
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-right todo-item-action d-flex" style="justify-content: flex-end;">
                    <a class="todo-item-color mr-1">
                        <i class="feather icon-circle"></i>
                    </a>
                    <a class="todo-item-delete">
                        <i class="feather icon-trash"></i>
                    </a>
                </div>
            </div>
            <p class="todo-desc truncate mb-0"><?PHP HTML::print($task->Description); ?></p>
        </li>
        <?php
    }