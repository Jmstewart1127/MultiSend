<?php

namespace Drupal\multisend\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class MultiSendForm extends FormBase
{

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
    public function getFormId()
    {
        return 'multisend_form';
    }

    /**
     * Form constructor.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     *
     * @return array
     *   The form structure.
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['user_email'] = [
            '#type' => 'email',
            '#title' => t('Your Email'),
            '#required' => true
        ];

        $form['user_name'] = [
            '#type' => 'textfield',
            '#title' => t('Your Name'),
        ];

        $form['user_email'] = [
            '#type' => 'email',
            '#title' => t('Your Email'),
            '#required' => true
        ];

        $form['send_to_addresses'] = [
            '#type' => 'textarea',
            '#title' => t('Send To (Enter Multiple Email Addresses Separated By a Comma)'),
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

        $form['actions']['#type'] = 'actions';

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary'
        ];

        return $form;
    }

    /**
     * Form submission handler.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function submitForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
        // TODO: Implement submitForm() method.
    }
}
