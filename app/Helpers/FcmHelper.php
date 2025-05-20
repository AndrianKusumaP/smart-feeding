<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class FcmHelper
{
  public static function getAccessToken(): string
  {
    $serviceAccount = json_decode(file_get_contents(base_path(env('FIREBASE_CREDENTIALS'))), true);

    $now = time();
    $payload = [
      'iss' => $serviceAccount['client_email'],
      'sub' => $serviceAccount['client_email'],
      'aud' => 'https://oauth2.googleapis.com/token',
      'iat' => $now,
      'exp' => $now + 3600,
      'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    ];

    $jwt = JWT::encode($payload, $serviceAccount['private_key'], 'RS256');

    $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
      'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
      'assertion' => $jwt,
    ]);

    return $response->json('access_token');
  }

  public static function sendNotification(string $token, string $title, string $body): array
  {
    $accessToken = self::getAccessToken();
    $projectId   = env('FIREBASE_PROJECT_ID');

    $payload = [
      'message' => [
        'token'        => $token,

        // (opsional) tetap boleh menambah data custom
        'data' => [
          'title' => $title,
          'body'  => $body,
        ],
      ],
    ];

    return Http::withToken($accessToken)
      ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload)
      ->json();
  }
}
