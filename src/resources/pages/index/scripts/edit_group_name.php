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
            if($_GET["action"] == "edit_group_name")
            {
                editGroupName();
            }
        }
    }

    function editGroupName()
    {
        if(isset($_GET["group"]) == false)
        {
            return;
        }

        $NewTitle = null;

        if(isset($_POST["name"]))
        {
            $NewTitle = $_POST["name"];
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
                "callback" => "105", "resource" => "edit_group_name"
            )));
            return;
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "104", "resource" => "edit_group_name"
            )));
            return;
        }

        if($Group->AccountID !== WEB_ACCOUNT_ID)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "105", "resource" => "edit_group_name"
            )));
        }

        if($Group->IsDeleted)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "105", "resource" => "edit_group_name"
            )));
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        if(Validation::groupTitle($NewTitle, false) == false)
        {
            $Parameters = $_GET;
            $Parameters["action"] = "none";
            $Parameters["callback"] = "103";
            $Parameters["resource"] = "edit_group_name";
            Actions::redirect(DynamicalWeb::getRoute("index", $Parameters));
        }

        $Group->Title = $NewTitle;

        try
        {
            $TodoManager->getGroupManager()->updateGroup($Group);
        }
        catch (InvalidGroupTitleException $e)
        {
            $Parameters = $_GET;
            $Parameters["action"] = "none";
            $Parameters["callback"] = "103";
            $Parameters["resource"] = "edit_group_name";
            Actions::redirect(DynamicalWeb::getRoute("index", $Parameters));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", array(
                "callback" => "100", "resource" => "edit_group_name"
            )));
            return;
        }

        $Parameters = $_GET;
        $Parameters["action"] = "none";
        $Parameters["callback"] = "none";
        Actions::redirect(DynamicalWeb::getRoute("index", $Parameters));
    }