<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Abstracts\SearchMethods\GroupSearchMethod;
    use Todo\Exceptions\GroupNotFoundException;
    use Todo\Todo;

    HTML::importScript("define_todo");

    if(isset($_GET["group"]))
    {
        defineGroupObject();
    }

    /**
     * Defines the group object if one is selected
     */
    function defineGroupObject()
    {
        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");

        try
        {
            $Group = $TodoManager->getGroupManager()->getGroup(
                GroupSearchMethod::byPublicId, $_GET["group"]
            );
        }
        catch (GroupNotFoundException $e)
        {
            return;
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute("index", ["callback" => "104"]));
            return;
        }

        if($Group->AccountID !== WEB_ACCOUNT_ID)
        {
            return;
        }

        if($Group->IsDeleted)
        {
            return;
        }

        DynamicalWeb::setMemoryObject("selected_group", $Group);
        DynamicalWeb::setMemoryObject("group_" . $Group->ID, $Group);

        return;
    }