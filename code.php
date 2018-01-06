<?php
/**
 * General Validator usage example
 *
 * @by Malak Abu Hammad.
 */

require_once 'data.php';
require_once 'Taxes.php';

/**
 * @param string $message
 */
function printMessage($message)
{
    echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
}

/**
 * @param array $taxes
 * @return bool
 */
function checkTexes(array $taxes)
{
    foreach ($taxes as $tax) {
        $oTax = new Taxes();
        $oTax->setAttributes($tax);
        if (!$oTax->validate()) {
            return false;
        }
    }
    return true;
}

/**
 * @param array $data
 * @return bool
 */
function checkData($data)
{
    foreach ($data as $value) {
        if (isset($value['taxes']) && is_array($value['taxes'])) {
            if (!checkTexes($value['taxes'])) {
                return false;
            }
        }
    }
    return true;
}

function execute()
{
    printMessage('Execution started.');

    $data = getData();
    printMessage('Data loaded.');

    $data = decodeData($data);
    printMessage('Data decoded.');

    printMessage('Data check started');
    if (!checkData($data)) {
        printMessage('Invalid Data');
    } else {
        printMessage('All Data is valid');
    }
    printMessage('Data check Done');

    printMessage('Execution Done.');
}

execute();