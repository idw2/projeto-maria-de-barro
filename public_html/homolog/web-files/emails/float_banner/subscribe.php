<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'src/Mailchimp.php';


$MailChimp = new Mailchimp('017f39fc27278e8dc410af68f1ddca6b-us9');
$result = $MailChimp->call('lists/subscribe', array(
    'id' => '0da4cf816f',
    'email' => array('email' => $_POST['email']),
    'double_optin' => false,
    'update_existing' => true,
    'replace_interests' => false,
    'send_welcome' => false,
        ));

header('Location: https://www.mariadebarro.com.br');