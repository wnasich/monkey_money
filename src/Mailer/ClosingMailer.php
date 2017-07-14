<?php
namespace App\Mailer;

use App\Model\Entity\Closing;
use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;

class ClosingMailer extends Mailer
{
    public function send($action, $args = [], $headers = [])
    {
        $this->loadModel('Users');

        $excludeUserId = null;
        switch ($action) {
            case 'created':
                $alertName = User::ALERT_CLOSING_CREATED;
                break;
            case 'packagesChanged':
                $alertName = User::ALERT_CLOSING_PACKAGES_CHANGED;
                break;
            case 'outOfLevels':
                $alertName = User::ALERT_CLOSING_OUT_OF_LEVELS;
                break;
            case 'statusChanged':
                $alertName = User::ALERT_CLOSING_PACKAGES_CHANGED;
                $excludeUserId = $args[0]->modified_by;
                break;
            default:
                throw new InvalidArgumentException("Invalid action '{$action}'");
                break;
        }

        $recipients = $this->Users->find('EmailsToAlert', compact('alertName', 'excludeUserId'));
        if (!$recipients) {
            return false;
        }
        $this->to($recipients);

        return parent::send($action, $args, $headers);
    }

    public function created(Closing $closing)
    {
        $operator = $this->Users->get($closing->created_by);

        $this->loadModel('Movements');
        $movements = $this->Movements->find('allForClosing', ['closing' => $closing]);

        $closingConfig = Configure::read('Closing');
        $cashierName = $closingConfig['cashierName'];
        $emailBaseUrl = $closingConfig['emailBaseUrl'];

        $billsDef = getBillsDefinitions();
        $bills = $billsDef['bills'] + $billsDef['packages'];

        $this
            ->emailFormat('text')
            ->subject(__('{cashierName}: Closing no. {closingNumber}', [
                'cashierName' => $cashierName,
                'closingNumber' => $closing->number
            ]))
            ->template('Closings/created')
            ->set(compact('bills', 'closing', 'emailBaseUrl', 'movements', 'operator'));
    }

    public function packagesChanged(Closing $closingCurrent, array $packagesChanged)
    {
        $this->loadModel('Closings');
        $closingPrevious = $this->Closings->previousTo($closingCurrent);

        $operatorCurrent = $this->Users->get($closingCurrent->created_by);
        $operatorPrevious = $this->Users->get($closingPrevious->created_by);

        $closingConfig = Configure::read('Closing');
        $cashierName = $closingConfig['cashierName'];
        $emailBaseUrl = $closingConfig['emailBaseUrl'];

        $billsDef = getBillsDefinitions();
        $bills = $billsDef['bills'] + $billsDef['packages'];

        $this
            ->emailFormat('both')
            ->subject(__('{cashierName}: Count of packages changed', [
                'cashierName' => $cashierName,
            ]))
            ->template('Closings/packages_changed')
            ->set(compact('bills', 'closingPrevious', 'closingCurrent', 'emailBaseUrl', 'packagesChanged', 'operatorPrevious', 'operatorCurrent'));
    }

    public function outOfLevels(Closing $closing)
    {
        $closingConfig = Configure::read('Closing');
        $cashierName = $closingConfig['cashierName'];
        $emailBaseUrl = $closingConfig['emailBaseUrl'];

        $billsDef = getBillsDefinitions();
        $bills = $billsDef['bills'] + $billsDef['packages'];

        $this
            ->emailFormat('both')
            ->subject(__('{cashierName}: Packages out of level', [
                'cashierName' => $cashierName,
            ]))
            ->template('Closings/out_of_levels')
            ->set(compact('bills', 'closing', 'emailBaseUrl'));
    }

    public function statusChanged(Closing $closing)
    {
        $operator = $this->Users->get($closing->created_by);
        $closingConfig = Configure::read('Closing');
        $cashierName = $closingConfig['cashierName'];
        $emailBaseUrl = $closingConfig['emailBaseUrl'];

        $this
            ->emailFormat('text')
            ->subject(__('{cashierName}: {closingStatus} closing no. {closingNumber}', [
                'cashierName' => $cashierName,
                'closingStatus' => $closing->statusName(),
                'closingNumber' => $closing->number,
            ]))
            ->template('Closings/status_changed')
            ->set(compact('closing', 'emailBaseUrl', 'operator'));
    }

}
