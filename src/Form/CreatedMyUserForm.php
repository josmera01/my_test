<?php

namespace Drupal\my_test\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CreatedMyUserForm.
 */
class CreatedMyUserForm extends FormBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'created_my_user_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name_user'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name user'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get variable.
    $name = $form_state->getValue('name_user');
    // Insert values.
    $key = $this->database->insert('myusers')->fields(['name' => $name])->execute();
    // Print user ID.
    \Drupal::messenger()->addMessage($this->t('Created user %id', ['%id' => $key] ));

  }

}
