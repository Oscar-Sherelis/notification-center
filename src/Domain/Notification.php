<?php

namespace App\Domain;

class Notification
{
    public function __construct(
        private string $title,
        private string $description,
        private string $cta
    ) {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'cta' => $this->cta,
        ];
    }
}