<?php
declare(strict_types=1);

namespace App\Lib;

interface HashableInterface
{
    /**
     * @return string
     */
    public function getData(): string;
}
