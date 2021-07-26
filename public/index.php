<?php

use App\Controller;
use App\Greeting;
use App\User;

require '../vendor/autoload.php';

$current_hour = date("G");

$user = new User();
$greeting = new Greeting($current_hour);

$controller = new Controller($user, $greeting);
echo 'This is an awesome App!';
?>
<p class="<?=$controller->css_class?>"><?=$controller->getResponse()?></p>
