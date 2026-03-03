<?php

namespace App\Model;

trait Timestampable
{
    private string $createdAt;
    private string $updatedAt;

    public function setTimestamps(): void
    {
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    public function updateTimestamp(): void
    {
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    public function getTimestamps(): array
    {
        return [
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}