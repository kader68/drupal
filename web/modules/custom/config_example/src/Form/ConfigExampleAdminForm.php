<?php

namespace Drupal\config_example\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a config_example admin form.
 */
class ConfigExampleAdminForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'config_example_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return array('config_example.settings');
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $key = $this->config('config_example.settings')->get('key');

    $form['key'] = array(
      '#type'    => 'select',
      '#title'   => $this->t('Choose a value'),
      '#options' => array(
        ''        => $this->t('No value'),
        'value_1' => $this->t('Value 1'),
        'value_2' => $this->t('Value 2'),
        'value_3' => $this->t('Value 3'),
      ),
      '#default_value' => $key,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('config_example.settings')
      ->set('key', $form_state->getValue('key'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
