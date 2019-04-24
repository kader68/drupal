<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\link;
use Drupal\Core\url;
use Drupal\user\UserInterface;
class ModuleListController extends ControllerBase {

 /**
  * @param string $param
  * @return array
  */
 public function content(UserInterface $user) {
 
 $database = \Drupal::database();
 $query = $database->select('hello_user_statistics' ,'hus')
    ->fields('hus' , ['time', 'action'])
    ->condition('uid', $user->id(), '=')
    ->execute();
    $connexions = 0;
    foreach ($query as $record ) {
    	$rows[] = [$record->action == '1' ? $this->t('login') : $this->t('logout'), 
    	\Drupal::service('date.formatter')->format($record->time),];
    $connexions = $connexions  + $record->action;
    }

    $table = [
      '#type' => 'table',
      '#header' => [$this->t('Action'), $this->t('Time')],
      '#rows' => $rows,
      '#empty'=> $this->t('No connections yet.'),
    ];
    // Message en entête.
    $message = [
      '#theme' => 'hello-user-connexion',
      '#user' => $user,
      '#count' => $connexions,
    ];

    // on renvoie les render arrays.
    return [$message, $table];

  }
}
