<?php

namespace App;

class Helpers {
  public static function displayName($user, $alt=null) {
    return (!is_null($user) &&
            !is_null($user->data) &&
            !is_null($user->data->burner_name) &&
            trim($user->data->burner_name) !== "") ?
              $user->data->burner_name :
              ((is_null($alt)) ? $user->name : $alt);
  }
}
