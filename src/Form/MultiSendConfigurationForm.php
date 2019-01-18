<?php

namespace Drupal\multisend\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class MultiSendConfigurationForm extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'multisend.settings'
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'multisend_admin_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('multisend.settings');
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'page');
    $nids = $query->execute();
    $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);
    $options = [];
    foreach ($nodes as $node) {
      $options[$node->id()] = $node->getTitle();
    }

    $form['smtp'] = [
      '#type' => 'details',
      '#title' => t('Pages'),
      '#open' => true
    ];

    $form['smtp']['smtp_host'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SMTP Host'),
      '#default_value' => $config->get('smtp_host')
    ];

    $form['smtp']['smtp_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SMTP Username'),
      '#default_value' => $config->get('smtp_username')
    ];

    $form['smtp']['smtp_password'] = [
      '#type' => 'password',
      '#title' => $this->t('SMTP Password'),
      '#default_value' => $config->get('smtp_password')
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->config('multisend.settings')
      ->set('smtp_host', $values['smtp_host'])
      ->set('smtp_username', $values['smtp_username'])
      ->set('smtp_password', $values['smtp_password'])
      ->save();
  }

}
