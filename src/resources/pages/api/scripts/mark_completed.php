<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\SearchMethods\TaskSearchMethod;
    use Todo\Exceptions\InvalidColorException;
    use Todo\Exceptions\InvalidTaskDescriptionException;
    use Todo\Exceptions\InvalidTaskTitleException;
    use Todo\Exceptions\TaskNotFoundException;
    use Todo\Todo;

    if(isset($_POST["task_id"]) == false)
    {
        jsonResponse(false, 400, array(
            "error_message" => "Missing parameter 'task_id'"
        ));
    }

    HTML::importScript("define_todo");
    /** @var Todo $TodoManager */
    $TodoManager = DynamicalWeb::getMemoryObject("todo");

    try
    {
        $Task = $TodoManager->getTasksManager()->getTask(TaskSearchMethod::byPublicId, $_POST["task_id"]);
    }
    catch (TaskNotFoundException $e)
    {
        jsonResponse(false, 404, array(
            "error_code" => 100,
            "error_message" => "The requested task was not found"
        ));
    }
    catch(Exception $e)
    {
        jsonResponse(false, 500, array(
            "error_message" => "Internal server error"
        ));
    }

    if($Task->IsDeleted)
    {
        jsonResponse(false, 404, array(
            "error_code" => 100,
            "error_message" => "The requested task was not found"
        ));
    }

    if((int)$Task->AccountID !== (int)WEB_ACCOUNT_ID)
    {
        jsonResponse(false, 403, array(
            "error_code" => 101,
            "error_message" => "Invalid ownership or access to this task"
        ));
    }

    try
    {
        $Task->IsCompleted = true;
        $TodoManager->getTasksManager()->updateTask($Task);
    }
    catch (InvalidColorException $e)
    {
        jsonResponse(false, 400, array(
            "error_code" => 200,
            "error_message" => "Invalid Color"
        ));
    }
    catch (InvalidTaskDescriptionException $e)
    {
        jsonResponse(false, 400, array(
            "error_code" => 201,
            "error_message" => "Invalid Task Description"
        ));
    }
    catch (InvalidTaskTitleException $e)
    {
        jsonResponse(false, 400, array(
            "error_code" => 200,
            "error_message" => "Invalid Task Title"
        ));
    }
    catch (TaskNotFoundException $e)
    {
        jsonResponse(false, 404, array(
            "error_code" => 100,
            "error_message" => "The requested task was not found"
        ));
    }
    catch(Exception $e)
    {
        jsonResponse(false, 500, array(
            "error_message" => "Internal server error"
        ));
    }

    jsonResponse(true, 200);