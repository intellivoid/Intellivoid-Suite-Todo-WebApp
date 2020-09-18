<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\Color;
    use Todo\Abstracts\SearchMethods\TaskSearchMethod;
    use Todo\Exceptions\InvalidColorException;
    use Todo\Exceptions\InvalidTaskDescriptionException;
    use Todo\Exceptions\InvalidTaskTitleException;
    use Todo\Exceptions\TaskNotFoundException;
    use Todo\Todo;

    HTML::importScript("define_todo");

    if(isset($_POST["task_id"]) == false)
    {
        jsonResponse(false, 400, array(
            "error_code" => 108,
            "error_message" => "Missing parameter 'task_id'"
        ));
    }

    if(isset($_POST["color"]) == false)
    {
        jsonResponse(false, 400, array(
            "error_code" => 109,
            "error_message" => "Missing parameter 'color'"
        ));
    }

    if(isset($_POST["title"]) == false)
    {
        jsonResponse(false, 400, array(
            "error_code" => 110,
            "error_message" => "Missing parameter 'title'"
        ));
    }

    if(isset($_POST["description"]) == false)
    {
        jsonResponse(false, 400, array(
            "error_code" => 111,
            "error_message" => "Missing parameter 'description'"
        ));
    }

    switch(urldecode($_POST["color"]))
    {
        case "none":
            $_POST["color"] = (int)urldecode(Color::None);
            break;

        case "red":
            $_POST["color"] = (int)urldecode(Color::Red);
            break;

        case "blue":
            $_POST["color"] = (int)urldecode(Color::Blue);
            break;

        case "yellow":
            $_POST["color"] = (int)urldecode(Color::Yellow);
            break;

        case "green":
            $_POST["color"] = (int)urldecode(Color::Green);
            break;

        case "pink":
            $_POST["color"] = (int)urldecode(Color::Pink);
            break;

        case Color::None:
        case Color::Red:
        case Color::Blue:
        case Color::Yellow:
        case Color::Green:
        case Color::Pink:
            $_POST["color"] = (int)urldecode($_POST["color"]);
            break;

        default:
            jsonResponse(false, 400, array(
                "error_code" => 106,
                "error_message" => "Invalid value for task color"
            ));
    }

    $_POST["task_id"] = urldecode($_POST["task_id"]);
    $_POST["title"] = urldecode($_POST["title"]);
    $_POST["description"] = urldecode($_POST["description"]);

    /** @var Todo $TodoManager */
    $TodoManager = DynamicalWeb::getMemoryObject("todo");

    try
    {
        $Task = $TodoManager->getTasksManager()->getTask(TaskSearchMethod::byPublicId, $_POST["task_id"]);
    }
    catch (TaskNotFoundException $e)
    {
        jsonResponse(false, 404, array(
            "error_code" => 107,
            "error_message" => "The requested task was not found"
        ));
    }
    catch(Exception $e)
    {
        jsonResponse(false, 500, array(
            "error_code" => 100,
            "error_message" => "Internal server error"
        ));
    }

    if($Task->IsDeleted)
    {
        jsonResponse(false, 404, array(
            "error_code" => 107,
            "error_message" => "The requested task was not found"
        ));
    }

    if((int)$Task->AccountID !== (int)WEB_ACCOUNT_ID)
    {
        jsonResponse(false, 403, array(
            "error_code" => 112,
            "error_message" => "Invalid ownership or access to this task"
        ));
    }

    try
    {
        $Task->Color = (int)$_POST["color"];
        $Task->Title = $_POST["title"];
        $Task->Description = $_POST["description"];
        $TodoManager->getTasksManager()->updateTask($Task);
    }
    catch (InvalidColorException $e)
    {
        jsonResponse(false, 400, array(
            "error_code" => 106,
            "error_message" => "Invalid Color"
        ));
    }
    catch (InvalidTaskDescriptionException $e)
    {
        jsonResponse(false, 400, array(
            "error_code" => 102,
            "error_message" => "Invalid Task Description"
        ));
    }
    catch (InvalidTaskTitleException $e)
    {
        jsonResponse(false, 400, array(
            "error_code" => 101,
            "error_message" => "Invalid Task Title"
        ));
    }
    catch (TaskNotFoundException $e)
    {
        jsonResponse(false, 404, array(
            "error_code" => 107,
            "error_message" => "The requested task was not found"
        ));
    }
    catch(Exception $e)
    {
        jsonResponse(false, 500, array(
            "error_code" => 100,
            "error_message" => "Internal server error"
        ));
    }

    jsonResponse(true, 200);