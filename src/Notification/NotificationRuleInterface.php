<?php

namespace App\Notification;

use App\Entity\User;
use App\Domain\Notification;

interface NotificationRuleInterface
{
    public function supports(User $user): bool;

    public function getNotification(): Notification;
}