<?php

namespace App\Notification;

use App\Entity\User;

class NotificationResolver
{

    public function __construct(
        private iterable $rules
    ) {}
    public function resolve(User $user): array
    {
        $notifications = [];

        foreach ($this->rules as $rule) {
            if ($rule->supports($user)) {
                $notifications[] = $rule->getNotification($user);
            }
        }

        return $notifications;
    }
}
