<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\Blockbase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
* Provides a helloSession block.
*
* @Block(
* id = "helloSession_block",
* admin_label = @Translation("Hello Session!")
* )
*/
class HelloSession extends BlockBase {
/*
   public function build() {
       $build = array('#markup' => $this->t('Welcome!'));

       return $build;
   }
   */
   public function build() {
    $number = \Drupal::database()->select('sessions')
    ->countQuery()
    ->execute()
    ->fetchField();

    return ['#markup' => $this->t('Session number: %number', ['%number' => $number]),];
  }

protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access hello');
  }

}