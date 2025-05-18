<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMService
{
  protected $messaging;

  public function __construct()
  {
    $factory = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
    $this->messaging = $factory->createMessaging();
  }

  public function sendNotificationToToken(string $deviceToken, string $title, string $body): void
  {
    $message = CloudMessage::withTarget('token', $deviceToken)
      ->withNotification(Notification::create($title, $body));

    $this->messaging->send($message);
  }
}
