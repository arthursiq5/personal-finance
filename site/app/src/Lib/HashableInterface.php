<?php
declare(strict_types=1);

namespace App\Lib;

interface HashableInterface
{
    public function getData(): string;
}
