<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'logout', 'loginOperator', 'choose']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'order' => ['Users.name' => 'ASC'],
        ];
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * Choose method
     *
     * @return \Cake\Network\Response|null
     */
    public function choose()
    {
        $this->paginate = ['finder' => 'operators'];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
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
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($id) {
            $user = $this->Users->get($id);
        } else {
            $user = $this->Users->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['password']) && empty($this->request->data['password'])) {
                unset($this->request->data['password']);
            }
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($user->role === User::ROLE_OPERATOR) {
                $user->password = 'operator-pass';
            }
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }

        $this->setLists();
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function loginOperator($username)
    {
        $user = $this->Users->findByUsername($username)->first();
        if ($user) {
            $this->Auth->setUser($user->toArray());
            if ($user->isAdmin()) {
                return $this->redirect(['controller' => 'Closings', 'action' => 'index']);
            } else {
                return $this->redirect($this->Auth->redirectUrl());
            }
        } else {
            $this->Flash->error(__('Invalid operator'));
        }
    }

    public function operation()
    {
        $this->loadModel('Closings');
        $lastClosing = $this->Closings->find('last');

        $this->set(compact('lastClosing'));
    }

    /**
     * Lists for the views
     *
     * @return void
     * @access public
     */
    function setLists() {
        $this->set('userRoles', User::roleNames());
        $this->set('userStatus', User::statusNames());
        $this->set('userAlerts', User::alertNames());
    }

    /**
     * isAuthorized method
     *
     * @param array $user
     * @return boolean True if allowed
     */
    public function isAuthorized($user) {
        $allowUsers = ['operation'];
        if (in_array($this->request->action, $allowUsers) && $user) {
            return true;
        }

        return parent::isAuthorized($user);
    }

}
