<?php

require_once "php-sdk/src/meli.php";

$meli = new Meli(array(
    'appId'     => '6687044510288187', 
    'secret'    => 'lf6qiHrVjmnOC0knTxaH43OJkYOXF5Ht',
));


$userID = $meli->initConnect();

if ($userID) {
    $user = $meli->getWithAccessToken("/users/{$userID}/items/search");

    echo "<pre>";
    print $user['json']['results'][0];
}

else{ ?>

      <div>
       <p> Login using OAuth 2.0 handled by the PHP SDK: </p>
        <a href="<?php echo $meli->getLoginUrl(); ?>">Login with MercadoLibre</a>
      </div>
<?php
}