<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

 /**
  * @param string $param
  * @return array
  */
 public function content($param = '') {
   $message = $this->t('You are on the Hello page. Your name is @username! @param', [
     '@username' => $this->currentUser()->getAccountName(),
     '@param' => $param,
   ]);

   return ['#markup' => $message];
 }

}
