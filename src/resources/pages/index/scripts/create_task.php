<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\Color;
use Todo\Abstracts\SearchMethods\GroupSearchMethod;
use Todo\Exceptions\GroupNotFoundException;
use Todo\Exceptions\InvalidTaskDescriptionException;
    use Todo\Exceptions\InvalidTaskTitleException;
    use Todo\Todo;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_GET["action"]))
        {
            if($_GET["action"] == "create_task")
            {
                createTask();
            }
        }
    }

    function createTask()
    {
        HTML::importScript("define_todo");

        $Color = Color::None;
        $Title = null;
        $Description = null;
        $SelectedGroup = "main";

        if(isset($_POST["color"]))
        {
            $Color = (int)$_POST["color"];
        }

        if(isset($_POST["title"]))
        {
            $Title = $_POST["title"];
        }
        
        if(isset($_POST["description"]))
        {
            $Description = $_POST["description"];
        }

        if(isset($_POST["color"]))
        {
            $Color = (int)$_POST["color"];
        }

        if(isset($_POST["group"]))
        {
            $SelectedGroup = $_POST["group"];
        }

        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        // Resolve the group ID
        $SelectedGroupID = null;
        if($SelectedGroup !== "main")
        {
            $GroupObject = null;

            try
            {
                $GroupObject = $TodoManager->getGroupManager()->getGroup(GroupSearchMethod::byPublicId, $SelectedGroup);
            }
            catch (GroupNotFoundException $e)
            {
                unset($e);
            }
            catch(Exception $e)
            {
                Actions::redirect(DynamicalWeb::getRoute("index", array(
                    "callback" => "104", "resource" => "create_task"
                )));
            }

            if($GroupObject !== null)
            {
                if($GroupObject->AccountID == WEB_ACCOUNT_ID)
                {
                    if($GroupObject->IsDeleted == false)
                    {
                        $SelectedGroupID = $GroupObject->ID;
                    }
                }
            }
        }

        try
        {
            if($SelectedGroupID == null)
            {
                $TodoManager->getTasksManager()->createTask(WEB_ACCOUNT_ID, $Title, $Description);
            }
            else
            {
                $TodoManager->getTasksManager()->createTask(WEB_ACCOUNT_ID, $Title, $Description, [], (int)$SelectedGroupID);

            }

            $_GET["action"] = "none";
            $_GET["callback"] = "none";
            Actions::redirect(DynamicalWeb::getRoute("index", $_GET));
        }
        catch (InvalidTaskDescriptionException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "101", "resource" => "create_task"
            )));
        }
        catch (InvalidTaskTitleException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "102", "resource" => "create_task"
            )));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "100", "resource" => "create_task"
            )));
        }
    }