<?php

namespace Drupal\hello\Access;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;

class HelloAccessCheck implements AccessCheckInterface {

  /**
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * HelloAccessCheck constructor.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   */
  function __construct(TimeInterface $time) {
    $this->time = $time;
  }

  /**
   * {@inheritdoc}.
   */
  public function applies(Route $route) {
    return NULL;
  }

  /**
   * @param \Symfony\Component\Routing\Route $route
   * @param \Symfony\Component\HttpFoundation\Request|NULL $request
   * @param \Drupal\Core\Session\AccountInterface $account
   * @return $this|\Drupal\Core\Access\AccessResultForbidden
   */
  public function access(Route $route, Request $request = NULL, AccountInterface $account) {
    $nbr_heures = $route->getRequirement('_access_hello');
    /** @var $account \Drupal\Core\Session\AccountProxy */
    if (!$account->isAnonymous() &&
      ($this->time->getCurrentTime() - $account->getAccount()->created > $nbr_heures * 3600)) {
      return AccessResult::allowed()->cachePerUser();
    }

    return AccessResult::forbidden()->cachePerUser();
  }

}