<?php
declare(strict_types=1);

namespace App\Lib;

class HashGenerationService
{
    private HashableInterface $hashable;

    /**
     * @param \App\Lib\HashableInterface $hashable hashable instance
     */
    public function __construct(HashableInterface $hashable)
    {
        $this->hashable = $hashable;
    }

    /**
     * Hash object
     *
     * @return string
     */
    public function crypt(): string
    {
        return hash(
            'sha512',
            hash('sha1', $this->hashable->getData())
        );
    }
}
