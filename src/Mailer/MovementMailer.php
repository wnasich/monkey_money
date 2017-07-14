<?php
namespace App\Mailer;

use App\Model\Entity\Movement;
use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class MovementMailer extends Mailer
{

    public function send($action, $args = [], $headers = [])
    {
        $this->loadModel('Users');

        switch ($action) {
            case 'created':
                $alertName = User::ALERT_MOVEMENT_CREATED;
                break;
            default:
                throw new InvalidArgumentException("Invalid action '{$action}'");
                break;
        }

        $recipients = $this->Users->find('EmailsToAlert', ['alertName' => $alertName]);
        if (!$recipients) {
            return false;
        }
        $this->to($recipients);

        return parent::send($action, $args, $headers);
    }

    public function created(Movement $movement)
    {
        $this->loadModel('MovementTypes');

        $operator = $this->Users->get($movement->created_by);
        $movementType = $this->MovementTypes->get($movement->movement_type_id);

        $cashierName = Configure::read('Closing.cashierName');

        $this
            ->emailFormat('text')
            ->subject(__('{cashierName}: {movementType} {movementAmount, number, currency}', [
                'cashierName' => $cashierName,
                'movementType' => $movementType->name,
                'movementAmount' => $movement->amount,
            ]))
            ->template('Movements/created')
            ->set(compact('movement', 'operator', 'movementType'));
    }

}
