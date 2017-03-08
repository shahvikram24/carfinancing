<?php
  require_once(APPLICATIONREQUIREROOT.'stripe/lib/Stripe.php');
  


  if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "snap4share.com" || $_SERVER['SERVER_NAME'] == "www.snap4share.com"))
    {
      // Sandbox API    //shahvikram24@gmail.com
      $stripe = array(
        'secret_key'      => 'sk_test_ozt0QIlgfjsjBFxO5lZ4y83y',
        'publishable_key' => 'pk_test_tTmvlif6JWdfe7UDsBeKL0Mw'
        );
      Stripe::setApiKey($stripe['secret_key']);

    /*
      //Live API
      
      $stripe = array(
        'secret_key'      => 'sk_live_emF5iPNi2LcSTI6sNp0JJUSJ',
        'publishable_key' => 'pk_live_x4dGkk0N6LMq9sVR8z38l4Kh '
        );
      Stripe::setApiKey($stripe['secret_key']);

     */
    }

    else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "snap4share.vstudiozzz.com")
    {
      // Sandbox API    //shahvikram24@gmail.com
      $stripe = array(
        'secret_key'      => 'sk_test_ozt0QIlgfjsjBFxO5lZ4y83y',
        'publishable_key' => 'pk_test_tTmvlif6JWdfe7UDsBeKL0Mw'
        );
      Stripe::setApiKey($stripe['secret_key']);

    /*
      //Live API
      
      $stripe = array(
        'secret_key'      => 'sk_live_emF5iPNi2LcSTI6sNp0JJUSJ',
        'publishable_key' => 'pk_live_x4dGkk0N6LMq9sVR8z38l4Kh '
        );
      Stripe::setApiKey($stripe['secret_key']);

     */
    }
    else
    {
      // Sandbox API    //shahvikram24@gmail.com
      $stripe = array(
        'secret_key'      => 'sk_test_ozt0QIlgfjsjBFxO5lZ4y83y',
        'publishable_key' => 'pk_test_tTmvlif6JWdfe7UDsBeKL0Mw'
        );
      Stripe::setApiKey($stripe['secret_key']);

    /*
      //Live API
      
      $stripe = array(
        'secret_key'      => 'sk_live_emF5iPNi2LcSTI6sNp0JJUSJ',
        'publishable_key' => 'pk_live_x4dGkk0N6LMq9sVR8z38l4Kh '
        );
      Stripe::setApiKey($stripe['secret_key']);

     */
    }
?>