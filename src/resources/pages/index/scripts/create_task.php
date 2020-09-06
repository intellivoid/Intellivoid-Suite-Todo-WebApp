<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\Color;
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

        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        try
        {
            $TodoManager->getTasksManager()->createTask(WEB_ACCOUNT_ID, $Title, $Description);

            Actions::redirect(DynamicalWeb::getRoute("index"));
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