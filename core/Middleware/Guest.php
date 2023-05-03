<?php

namespace Core\Middleware;

class Guest
{
    public function handle(): void
    {
        if (isset($_SESSION['user'])) {
            header("Location: /");
            exit;
        }
    }
}
