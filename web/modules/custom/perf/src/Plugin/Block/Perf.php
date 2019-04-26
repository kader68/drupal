<?php

namespace Drupal\perf\Plugin\Block;

use Drupal\Core\Block\Blockbase;

/**
 * Provides a perf block.
 *
 * @Block(
 *  id = "perf_block",
 *  admin_label = @Translation("Perf!")
 * )
 */
class Perf extends BlockBase {
/*
   public function build() {
       $build = array('#markup' => $this->t('Welcome!'));

       return $build;
   }
   */
   public function build() {
   
   return [

    '#create_placeholder' => TRUE,
    '#lazy_builder' => [
    'perf.perf:page',
      [\Drupal::currentUser()->getAccountName()]
    ]

  ];

 }
}