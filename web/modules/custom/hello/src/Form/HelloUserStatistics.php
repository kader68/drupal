<?php
namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Implements a hello form
 */

class HelloUserStatistics extends ConfigFormBase
{
	/**
	 * {@inheritdoc}.
	 */
	public function getFormID(){
		return 'hello_userstatistics';
	}

  /**
   * {@inheritdoc}.
   */

  protected function getEditableConfigNames() {
    return ['hello.settings'];
  }
	/**
	 * {@inheritdoc}.
	 */
	public function buildForm(array $form, FormStateInterface $form_state){
    // Champs pour afficher le résultat du calcul
            if (isset($form_state->getRebuildInfo()['result'])) {
                $form['result']= [
                    '#markup' => '<h2>'.$this->t('Result: ').$form_state->getRebuildInfo()['result'].'</h2>',
                ];
            }
		 
		

    
    $form['choice_activity'] = array(
                          '#type' => 'select',
                          '#title' => t('Statistiques de l\'activité de l\'utilisateur'),
                          '#default_value' => $entry['choice_activity'],
                          '#options' => array(
                         1 => t('0'),
                         2 => t('1'),
                         3 => t('2'),
                         4 => t('7'),
                         5 => t('14'),
                         6 => t('30'),
    ));
    
    
    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    
		return $form;
	}

  

  
	/**
	 * {@inheritdoc}.
	 */


	public function submitForm(array &$form, FormStateInterface $form_state){
	 // Retrieve the configuration
       $this->config('hello.settings')
      // Set the submitted configuration setting
      ->set('choice_activity', $form_state->getValue('choice_activity'))
      
      ->save();

    parent::submitForm($form, $form_state);
  }

          
     public function validateForm(array &$form, FormStateInterface $form_state){
            $value_1 = $form_state->getValue('nombre1');
            $value_2 = $form_state->getValue('nombre2');
            $operation = $form_state->getValue('operation');
            if(!is_numeric($value_1)){
                $form_state->setErrorByName('first_value', $this->t('First value must be numeric'));
            }
            if(!is_numeric($value_2)){
                $form_state->setErrorByName('second_value', $this->t("Second value must be numeric"));
            }
            if($value_2 == 0 && $operation == '/'){
                $form_state->setErrorByName('operation', $this->t('Second value must be different from 0 on Divide operation'));
            }
          
        }
	

}