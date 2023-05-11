<?php

namespace Core\Middleware;

use Core\Response;

class CSRF
{
    public function handle(): void
    {
        if(!isset($_REQUEST['csrf_token'])) {
            Response::abort(Response::BAD_REQUEST);
        }
        if($_REQUEST['csrf_token'] !== $_SESSION['csrf_token']) {
            Response::abort(Response::BAD_REQUEST);
        }
        $_SESSION['csrf_token'] = '';
    }
}
