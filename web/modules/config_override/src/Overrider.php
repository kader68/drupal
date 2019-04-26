<?php

namespace Drupal\config_override;

use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Class Overrider.
 *
 * @package Drupal\config_override
 */
class Overrider implements ConfigFactoryOverrideInterface {

  protected $currentUser;

  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * Constructor.
   */
  public function loadOverrides($names) {
    $overrides = array();
    if (in_array('system.site', $names)) {
      if ($this->currentUser->isAuthenticated()) {
        $overrides['system.site'] = ['name' => 'Deploy'];
      }
      else $overrides['system.site'] = ['name' => 'Deploy intranet'];
    }

    return $overrides;
  }

  /**
   * Constructor.
   */
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
  }

  /**
   * Constructor.
   */
  public function getCacheableMetadata($name) {
  }

  /**
   * Constructor.
   */
  public function getCacheSuffix() {
  }

}
