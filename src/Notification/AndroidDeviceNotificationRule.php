<?php

namespace App\Notification;

use App\Entity\User;
use App\Domain\Notification;

class AndroidDeviceNotificationRule implements NotificationRuleInterface
{
    public function supports(User $user): bool
    {

        // Rule 1: not premium
        if ($user->isPremium()) {
            return false;
        }

        // Rule 2: country ES
        if ($user->getCountryCode() !== 'ES') {
            return false;
        }

        // Rule 3: not active during last week
        $oneWeekAgo = new \DateTimeImmutable('-7 days');
        if ($user->getLastActiveAt() >= $oneWeekAgo) {
            return false;
        }

        // Rule 4: no Android device
        foreach ($user->getDevices() as $device) {
            if (strtolower($device->getPlatform()) === 'android') {
                return false;
            }
        }

        return true;
    }

    public function getNotification(): Notification
    {
        return new Notification(
            title: 'Configurar dispositivo Android',
            description: 'Phasellus rhoncus ante dolor, at semper metus aliquam quis. Praesent finibus pharetra libero, ut feugiat mauris dapibus blandit. Donec sit.',
            cta: 'https://trendos.com/'
        );
    }
}