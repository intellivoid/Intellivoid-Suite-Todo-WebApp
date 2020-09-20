<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use Todo\Objects\Group;
use Todo\Todo;

    HTML::importScript("define_todo");

    function renderGroups()
    {
        /** @var Todo $TodoManager */
        $TodoManager = DynamicalWeb::getMemoryObject("todo");
        $Groups = $TodoManager->getGroupManager()->getGroups(WEB_ACCOUNT_ID);

        if(count($Groups) > 0)
        {
            foreach($Groups as $group)
            {
                renderGroupItem($group);
            }
        }
        else
        {
            ?>
            <img src="/assets/images/undraw/no_groups.svg" alt="No Groups" class="img-fluid my-2" style="height: 126px;">
            <h4 class="text-center mb-2"><?PHP HTML::print(TEXT_PLACEHOLDER_NO_GROUPS); ?></h4>
            <?php
        }
    }

    /**
     * Renders the HTML code for a group item
     *
     * @param Group $group
     */
    function renderGroupItem(Group $group)
    {
        $Parameters = $_GET;
        $Parameters["group"] = $group->PublicID;
        $CurrentGroup = "main";

        if(isset($_GET["group"]))
        {
            $CurrentGroup = $_GET["group"];
        }

        ?>
        <a href="<?PHP DynamicalWeb::getRoute("index", $Parameters, true); ?>" class="list-group-item list-group-item-action border-0 d-flex align-items-center<?PHP if($CurrentGroup == $group->PublicID){ HTML::print(" active"); } ?>">
            <!-- <span class="bullet bullet-warning mr-1"></span> -->
            <?PHP HTML::print($group->Title); ?>
        </a>
        <?php
    }