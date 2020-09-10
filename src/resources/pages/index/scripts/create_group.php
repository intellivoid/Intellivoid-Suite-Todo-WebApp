<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Exceptions\InvalidGroupTitleException;
    use Todo\Todo;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_GET["action"]))
        {
            if($_GET["action"] == "create_group")
            {
                createGroup();
            }
        }
    }

    function createGroup()
    {
        HTML::importScript("define_todo");

        $GroupName = null;

        if(isset($_POST["name"]))
        {
            $GroupName = $_POST["name"];
        }

        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        try
        {
            $GroupObject = $TodoManager->getGroupManager()->createGroup(WEB_ACCOUNT_ID, $GroupName);
            Actions::redirect(DynamicalWeb::getRoute("index", array("group" => $GroupObject->PublicID)));
        }
        catch (InvalidGroupTitleException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "103", "resource" => "create_task"
            )));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "100", "resource" => "create_task"
            )));
        }
    }