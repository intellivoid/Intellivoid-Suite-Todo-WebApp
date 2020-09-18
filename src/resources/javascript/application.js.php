<?php
    $SelectedGroup = "main";

    if(isset($_GET["group"]))
    {
        $SelectedGroup = $_GET["group"];
    }
?>
$(function() {
    "use strict";

    var $curr_task, $curr_task_id;
    var dynamical_web = {
        "resource_session_hash": "<?php print(hash("md5", time() . "DYNA")); ?>",
        "resource_name": "application.js",
        "compiled": true
    };

    // --------------------------------------------
    // Sidebar menu scrollbar
    // --------------------------------------------
    if ($('.todo-application .sidebar-menu-list').length > 0) {
        var content = new PerfectScrollbar('.sidebar-menu-list', {
            theme: "dark"
        });
    }

    // --------------------------------------------
    // Todo task list scrollbar
    // --------------------------------------------
    if ($('.todo-application .todo-task-list').length > 0) {
        var sidebar_todo = new PerfectScrollbar('.todo-task-list', {
            theme: "dark"
        });
    }


    // --------------------------------------------
    // Color tick click
    // --------------------------------------------
    $(document).on("click", ".todo-application .todo-item-color i", function(e) {
        var task_color = null;
        if ($(this).parent('.todo-item-color').hasClass("color-green")) {
            $(this).parent('.todo-item-color').removeClass("color-green");
            $(this).parent('.todo-item-color').addClass("color-red");
            $(this).parent('.todo-item-color').css("color", "#ea5455");
            $('.new-todo-item-color').prop("value", "1");
            task_color = "red";
        } else if ($(this).parent('.todo-item-color').hasClass("color-red")) {
            $(this).parent('.todo-item-color').removeClass("color-red");
            $(this).parent('.todo-item-color').addClass("color-yellow");
            $(this).parent('.todo-item-color').css("color", "#ff9f43");
            $('.new-todo-item-color').prop("value", "3");
            task_color = "yellow";
        } else if ($(this).parent('.todo-item-color').hasClass("color-yellow")) {
            $(this).parent('.todo-item-color').removeClass("color-yellow");
            $(this).parent('.todo-item-color').addClass("color-pink");
            $(this).parent('.todo-item-color').css("color", "#ff0198");
            $('.new-todo-item-color').prop("value", "5");
            task_color = "pink";
        } else if ($(this).parent('.todo-item-color').hasClass("color-pink")) {
            $(this).parent('.todo-item-color').removeClass("color-pink");
            $(this).parent('.todo-item-color').addClass("color-blue");
            $(this).parent('.todo-item-color').css("color", "#00cfe8");
            $('.new-todo-item-color').prop("value", "2");
            task_color = "blue";
        } else if ($(this).parent('.todo-item-color').hasClass("color-blue")) {
            $(this).parent('.todo-item-color').removeClass("color-blue");
            $(this).parent('.todo-item-color').addClass("color-none");
            $(this).parent('.todo-item-color').css("color", "#c2c6dc");
            $('.new-todo-item-color').prop("value", "0");
            task_color = "none";
        } else {
            $(this).parent('.todo-item-color').removeClass("color-none");
            $(this).parent('.todo-item-color').toggleClass("color-green");
            $(this).parent('.todo-item-color').css("color", "#28c76f");
            $('.new-todo-item-color').prop("value", "4");
            task_color = "green";
        }
        e.stopPropagation();
        if($(this).parent('.todo-item-color').hasClass("no-update") == false)
        {
            var task_id = $(this).closest('.todo-item').find('.todo-item-id').prop("value");
            $.ajax({
                type: "POST",
                url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
                data: {
                    "action": "update_task_color",
                    "task_id": task_id,
                    "color": task_color
                },
                error: function(xhr) {
                    if (xhr.responseJSON.success === false) {
                        <?php
                        $errorRedirectParameters = $_GET;
                        $errorRedirectParameters["callback"] = "ERROR_CODE";
                        ?>
                        var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                        $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                    }
                }
            });
        }
    });


    // --------------------------------------------
    // Favorite star click
    // --------------------------------------------
    $(document).on("click", ".todo-application .todo-item-favorite i", function(e) {
        $(this).parent('.todo-item-favorite').toggleClass("warning");
        e.stopPropagation();
    });

    // --------------------------------------------
    // Main menu toggle should hide app menu
    // --------------------------------------------
    $('.menu-toggle').on('click', function(e) {
        $('.app-content .sidebar-left').removeClass('show');
        $('.app-content .app-content-overlay').removeClass('show');
    });

    // --------------------------------------------
    // On sidebar close click
    // --------------------------------------------
    $(".todo-application .sidebar-close-icon").on('click', function() {
        $('.sidebar-left').removeClass('show');
        $('.app-content-overlay').removeClass('show');
    });

    // --------------------------------------------
    // Todo sidebar toggle
    // --------------------------------------------
    $('.sidebar-toggle').on('click', function(e) {
        e.stopPropagation();
        $('.app-content .sidebar-left').toggleClass('show');
        $('.app-content .app-content-overlay').addClass('show');
    });
    $('.app-content .app-content-overlay').on('click', function(e) {
        $('.app-content .sidebar-left').removeClass('show');
        $('.app-content .app-content-overlay').removeClass('show');
    });

    // --------------------------------------------
    // Add class active on click of sidebar filters list
    // --------------------------------------------
    $(".todo-application .list-group-filters a").on('click', function() {
        if ($('.todo-application .list-group-filters a').hasClass('active')) {
            $('.todo-application .list-group-filters a').removeClass('active');
        }
        $(this).addClass("active");
    });

    // --------------------------------------------
    // For chat sidebar on small screen
    // --------------------------------------------
    if ($(window).width() > 992) {
        if ($('.todo-application .app-content-overlay').hasClass('show')) {
            $('.todo-application .app-content-overlay').removeClass('show');
        }
    }

    // --------------------------------------------
    // On add new item, clear modal popup fields
    // --------------------------------------------
    //$(".add-task button").on('click', function(e){
    //  $('.modal .new-todo-item-title').val("");
    //  $('.modal .new-todo-item-desc').val("");
    //  $('.modal .dropdown-menu input').prop("checked", false);
    //  if($('.modal .todo-item-color').hasClass('success')){$('.modal .todo-item-color').removeClass('success')}
    //  if($('.modal .todo-item-favorite').hasClass('warning')){$('.modal .todo-item-favorite').removeClass('warning')}
    //});


    // --------------------------------------------
    // Add New ToDo List Item
    // --------------------------------------------


    // To add new todo list item
    $(".add-todo-item").on('click', function(e) {
        e.preventDefault();
        var todoColor = $(".new-todo-item-color").prop("value");
        var todoTitle = $(".new-todo-item-title").val();
        var todoDesc = $(".new-todo-item-desc").val();
        <?php
            $CreateTaskParameters = $_GET;
            $CreateTaskParameters["action"] = "create_task";
        ?>

        if (todoTitle != "") {
            $.redirectPost("<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $CreateTaskParameters, true); ?>",
            {
                "color": encodeURIComponent(todoColor),
                "title": encodeURIComponent(todoTitle),
                "description": encodeURIComponent(todoDesc),
                "group": "<?php \DynamicalWeb\HTML::print($SelectedGroup); ?>"
            });
        }
    });


    // --------------------------------------------
    // Create New Group
    // --------------------------------------------

    // To create a new group
    $(".add-group-item").on('click', function(e) {
        e.preventDefault();
        var groupName = $(".new-group-item-name").val();

        // HTML Output
        if (groupName != "") {
            $.redirectPost("<?php \DynamicalWeb\DynamicalWeb::getRoute("index", array("action" => "create_group"), true); ?>",
            {
                "name": groupName
            });
        }
    });

    // --------------------------------------------
    // Edit Selected Group
    // --------------------------------------------

    // To edit the existing group
    $(".edit-group-item").on('click', function(e) {
        e.preventDefault();
        var groupName = $(".edit-group-item-name").val();
        if (groupName != "") {
            $.redirectPost("<?php \DynamicalWeb\DynamicalWeb::getRoute("index", array("action" => "edit_group_name", "group" => $SelectedGroup), true); ?>",
                {
                    "name": groupName
                });
        }
    });

    // --------------------------------------------
    // Deleted Selected Group
    // --------------------------------------------

    // To edit the existing group
    $(".delete-group-item").on('click', function(e) {
        e.preventDefault();
        $.redirectPost("<?php \DynamicalWeb\DynamicalWeb::getRoute("index", array("action" => "delete_group", "group" => $SelectedGroup), true); ?>", {});
    });

    // --------------------------------------------
    // To update todo list item
    // --------------------------------------------
    $(document).on('click', ".todo-task-list-wrapper .todo-item", function(e) {

        // Saving all values in variable
        $curr_task = $(this); // Set path for Current Title, use this variable when updating title
        $curr_task_id = $(this).find('.todo-item-id').prop("value"); // Set the current Task ID, use this variable when updating the task

        var $title = $(this).find('.todo-title').text();
        var $desc = $(this).find('.todo-desc').text();
        var curr_color = $(this).find('.todo-item-color');

        // apply all variable values to fields
        $('#form-edit-todo .edit-todo-item-title').val($title);
        $('#form-edit-todo .edit-todo-item-desc').val($desc);

        // Remove the current properties
        if ($('#form-edit-todo .todo-item-color').hasClass("color-green")){
            $('#form-edit-todo .todo-item-color').removeClass("color-green");
        }
        if ($('#form-edit-todo .todo-item-color').hasClass("color-red")){
            $('#form-edit-todo .todo-item-color').removeClass("color-red");
        }
        if ($('#form-edit-todo .todo-item-color').hasClass("color-yellow")){
            $('#form-edit-todo .todo-item-color').removeClass("color-yellow");
        }
        if ($('#form-edit-todo .todo-item-color').hasClass("color-pink")){
            $('#form-edit-todo .todo-item-color').removeClass("color-pink");
        }
        if ($('#form-edit-todo .todo-item-color').hasClass("color-blue")){
            $('#form-edit-todo .todo-item-color').removeClass("color-blue");
        }
        if ($('#form-edit-todo .todo-item-color').hasClass("color-none")){
            $('#form-edit-todo .todo-item-color').removeClass("color-none");
        }

        if (curr_color.hasClass("color-green")) {
            $('#form-edit-todo .todo-item-color').addClass("color-green");
            $('#form-edit-todo .todo-item-color').css("color", "#28c76f");
            $('#form-edit-todo .todo-item-color-value').prop("value", "4");
        } else if (curr_color.hasClass("color-red")) {
            $('#form-edit-todo .todo-item-color').addClass("color-red");
            $('#form-edit-todo .todo-item-color').css("color", "#ea5455");
            $('#form-edit-todo .todo-item-color-value').prop("value", "1");
        } else if (curr_color.hasClass("color-yellow")) {
            $('#form-edit-todo .todo-item-color').addClass("color-yellow");
            $('#form-edit-todo .todo-item-color').css("color", "#ff9f43");
            $('#form-edit-todo .todo-item-color-value').prop("value", "3");
        } else if (curr_color.hasClass("color-pink")) {
            $('#form-edit-todo .todo-item-color').addClass("color-pink");
            $('#form-edit-todo .todo-item-color').css("color", "#ff0198");
            $('#form-edit-todo .todo-item-color-value').prop("value", "5");
        } else if (curr_color.hasClass("color-blue")) {
            $('#form-edit-todo .todo-item-color').addClass("color-blue");
            $('#form-edit-todo .todo-item-color').css("color", "#00cfe8");
            $('#form-edit-todo .todo-item-color-value').prop("value", "2");
        } else {
            $('#form-edit-todo .todo-item-color').addClass("color-none");
            $('#form-edit-todo .todo-item-color').css("color", "#c2c6dc");
            $('#form-edit-todo .todo-item-color-value').prop("value", "0");
        }
    });


    // --------------------------------------------
    // Updating Data Values to Fields
    // --------------------------------------------
    $('.update-todo-item').on('click', function() {
        var $edit_title = $('#form-edit-todo .edit-todo-item-title').val();
        var $edit_desc = $('#form-edit-todo .edit-todo-item-desc').val();
        var $edit_color = $('#form-edit-todo .todo-item-color');
        var $edit_color_val = $('#form-edit-todo .todo-item-color-value').prop("value");

        $($curr_task).find(".todo-title").text($edit_title);
        $($curr_task).find(".todo-desc").text($edit_desc);

        if ($($curr_task).find(".todo-item-color").hasClass("color-green")){
            $($curr_task).find(".todo-item-color").removeClass("color-green");
        }
        if ($($curr_task).find(".todo-item-color").hasClass("color-red")){
            $($curr_task).find(".todo-item-color").removeClass("color-red");
        }
        if ($($curr_task).find(".todo-item-color").hasClass("color-yellow")){
            $($curr_task).find(".todo-item-color").removeClass("color-yellow");
        }
        if ($($curr_task).find(".todo-item-color").hasClass("color-pink")){
            $($curr_task).find(".todo-item-color").removeClass("color-pink");
        }
        if ($($curr_task).find(".todo-item-color").hasClass("color-blue")){
            $($curr_task).find(".todo-item-color").removeClass("color-blue");
        }
        if ($($curr_task).find(".todo-item-color").hasClass("color-none")){
            $($curr_task).find(".todo-item-color").removeClass("color-none");
        }

        if ($edit_color.hasClass("color-green")) {
            $($curr_task).find(".todo-item-color").addClass("color-green");
            $($curr_task).find(".todo-item-color").css("color", "#28c76f");
        } else if ($edit_color.hasClass("color-red")) {
            $($curr_task).find(".todo-item-color").addClass("color-red");
            $($curr_task).find(".todo-item-color").css("color", "#ea5455");
        } else if ($edit_color.hasClass("color-yellow")) {
            $($curr_task).find(".todo-item-color").addClass("color-yellow");
            $($curr_task).find(".todo-item-color").css("color", "#ff9f43");
        } else if ($edit_color.hasClass("color-pink")) {
            $($curr_task).find(".todo-item-color").addClass("color-pink");
            $($curr_task).find(".todo-item-color").css("color", "#ff0198");
        } else if ($edit_color.hasClass("color-blue")) {
            $($curr_task).find(".todo-item-color").addClass("color-blue");
            $($curr_task).find(".todo-item-color").css("color", "#00cfe8");
        } else {
            $($curr_task).find(".todo-item-color").addClass("color-none");
            $($curr_task).find(".todo-item-color").css("color", "#c2c6dc");
        }

        // Update the task
        $.ajax({
            type: "POST",
            url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
            data: {
                "action": "update_task",
                "task_id": encodeURIComponent($curr_task_id),
                "color": encodeURIComponent($edit_color_val),
                "title": encodeURIComponent($edit_title),
                "description": encodeURIComponent($edit_desc)
            },
            error: function(xhr) {
                if (xhr.responseJSON.success === false) {
                    <?php
                    $errorRedirectParameters = $_GET;
                    $errorRedirectParameters["callback"] = "ERROR_CODE";
                    ?>
                    var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                    $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                }
            }
        });


    });


    // --------------------------------------------
    //EVENT DELETION
    // --------------------------------------------
    $(document).on('click', '.todo-item-delete', function(e) {
        var item = this;
        e.stopPropagation();
        $(item).closest('.todo-item').remove();
        var task_id = $(this).closest('.todo-item').find('.todo-item-id').prop("value");
        $.ajax({
            type: "POST",
            url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
            data: {
                "action": "delete_task",
                "task_id": task_id
            },
            error: function(xhr) {
                if (xhr.responseJSON.success === false) {
                    <?php
                    $errorRedirectParameters = $_GET;
                    $errorRedirectParameters["callback"] = "ERROR_CODE";
                    ?>
                    var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                    $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                }
            }
        });

        var tbl_row = $(".todo-item:visible").length; //here tbl_test is table name

        //Check if table has row or not
        if (tbl_row == 0) {
            if (!$('.no-items').hasClass('show')) {
                $('.no-items').addClass('show');
            }
        } else {
            $('.no-items').removeClass('show');

        }
    });

    $(document).on('click', '.todo-item-restore', function(e) {
        var item = this;
        e.stopPropagation();
        $(item).closest('.todo-item').remove();
        var task_id = $(this).closest('.todo-item').find('.todo-item-id').prop("value");
        $.ajax({
            type: "POST",
            url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
            data: {
                "action": "restore_task",
                "task_id": task_id
            },
            error: function(xhr) {
                if (xhr.responseJSON.success === false) {
                    <?php
                    $errorRedirectParameters = $_GET;
                    $errorRedirectParameters["callback"] = "ERROR_CODE";
                    ?>
                    var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                    $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                }
            }
        });

        var tbl_row = $(".todo-item:visible").length; //here tbl_test is table name

        //Check if table has row or not
        if (tbl_row == 0) {
            if (!$('.no-items').hasClass('show')) {
                $('.no-items').addClass('show');
            }
        } else {
            $('.no-items').removeClass('show');

        }
    });

    $(document).on('click', '.todo-item-perma-delete', function(e) {
        var item = this;
        e.stopPropagation();
        $(item).closest('.todo-item').remove();
        var task_id = $(this).closest('.todo-item').find('.todo-item-id').prop("value");
        $.ajax({
            type: "POST",
            url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
            data: {
                "action": "perma_delete_task",
                "task_id": task_id
            },
            error: function(xhr) {
                if (xhr.responseJSON.success === false) {
                    <?php
                    $errorRedirectParameters = $_GET;
                    $errorRedirectParameters["callback"] = "ERROR_CODE";
                    ?>
                    var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                    $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                }
            }
        });

        var tbl_row = $(".todo-item:visible").length; //here tbl_test is table name

        //Check if table has row or not
        if (tbl_row == 0) {
            if (!$('.no-items').hasClass('show')) {
                $('.no-items').addClass('show');
            }
        } else {
            $('.no-items').removeClass('show');

        }
    });

    // Complete task strike through
    $(document).on('click', '.todo-item input', function(event) {
        event.stopPropagation();
        $(this).closest('.todo-item').toggleClass("completed");

        var task_id = $(this).closest('.todo-item').find('.todo-item-id').prop("value");
        if ($(this).closest('.todo-item').find('.todo-check').prop("checked")) {
            $.ajax({
                type: "POST",
                url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
                data: {
                    "action": "mark_completed",
                    "task_id": task_id
                },
                error: function(xhr) {
                    if (xhr.responseJSON.success === false) {
                        <?php
                        $errorRedirectParameters = $_GET;
                        $errorRedirectParameters["callback"] = "ERROR_CODE";
                        ?>
                        var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                        $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "<?php \DynamicalWeb\DynamicalWeb::getRoute("api", [], true); ?>",
                data: {
                    "action": "mark_not_completed",
                    "task_id": task_id
                },
                error: function(xhr) {
                    if (xhr.responseJSON.success === false) {
                        <?php
                        $errorRedirectParameters = $_GET;
                        $errorRedirectParameters["callback"] = "ERROR_CODE";
                        ?>
                        var redirectUrl = "<?php \DynamicalWeb\DynamicalWeb::getRoute("index", $errorRedirectParameters, true); ?>";
                        $.redirectPost(redirectUrl.replace("ERROR_CODE", xhr.responseJSON.error_code), {});
                    }
                }
            });

        }

    });


    // --------------------------------------------
    // Filter
    // --------------------------------------------
    $("#todo-search").on("keyup", function() {
        if ($('.no-items').hasClass('show')) {
            return;
        }

        var value = $(this).val().toLowerCase();
        if (value != "") {
            $(".todo-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
            var tbl_row = $(".todo-item:visible").length; //here tbl_test is table name

            //Check if table has row or not
            if (tbl_row == 0) {
                if (!$('.no-results').hasClass('show')) {
                    $('.no-results').addClass('show');
                }
            } else {
                $('.no-results').removeClass('show');

            }
        } else {
            // If filter box is empty
            $(".todo-item").show();
            if ($('.no-results').hasClass('show')) {
                $('.no-results').removeClass('show');
            }
        }
    });

});

$(window).on("resize", function() {
    // remove show classes from sidebar and overlay if size is > 992
    if ($(window).width() > 992) {
        if ($('.app-content .app-content-overlay').hasClass('show')) {
            $('.app-content .sidebar-left').removeClass('show');
            $('.app-content .app-content-overlay').removeClass('show');
        }
    }
});

$.extend({
    redirectPost: function(location, args) {
        var form = '';
        $.each(args, function(key, value) {
            value = value.split('"').join('\"')
            form += '<input type="hidden" name="' + key + '" value="' + value + '">';
        });
        $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
    },
});