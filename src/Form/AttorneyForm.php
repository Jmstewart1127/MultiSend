<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 3:25 PM
 */

namespace Drupal\multisend\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\multisend\Service\MailerService;
use Drupal\smtp\PHPMailer\PHPMailer;

class AttorneyForm extends FormBase {
  private $formValidator;
  private $mailerService;

  public function __construct() {}

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
    return 'multisend_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param string $attorney_email
   *    Attorney email address
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $attorney_email = NULL) {
    $form['user_name'] = [
      '#type' => 'textfield',
      '#title' => t('Your Name'),
    ];

    $form['user_email'] = [
      '#type' => 'email',
      '#title' => t('Your Email'),
      '#required' => true
    ];

    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => t('Subject'),
      '#required' => true
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Your Message'),
      '#required' => true
    ];

    $form['attorney_email_address'] = [
      '#type' => 'hidden',
      '#value' => $attorney_email
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
      '#button_type' => 'primary'
    ];

    return $form;
  }

  private function getMessageData(FormStateInterface $form_state) {
    return [
      'sender_name' => $form_state->getValue('user_name'),
      'subject' => $form_state->getValue('subject'),
      'message' => $form_state->getValue('message'),
    ];
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $message_data = $this->getMessageData($form_state);
    $email_address = $form_state->getValue('attorney_email_address');
    $this->mailerService = new MailerService(new PHPMailer(true), $message_data);
    $this->mailerService->sendFormData('ATTORNEY_CONTACT', $email_address);
    drupal_set_message('Message Sent.');
  }
}
