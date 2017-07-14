<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Closing;

use Cake\Mailer\MailerAwareTrait;

/**
 * Closings Controller
 *
 * @property \App\Model\Table\ClosingsTable $Closings
 */
class ClosingsController extends AppController
{
    use MailerAwareTrait;

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CreatedByUsers', 'ModifiedByUsers'],
            'order' => ['Closings.created' => 'DESC'],
        ];
        $closings = $this->paginate($this->Closings);

        $this->set(compact('closings'));
        $this->set('_serialize', ['closings']);
    }

    /**
     * View method
     *
     * @param string|null $id Closing id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $closing = $this->Closings->get($id, [
            'contain' => ['CreatedByUsers', 'ModifiedByUsers']
        ]);

        $this->set('closing', $closing);
        $this->set('_serialize', ['closing']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $closing = $this->Closings->newEntity();
        $lastClosing = null;
        if ($this->request->is('post')) {

            $this->request->data['status'] = Closing::STATUS_CREATED;
            if ($this->request->data['change_bills']) {
                $changeBills = [];
                foreach ($this->request->data['change_bills'] as $billCode => $billCount) {
                    if (intval($billCount) > 0) {
                        $changeBills[$billCode] = intval($billCount);
                    }
                }
                $this->request->data['change_bills'] = $changeBills;
            }

            $closing = $this->Closings->patchEntity($closing, $this->request->data);
            if ($this->Closings->save($closing)) {
                $this->getMailer('Closing')->send('created', [$closing]);

                $packagesChanged = $this->Closings->billPackagesChanged($closing);
                if ($packagesChanged) {
                    $this->getMailer('Closing')->send('packagesChanged', [$closing, $packagesChanged]);
                }

                $outOfLevels = $this->Closings->outOfLevels($closing);
                if ($outOfLevels) {
                    $this->getMailer('Closing')->send('outOfLevels', [$closing]);
                }

                return $this->redirect(['action' => 'addSuccess', $closing->id]);
            }
        } else {
            $lastClosing = $this->Closings->find('last');
        }

        $this->set(compact('closing', 'lastClosing'));
        $this->set('_serialize', ['closing', 'lastClosing']);
    }

    /**
     * addSuccess method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addSuccess($closingId)
    {
        $closing = $this->Closings->get($closingId);
        $this->set(compact('closing'));
    }

    /**
     * Change status method
     *
     * @param string|null $id Closing id.
     * @param string|null $toStatus New status
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changeStatus($id = null, $toStatus = null)
    {
        $closing = $this->Closings->get($id);
        if ($this->request->is('put') || $this->request->is('post')) {
            $closing = $this->Closings->patchEntity($closing, $this->request->data);
            if ($this->Closings->save($closing)) {
                $this->getMailer('Closing')->send('statusChanged', [$closing]);
                $this->Flash->success(__('New status has been assigned to closing.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The closing could not be saved. Please, try again.'));
            }
        }

        if ($toStatus) {
            $closing->set('status', $toStatus);
        }

        $closingStatus = Closing::statusNames();
        $this->set(compact('closing', 'closingStatus'));
        $this->set('_serialize', ['closing']);
    }

    /**
     * isAuthorized method
     *
     * @param array $user
     * @return boolean True if allowed
     */
    public function isAuthorized($user) {
        $allowUsers = ['add', 'addSuccess'];
        if (in_array($this->request->action, $allowUsers) && $user) {
            return true;
        }

        return parent::isAuthorized($user);
    }
}
