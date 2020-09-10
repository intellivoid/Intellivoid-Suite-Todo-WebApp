<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\SearchMethods\GroupSearchMethod;
    use Todo\Exceptions\GroupNotFoundException;
    use Todo\Exceptions\InvalidGroupTitleException;
    use Todo\Todo;
    use Todo\Utilities\Validation;

    HTML::importScript("define_todo");


    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_GET["action"]))
        {
            if($_GET["action"] == "delete_group")
            {
                deleteGroup();
            }
        }
    }

    function deleteGroup()
    {
        if(isset($_GET["group"]) == false)
        {
            return;
        }

        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        try
        {
            $Group = $TodoManager->getGroupManager()->getGroup(GroupSearchMethod::byPublicId, $_GET["group"]);
        }
        catch(GroupNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "105", "resource" => "delete_group"
            )));
            return;
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "104", "resource" => "delete_group"
            )));
            return;
        }

        if($Group->AccountID !== WEB_ACCOUNT_ID)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "105", "resource" => "delete_group"
            )));
        }

        if($Group->IsDeleted)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "105", "resource" => "delete_group"
            )));
        }

        $Group->IsDeleted = true;

        try
        {
            $TodoManager->getGroupManager()->updateGroup($Group);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "100", "resource" => "delete_group"
            )));
            return;
        }

        // Delete all tasks associated with this group
        $Tasks = null;

        try
        {
            $Tasks = $TodoManager->getTasksManager()->getTasks(WEB_ACCOUNT_ID, $Group->ID);
        }
        catch(Exception $e)
        {
            unset($e);
        }

        if($Tasks !== null)
        {
            foreach($Tasks as $task)
            {
                $task->IsDeleted = true;

                try
                {
                    $TodoManager->getTasksManager()->updateTask($task);
                }
                catch(Exception $e)
                {
                    unset($task);
                }
            }
        }

        $Parameters = $_GET;
        $Parameters["action"] = "none";
        $Parameters["callback"] = "none";
        $Parameters["group"] = "main";
        Actions::redirect(DynamicalWeb::getRoute("index", $Parameters));
    }