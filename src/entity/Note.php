<?php

declare(strict_types=1);

namespace App\Entity;

class Note
{
    public function __construct(
        private ?int $id,
        private int $userId,
        private string $title,
        private string $content,
        private bool $isShared
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isShared(): bool
    {
        return $this->isShared;
    }
}