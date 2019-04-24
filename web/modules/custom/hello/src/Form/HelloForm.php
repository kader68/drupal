<?php
namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Implements a hello form
 */

class HelloForm extends FormBase
{
	/**
	 * {@inheritdoc}.
	 */
	public function getFormID(){
		return 'hello_form';
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
		 
		 $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Mon calculateur.'),
    ];

    
$form['nombre1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Premier nombre'),
      '#description' => $this->t('Entrer la première valeur.'),
      '#required' => TRUE,
       '#ajax'  => [
        'callback' => [$this, 'AjaxValidateNumeric'],
        'event' => 'keyup',
      ],
      '#prefix' => '<span id="error-message-nombre1"></span>',
    ];
   

    $form['operation'] = array(
      '#type' => 'radios',
      '#title' => $this
        ->t('Opération'),
        '#options' => array(
            '+' => 'Ajouter',
            '-' => 'Soustraire',
            '*' => 'Multiplier',
            '/' => 'Diviser'
        ),
      '#default_value' => '+',
    );

    $form['nombre2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('deuxieme nombre'),
      '#description' => $this->t('Entrer la première valeur.'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => [$this, 'AjaxValidateNumeric'],
        'event' => 'keyup',
      ],
      '#prefix' => '<span id="error-message-nombre2"></span>',
    ];
    
    
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

    $form['actions']['reset'] = array(
  '#type' => 'submit',
  '#value' => t('Reset'),
  '#submit' => array('reset'),
);

		return $form;
	}

 
  function reset(array $form, FormStateInterface $form_state) {
  $form_state['rebuild'] = FALSE;

  }

 

	/**
	 * {@inheritdoc}.
	 */


	public function submitForm(array &$form, FormStateInterface $form_state){
	         

           $value_1 = $form_state->getValue('nombre1');
           $value_2 = $form_state->getValue('nombre2');
           $operation = $form_state->getValue('operation');

           kint($value_1);
           kint($form_state);

           $result = '';

           if($operation == '+'){
               $result = $value_1 + $value_2;
           }

           if($operation == '-'){
               $result = $value_1 - $value_2;
           }

           if($operation == '*'){
               $result = $value_1 * $value_2;
           }

           if($operation == '/'){
               $result = $value_1 / $value_2;
           }
           \Drupal::messenger()->addMessage(t('%result', ['%result' => $result]));

           $form_state->addRebuildInfo('result', $result);
           // Reconstitution formulaire
           $form_state->setRebuild();
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