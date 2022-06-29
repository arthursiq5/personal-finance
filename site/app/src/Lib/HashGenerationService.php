<?php

namespace App\Lib;

class HashGenerationService
{
    private HashableInterface $hashable;
    public function __construct(HashableInterface $hashable)
    {
        $this->hashable = $hashable;
    }

    public function crypt(): string
    {
        return hash('sha512',
            hash('sha1', $this->hashable->getData())
        );
    }
}
