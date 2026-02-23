<?php

namespace App\Controller;

use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/notifications', methods: ['GET'])]
    public function preview(
        Request $request,
        NotificationService $notificationService
    ): JsonResponse {

        $userId = (int) $request->query->get('user_id');

        if (!$userId) {
            return $this->json(['error' => 'user_id is required'], 400);
        }

        $notifications = $notificationService->getNotificationsForUser($userId);

        return $this->json($notifications);
    }
}
