<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/5/19
 * Time: 3:27 PM
 */

namespace Drupal\multisend\Service;

class FormInputValidator
{
    private $emailAddresses;

    public function __construct($emailAddresses)
    {
        $this->setEmailAddresses($emailAddresses);
        $this->removeSpaces();
    }

    private function splitAddresses()
    {
        return explode(',', $this->emailAddresses);
    }

    private function removeSpaces()
    {
        $addresses = $this->splitAddresses();

        $addresses_without_spaces = [];

        $i = 0;
        foreach ($addresses as $address)
        {
            $address = preg_replace('/\s+/', '', $address);
            $addresses_without_spaces[$i++] = $address;
        }

        $this->setEmailAddresses($addresses_without_spaces);
    }

    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }

    public function setEmailAddresses($emailAddresses)
    {
        $this->emailAddresses = $emailAddresses;
    }
}
