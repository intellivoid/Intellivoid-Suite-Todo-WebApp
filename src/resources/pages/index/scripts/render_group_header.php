<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Objects\Group;

    if(isset(DynamicalWeb::$globalObjects["selected_group"]))
    {
        /** @var Group $Group */
        $Group = DynamicalWeb::getMemoryObject("selected_group");
        ?>
        <div class="app-fixed-info d-flex justify-content-between">
            <div class="align-items-center">
                <!-- <a class="color-yellow mr-1" style="color: #ff9f43;"> -->
                <!--     <i class="feather icon-circle"></i> -->
                <!-- </a> -->
                <a href="#" style="color: #c2c6dc;"><?PHP HTML::print($Group->Title); ?></a>
            </div>

            <div class="float-right">
                <a class="todo-item-restore text-light pr-1" data-toggle="modal" data-target="#editGroupModal">
                    <i class="feather icon-edit"></i>
                </a>
                <a class="todo-item-restore text-light pr-1" data-toggle="modal" data-target="#deleteGroupModal">
                    <i class="feather icon-trash"></i>
                </a>
            </div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="app-fixed-info d-flex justify-content-between">
            <div class="align-items-center">
                <a href="#" style="color: #c2c6dc;">All Tasks</a>
            </div>
        </div>
        <?PHP
    }