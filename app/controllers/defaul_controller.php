<?php

class DefaultController extends BaseController{

	public static function index(){
		View::make('index.html', array('account_logged_in' => self::get_account_logged_in()));
	}

	public static function offset(){
		View::make('offset/subscribe.html', array('account_logged_in' => self::get_account_logged_in(), 'carbon' => self::get_carbon()));
	}

	public static function offset_complete(){
		$params = $_POST;
		$_SESSION['amount'] = $params['amount'];
		$_SESSION['offset'] = true;
		if (parent::check_logged_in("/offset/complete") == false) { //saves the path for later use
			Redirect::to('/signup');
		}
		Redirect::to('/user/profile');
	}

    public static function spending(){
        View::make('spending/index.html', array('account_logged_in' => self::get_account_logged_in(), 'carbon' => self::get_carbon()));
    }

    public static function accounts($request,$response) {

      return $response->withJson( RestQuery::get(""), 200);

    }

    public static function transactions($request,$response, $accountId ) {

       return $response->withJson(RestQuery::get("/{$accountId}/transactions"),200);
    }

}

class RestQuery {

    public static function get( $resource = "" ) {
        $uri = Configuration::$apiUrl;
        $apiKey = Configuration::$apiKey;
        $authorizationToken = Configuration::$authorizationToken;
        $sessionId = Configuration::$sessionId;
        $requestId = Configuration::$requestId;

        $apiResponse = \Httpful\Request::get( $uri . $resource)
            ->addHeader('x-api-key',$apiKey )
            ->addHeader('x-session-key',$sessionId)
            ->addHeader('x-request-id',$requestId)
            ->addHeader('x-authorization',$authorizationToken)
            ->send();

        if($apiResponse->hasErrors())
            throw new Exception( $apiResponse->raw_body, $apiResponse->code );

        return $apiResponse->body;
    }
}