<?php

class BaseController
{

    public static function get_account_logged_in()
    {
        if (isset($_SESSION['account'])) {
            $account_id = $_SESSION['account'];
            $account = Account::find($account_id);
      
            return $account;
        }
        return null;
    }

    public static function check_logged_in($redirect_url = "")
    {
        if (!isset($_SESSION['account'])) {
            $_SESSION['redirect_url'] = $redirect_url;
            return false;
        }
        return true;
    }

    public static function redirect()
    {
        if (isset($_SESSION['account'])) {
            if ($_SESSION['redirect_url'] != "") {
                $redirect_url = $_SESSION['redirect_url'];
                $_SESSION['redirect_url'] = "";
                Redirect::to($redirect_url);
            }
        }
    }

    public static function returnAccountId() {
        if (!isset($_SESSION['account'])) {
            return $_SESSION['account'];
        }
    }

    public static function check_viewing_rights($id)
    {
        $account = self::get_account_logged_in();
        if (!$account == null) {
            if ($account->id == $id) {
                    return 1;
            }
        }
        return 0;
    }
}
