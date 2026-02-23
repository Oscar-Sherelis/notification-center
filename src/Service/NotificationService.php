<?php

namespace App\Service;

use App\Repository\UserRepository;
class NotificationService
{
    public function __construct(
        private UserRepository $userRepository,
        private iterable $rules
    ) {}

    public function getNotificationsForUser(int $userId): array
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            return [];
        }

        $notifications = [];

        foreach ($this->rules as $rule) {
            if ($rule->supports($user)) {
                $notifications[] = $rule->getNotification();
            }
        }

        return $notifications;
    }
}
