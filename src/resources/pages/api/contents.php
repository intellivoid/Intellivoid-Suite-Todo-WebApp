<?php

    use DynamicalWeb\HTML;

    /**
     * Returns the JSON Results
     * if the status is false then the results needs to have "error_code" and "error_message"
     * if the status is true then the results would be returned as the payload
     *
     * @param bool $success
     * @param int $status_code
     * @param array $results
     * @noinspection PhpUnused
     */
    function jsonResponse(bool $success, int $status_code, array $results=null)
    {
        if($success == false)
        {
            $Response = array(
                "success" => false,
                "status_code" => $status_code,
                "error_message" => $results["error_message"]
            );

            if(isset($results["error_code"]))
            {
                $Response["error_code"] = $results["error_code"];
            }
        }
        else
        {
            $Response = array(
                "success" => true,
                "status_code" => $status_code
            );

            if($results !== null)
            {
                $Response["payload"] = $results;
            }
        }

        $ResponseEncoded = json_encode($Response);

        http_response_code($status_code);
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($ResponseEncoded));
        print($ResponseEncoded);
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] !== "POST")
    {
        jsonResponse(false, 405, array(
            "error_message" => "Method Not Allowed"
        ));
    }
    else
    {
        if(isset($_POST["action"]) == false)
        {
            jsonResponse(false, 400, array(
                "error_message" => "The parameter 'action' is missing"
            ));
        }

        switch(strtolower($_POST["action"]))
        {
            case "mark_completed":
                HTML::importScript("mark_completed");
                break;

            case "mark_not_completed":
                HTML::importScript("mark_not_completed");
                break;

            case "delete_task":
                HTML::importScript("delete_task");
                break;

            case "restore_task":
                HTML::importScript("restore_task");
                break;

            case "perma_delete_task":
                HTML::importScript("perma_delete_task");
                break;

            default:
                jsonResponse(false, 400, array(
                    "error_message" => "The action '" . $_POST["action"] . "' is not valid"
                ));
        }
    }