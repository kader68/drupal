<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\Blockbase;

/**
* Provides a hello block.
*
* @Block(
* id = "hello_block",
* admin_label = @Translation("Hello!")
* )
*/
class Hello extends BlockBase {
/*
   public function build() {
       $build = array('#markup' => $this->t('Welcome!'));

       return $build;
   }
   */
   public function build() {
   $name = \Drupal::currentUser()->isAuthenticated() ? \Drupal::currentUser()->getAccountName() : $this->t('anonymous');
   $build = [
     '#markup' => $this->t('Welcome %name. It is %time.', [
       '%name' => $name,
       '%time' => \Drupal::service('date.formatter')
         ->format(\Drupal::service('datetime.time')
           ->getCurrentTime(), 'custom', 'H:i s\s'),
     ]),
     '#cache'  => [
     	'keys' => ['hello:block'],
     	'max-age' => '10',
     	'contexts' => ['user'],
     ],
   ];

   return $build;
 }
}