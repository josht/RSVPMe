<?php
/**
 * RSVPMe
 *
 * Allow users to RSVP for events.
 *
 * @package rsvpme
 */
$output = '';
$rsvpme = $modx->getService('rsvpme','RSVPMe',$modx->getOption('rsvpme.core_path',null,$modx->getOption('core_path').'components/rsvpme/').'model/rsvpme/',$scriptProperties);
if (!($rsvpme instanceof RSVPMe)) return '';
$rsvpme->initialize($modx->context->get('key'));

/* get default properties */
$outerTpl = $modx->getOption('outterTpl',$scriptProperties,'outertpl');
$codeTpl = $modx->getOption('codeTpl',$scriptProperties,'codetpl');
$listTpl = $modx->getOption('listTpl',$scriptProperties,'listtpl');
$regTpl = $modx->getOption('regTpl',$scriptProperties,'regtpl');
$regFormTpl = $modx->getOption('regFormTpl',$scriptProperties,'regform');
$feeFormTpl = $modx->getOption('feeFormTpl',$scriptProperties,'feeform');
$regSuccessTpl = $modx->getOption('regSuccessTpl',$scriptProperties,'regsuccess');
$showCode = $modx->getOption('showCode',$scriptProperties,true);
$showList = $modx->getOption('showList',$scriptProperties,true);
$emailTo = $modx->getOption('rsvpmeEmailTo',$scriptProperties,'');
$emailFrom = $modx->getOption('rsvpmeEmailFrom',$scriptProperties,'');
$emailCC = $modx->getOption('rsvpmeEmailCC',$scriptProperties,'');
$emailBCC = $modx->getOption('rsvpmeEmailBCC',$scriptProperties,'');
$regWithoutFee = $modx->getOption('regWithoutFee',$scriptProperties,0);

$tpls = array();

// Load validator here as it is always needed (for now)
$rsvpme->loadValidator();

