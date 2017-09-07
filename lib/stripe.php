<?php
require('vendor/stripe/stripe-php/init.php');
\Stripe\Stripe::setApiKey(getenv('sk_test_NGhHYalwJsohYuZwUj4bOF2P
'));
\Stripe\Stripe::setClientId(getenv('pk_test_7THr5gIT0kFYW3bawLLHFXUO'));
if (isset($_GET['code'])) {
    // The user was redirected back from the OAuth form with an authorization code.
    $code = $_GET['code'];
    try {
        $resp = \Stripe\OAuth::token(array(
            'grant_type' => 'authorization_code',
            'code' => $code,
        ));
    } catch (\Stripe\Error\OAuth\OAuthBase $e) {
        exit("Error: " . $e->getMessage());
    }
    $accountId = $resp->stripe_user_id;
    echo "<p>Success! Account <code>$accountId</code> is connected.</p>\n";
    echo "<p>Click <a href=\"?deauth=$accountId\">here</a> to disconnect the account.</p>\n";
} elseif (isset($_GET['error'])) {
    // The user was redirect back from the OAuth form with an error.
    $error = $_GET['error'];
    $error_description = $_GET['error_description'];
    echo "<p>Error: code=$error, description=$error_description</p>\n";
    echo "<p>Click <a href=\"?\">here</a> to restart the OAuth flow.</p>\n";
} elseif (isset($_GET['deauth'])) {
    // Deauthorization request
    $accountId = $_GET['deauth'];
    try {
        \Stripe\OAuth::deauthorize(array(
            'stripe_user_id' => $accountId,
        ));
    } catch (\Stripe\Error\OAuth\OAuthBase $e) {
        exit("Error: " . $e->getMessage());
    }
    echo "<p>Success! Account <code>$accountId</code> is disonnected.</p>\n";
    echo "<p>Click <a href=\"?\">here</a> to restart the OAuth flow.</p>\n";
} else {
    $url = \Stripe\OAuth::authorizeUrl(array(
        'scope' => 'read_only',
    ));
    echo "<a href=\"$url\">Connect with Stripe</a>\n";
}