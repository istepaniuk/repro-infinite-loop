<?php declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;

class Controller
{
    public function __invoke(Request $request)
    {
        require "non_existing_file.php";
    }
}