/* if something was posted, we should process it */
if (!empty($_POST)) {
    $fields = $_POST;
    $fields = $rsvpme->validator->validateFields($fields);

    $modx->log(modX::LOG_LEVEL_INFO,'$_POST found: ' . print_r($fields,true));
    if (empty($rsvpme->validator->errors)) {
        if (isset($fields['code'])) {
            /* an event code was provided and validated, so now
             * we can prepare the registration form for this event
             */
            $regtype = $modx->getObject('RSVPMeRegType',array('code' => $fields['code']));
            $event = $regtype->getOne('Event');
            $eventArray = array_merge($regtype->toArray(),$event->toArray());
            $eventArray['regtypeid'] = $regtype->get('id');
            if ($regtype->fee != 0) {
                /* there is a fee associated with this registration, so load the fee button options */
                $eventArray['rsvpme.feeform'] = $rsvpme->getChunk($feeFormTpl);
                $modx->log(modX::LOG_LEVEL_INFO, '[RSVPMe] Loaded fee form.');
            }
            if ($regtype->fee == 0 || ($regtype->fee != 0 && $regWithoutFee)) {
                /* there is no fee, or this is a fee, but regWithoutFee has been set to true */
                $eventArray['rsvpme.regform'] = $rsvpme->getChunk($regFormTpl);
                $modx->log(modX::LOG_LEVEL_INFO, '[RSVPMe] Loaded non-fee form.' . print_r($eventArray,true));
            }
            $tpls['rsvpme.register'] = $rsvpme->getChunk($regTpl,$eventArray);
            $modx->log(modX::LOG_LEVEL_INFO, '[RSVPMe] Loaded registration template.');
        } elseif (isset($fields['registerforevent'])) {
            /* register form has been completed and submitted */
            $modx->log(modX::LOG_LEVEL_INFO,'[RSVPMe] Attempting to register guest.' . print_r($fields,true));
            if (!$regtype = $modx->getObject('RSVPMeRegType',array('id' => $fields['regtypeid']))) {
                $modx->log(modX::LOG_LEVEL_ERROR, '[RSVPMe] Unable to load RSVPMeRegType from: ' . print_r($fields,true));
            }
            $fields['name'] = $fields['regname'];
            if ($rsvpme->registerPerson($regtype->id, $fields)) {
                /* registration completed successfully, load success template */
                $tpls['rsvpme.regsuccess'] = $rsvpme->getChunk($regSuccessTpl);
            } else {
                $modx->log(modX::LOG_LEVEL_ERROR,'[RSVPMe] There was an error attempting to register guest: ' . print_r($fields,true));
            }
        } elseif (isset($fields['payandregister']) && isset($fields['regtypeid'])) {
            /* if they have clicked this button, then we can send them on to the
             * payment processor to complete payment
             */
            if (!$modx->loadClass('rsvpme.payment.PayPal',$rsvpme->config['modelPath'],true,true)) {
                $modx->log(modX::LOG_LEVEL_ERROR, '[RSVPMe] Could not load PayPal class.');
                return '';
            }
            $paypal = new PayPal($modx);
            $paypal->initialize();

            if (!$regtype = $modx->getObject('RSVPMeRegType',$fields['regtypeid'])) {
                return print_r($fields,true);
            }
            $request = array(
                'RETURNURL' => $modx->makeUrl($modx->resource->get('id'),$modx->context->get('id'),'','full'),
                'CANCELURL' => $modx->makeUrl($modx->resource->get('id'),$modx->context->get('id'),'','full'),
                'PAYMENTACTION' => 'Sale',
            );
            $details = array(
                'AMT' => money_format('%i',(string)$regtype->fee),
                'CURRENCYCODE' => 'USD',
            );

            $result = $paypal->setExpressCheckout($request, $details);

            if ($result['ACK'] == 'Success' || $result['ACK'] = 'SuccessWithWarning') {
                if (isset($result['TOKEN'])) {
                    $_SESSION[$result['TOKEN']] = array(
                        'AMT' => $details['AMT'],
                        'regtypeid' => $fields['regtypeid'],
                    );
                    $modx->log(modX::LOG_LEVEL_INFO, '[RSVPMe] Token found, setting it in $_SESSION.');
                } else {
                    $modx->log(modX::LOG_LEVEL_ERROR, '[RSVPMe] PayPal token not found: ' . print_r($result,true));
                }
                header ('Location: ' . $result['PayPalURL']);
                exit;
            }
            $tpls['rsvpme.error'] = 'Sorry, there was an error communicating with the payment processor.';
        }
    } else {
        if($showCode) {
            $tpls['rsvpme.code'] = $rsvpme->getChunk($codeTpl, $rsvpme->validator->errors);
        }
        if($showList) {
            $tpls['rsvpme.list'] = $rsvpme->getChunk($listTpl, $rsvpme->validator->errors);
        }
    }
} elseif (isset($_REQUEST['token'])) {
    if (!isset($_SESSION[$_REQUEST['token']])) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'Token not set in session. How did they get here?');
        return 'PayPal token not found.';
    }
    /* paypal token is set */
    $modx->log(modX::LOG_LEVEL_INFO,'[RSVPMe] PayPal TOKEN detected. Finishing registration and processing.');
    if (!$modx->loadClass('rsvpme.payment.PayPal',$rsvpme->config['modelPath'],true,true)) {
        $modx->log(modX::LOG_LEVEL_ERROR, '[RSVPMe] Could not load PayPal class.');
        return 'Sorry, there was an error completing the transaction.';
    }
    $paypal = new PayPal($modx);
    $paypal->initialize();

    $payer = $paypal->getExpressCheckoutDetails(array('token' => $_REQUEST['token']));

    $modx->log(modX::LOG_LEVEL_INFO, 'PayPal transaction info: ' . print_r($payer,true));
    $request = array(
        'PAYMENTACTION' => 'Sale',
    );
    $details = array(
        'TOKEN' => $_REQUEST['token'],
        'PAYERID' => $payer['PAYERID'],
        'AMT' => $_SESSION[$_REQUEST['token']]['AMT']
    );
    // Must re-initialize PayPal, as it closes the cURL object after each command.
    $paypal->initialize();
    $result = $paypal->doExpressCheckoutPayment($request, $details);

    if ($result['ACK'] == 'Success' || $result['ACK'] == 'SuccessWithWarning') {
        $modx->log(modX::LOG_LEVEL_INFO,'Payment completed: ' . print_r($result,true) . print_r($payer,true));
        // Now that the payment has completed, we can finish registering the user.
        if(!$regtype = $modx->getObject('RSVPMeRegType', array('id' => $_SESSION[$_REQUEST['token']]['regtypeid']))) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[RSVPMe] There was an error when attempting to register paid guest. ' . print_r($result,true));
        }
        $guest = array(
            'name' => $payer['FIRSTNAME'] . ' ' . $payer['LASTNAME'],
            'email' => $payer['EMAIL'],
            'paid' => true,
        );

        if ($rsvpme->registerPerson($regtype->id, $guest)) {
            $tpls['rsvpme.regsuccess'] = $rsvpme->getChunk($regSuccessTpl);
        } else {
            $modx->log(modX::LOG_LEVEL_ERROR,'[RSVPMe] There was an error attempting to register the paid guest: ' . print_r($guest,true));
        }


    } else {
        $modx->log(modX::LOG_LEVEL_ERROR,'There was an error completing PayPal payment:' . print_r($result,true));
        return 'Sorry, there was an error completing the payment.';
    }
} else {
    /* if no form was submitted, then the user must still need to select an event */
    if ($showCode) {
        $tpls['rsvpme.code'] = $rsvpme->getChunk($codeTpl);
    }
    if ($showList) {
        $tpls['rsvpme.list'] = $rsvpme->getChunk($listTpl);
    }
}
$output = $rsvpme->getChunk($outerTpl,$tpls);

$modx->toPlaceholders($rsvpme->validator->errors,'rsvpme.error');

if (!empty($toPlaceholder)) {
    /* if using a placeholder, output nothing and set output to specified placeholder */
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}

//$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
/* by default just return output */
return $rsvpme->output($output);