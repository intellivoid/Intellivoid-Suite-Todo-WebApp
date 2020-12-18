<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Page;
    use DynamicalWeb\Runtime;
    use sws\sws;

    Runtime::import('SecuredWebSessions');

    /** @var sws $sws */
    $sws = DynamicalWeb::setMemoryObject('sws', new sws());
    $Cookie = null;

    if($sws->WebManager()->isCookieValid('todo_session') == false)
    {
        $Cookie = $sws->CookieManager()->newCookie('todo_session', 86400, false);

        $Cookie->Data = array(
            "session_active" => false,
            "account_pubid" => null,
            "account_id" => null,
            "account_username" => null,
            "access_token" => null,
            "cache" => array(),
            "cache_refresh" => 0,
        );

        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->setCookie($Cookie);

        if($Cookie->Name == null)
        {
            print('There was an issue with the security check, Please refresh the page');
            exit();
        }

        header('Refresh: ' . 2 . ' URL=' . DynamicalWeb::getRoute('index'));
        HTML::importScript('loading_splash');
        exit();
    }

    try
    {
        if($Cookie == null)
        {
            $Cookie = $sws->WebManager()->getCookie('todo_session');
        }
    }
    catch(Exception $exception)
    {
        Page::staticResponse(
            'Web Applications Error',
            'Web Sessions Issue',
            'There was an issue with your Web Session, try clearing your cookies and try again'
        );
        exit();
    }

    DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);

    define('WEB_SESSION_ACTIVE', $Cookie->Data['session_active']);
    define('WEB_ACCOUNT_PUBID', $Cookie->Data['account_pubid']);
    define('WEB_ACCOUNT_ID', $Cookie->Data['account_id']);
    define('WEB_ACCOUNT_USERNAME', $Cookie->Data['account_username']);
    define('WEB_ACCESS_TOKEN', $Cookie->Data['access_token']);

    if(isset($Cookie->Data["account_email"]) == false)
    {
        define('WEB_ACCESS_EMAIL', "");
    }
    else
    {
        define('WEB_ACCESS_EMAIL', $Cookie->Data['account_email']);
    }