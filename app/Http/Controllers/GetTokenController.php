<?php

namespace App\Http\Controllers;

use App\Services\TokenActionService;
use Exception;
use Illuminate\Http\Request;
use AmoCRM\Client\AmoCRMApiClient;

class GetTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $apiClient = new AmoCRMApiClient(env('client_id'), env('client_secret'), env('client_redirect_uri'));

        session_start();

        if (isset($_GET['referer'])) {
            $apiClient->setAccountBaseDomain($_GET['referer']);
        }


        if (!isset($_GET['code'])) {
            $state = bin2hex(random_bytes(16));
            $_SESSION['oauth2state'] = $state;

            $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
                    'state' => $state,
                    'mode' => 'post_message',
            ]);
            header('Location: ' . $authorizationUrl);
            die;
        } elseif (!isset($_GET['from_widget']) && (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state']))) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        }

        /**
         * Ловим обратный код
         */
        try {
            $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($_GET['code']);

            if (!$accessToken->hasExpired()) {
                (new TokenActionService())->saveToken([
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $apiClient->getAccountBaseDomain(),
                ]);
            }
        } catch (Exception $e) {
            die((string)$e);
        }

        $ownerDetails = $apiClient->getOAuthClient()->getResourceOwner($accessToken);

        printf('Hello, %s!', $ownerDetails->getName());
    }
}
