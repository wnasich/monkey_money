<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Mailer\MailerAwareTrait;

/**
 * Movements Controller
 *
 * @property \App\Model\Table\MovementsTable $Movements
 */
class MovementsController extends AppController
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
            'contain' => ['MovementTypes', 'CreatedByUsers'],
            'order' => ['Movements.created' => 'DESC']
        ];
        $movements = $this->paginate($this->Movements);

        $this->set(compact('movements'));
        $this->set('_serialize', ['movements']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function indexOperator()
    {
        $this->loadModel('Closings');
        $lastClosing = $this->Closings->find('last');

        $currentUserId = $this->Auth->user('id');

        $paginateOptions = [
            'conditions' => ['OR' => [
                'MovementTypes.view_public' => 1,
                'Movements.created_by' => $currentUserId,
            ]],
            'contain' => ['MovementTypes', 'CreatedByUsers'],
            'limit' => 100,
            'order' => ['created' => 'ASC'],
        ];

        if ($lastClosing) {
            $paginateOptions['conditions']['Movements.created >'] = $lastClosing->created;
        }
        $this->paginate = $paginateOptions;
        $movements = $this->paginate($this->Movements);

        $this->set(compact('movements'));
        $this->set('_serialize', ['movements']);
    }

    /**
     * Add method
     *
     * @param boolean $output Type of movement input/output
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($output = 0)
    {
        $movement = $this->Movements->newEntity();
        if ($this->request->is('post')) {
            $movement = $this->Movements->patchEntity($movement, $this->request->data);
            if ($this->Movements->save($movement)) {
                $this->getMailer('Movement')->send('created', [$movement]);
                return $this->redirect(['action' => 'addSuccess', $output]);
            }
        }

        $findOptions = [
            'limit' => 200,
            'order' => array('name' => 'ASC'),
            'conditions' => ['output' => $output],
        ];
        $movementTypes = $this->Movements->MovementTypes->find('list', $findOptions);

        $this->set(compact('movement', 'movementTypes', 'output'));
        $this->set('_serialize', ['movement']);
    }

    /**
     * addSuccess method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function addSuccess($output)
    {
        $this->set(compact('output'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $movement = $this->Movements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $movement = $this->Movements->patchEntity($movement, $this->request->data);
            if ($this->Movements->save($movement)) {
                $this->Flash->success(__('The movement has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The movement could not be saved. Please, try again.'));
            }
        }
        $movementTypes = $this->Movements->MovementTypes->find('list', ['limit' => 200]);
        $createdByUsers = $this->Movements->CreatedByUsers->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'movementTypes', 'createdByUsers'));
        $this->set('_serialize', ['movement']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $movement = $this->Movements->get($id);
        if ($this->Movements->delete($movement)) {
            $this->Flash->success(__('The movement has been deleted.'));
        } else {
            $this->Flash->error(__('The movement could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }

    /**
     * isAuthorized method
     *
     * @param array $user
     * @return boolean True if allowed
     */
    public function isAuthorized($user) {
        $allowUsers = ['add', 'addSuccess', 'indexOperator', 'delete'];
        if (in_array($this->request->action, $allowUsers) && $user) {
            return true;
        }

        return parent::isAuthorized($user);
    }
}
