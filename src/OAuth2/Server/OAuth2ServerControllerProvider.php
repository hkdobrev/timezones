<?php

namespace Timezones\OAuth2\Server;

use Silex\Application;
use Silex\ControllerProviderInterface;
use OAuth2\HttpFoundationBridge\Response as BridgeResponse;
use OAuth2\Server as OAuth2Server;
use Timezones\OAuth2\Storage\Pdo;
use Timezones\OAuth2\Storage\Memory;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\UserCredentials;
use OAuth2\GrantType\RefreshToken;
use OAuth2;

class OAuth2ServerControllerProvider implements ControllerProviderInterface
{
    /**
     * function to create the OAuth2 Server Object
     */
    public function setup(Application $app)
    {
        // instantiate the oauth server
        $server = new OAuth2Server([], [], [], [], new OAuth2\TokenType\Bearer([
            'token_param_name' => 'token',
        ]));
        $server->setConfig('enforce_state', true);
        $server->setConfig('allow_implicit', true);
        $server->setConfig('use_crypto_tokens', true);

        // create PDO-based storage
        $storage = new Pdo($app['db']);
        $server->addStorage($storage);

        $server->addGrantType(new UserCredentials($storage));
        $server->addGrantType(new RefreshToken($storage, [
            'always_issue_new_refresh_token' => true,
        ]));

        // public key strings can be passed in however you like
        $publicKey  = file_get_contents($app['oauth']['keys']['public']);
        $privateKey  = file_get_contents($app['oauth']['keys']['private']);

        // create key storage
        $keyStorage = new OAuth2\Storage\Memory([
            'keys' => array(
                'public_key'  => $publicKey,
                'private_key' => $privateKey,
            ),
            // add a Client ID for testing
            'client_credentials' => [
                'CLIENT_ID' => ['client_secret' => $app['oauth']['client_secret']]
            ],
        ]);

        // make the "token" response type a CryptoToken
        $server->addResponseType(new OAuth2\ResponseType\CryptoToken($keyStorage), 'token');

        // Make the "access_token" storage use Crypto Tokens (JWTokens) instead of a database
        $cryptoStorage = new OAuth2\Storage\CryptoToken($keyStorage);

        $server->addStorage($cryptoStorage, 'access_token');

        // add the server to the silex "container" so we can use it in our controllers (see src/OAuth/Controller/.*)
        $app['oauth_server'] = $server;

        /**
         * add HttpFoundataionBridge Response to the container, which returns a silex-compatible response object
         * @link https://github.com/bshaffer/oauth2-server-httpfoundation-bridge
         */
        $app['oauth_response'] = new BridgeResponse();
    }

    /**
     * Connect the controller classes to the routes
     */
    public function connect(Application $app)
    {
        // create the oauth2 server object
        $this->setup($app);

        // creates a new controller based on the default route
        $routing = $app['controllers_factory'];

        /* Set corresponding endpoints on the controller classes */
        Controller\TokenController::addRoutes($routing);
        Controller\ResourceController::addRoutes($routing);

        return $routing;
    }
}
