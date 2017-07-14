<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\MovementType;

/**
 * MovementTypes Controller
 *
 * @property \App\Model\Table\MovementTypesTable $MovementTypes
 */
class MovementTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $movementTypes = $this->paginate($this->MovementTypes);

        $this->set(compact('movementTypes'));
        $this->set('_serialize', ['movementTypes']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->params['action'] = 'edit';
        $this->edit();
    }

    /**
     * Edit method
     *
     * @param string|null $id Movement Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($id) {
            $movementType = $this->MovementTypes->get($id);
        } else {
            $movementType = $this->MovementTypes->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $movementType = $this->MovementTypes->patchEntity($movementType, $this->request->data);
            if ($this->MovementTypes->save($movementType)) {
                $this->Flash->success(__('The movement type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The movement type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('movementType'));
        $this->set('_serialize', ['movementType']);

        $this->setLists();
    }

    /**
     * Delete method
     *
     * @param string|null $id Movement Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $movementType = $this->MovementTypes->get($id);
        if ($this->MovementTypes->delete($movementType)) {
            $this->Flash->success(__('The movement type has been deleted.'));
        } else {
            $this->Flash->error(__('The movement type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Lists for the views
     *
     * @return void
     * @access public
     */
    function setLists() {
        $this->set('movementTypeOutputs', MovementType::outputNames());
        $this->set('movementTypeViewPublics', MovementType::viewPublicNames());
    }
}
