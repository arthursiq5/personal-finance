<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Exception;

/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * @param \Cake\Event\EventInterface $event event
     * @return void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'cadastrar']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        // debug($this->request->getData());
        // exit();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'home',
            ]);

            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function cadastrar(): ?Response
    {
        $user = $this->Users->newEmptyEntity();
        $this->set(compact('user'));

        if (!empty($this->getRequest()->getData())) {
            try {
                $dados = $this->getRequest()->getData();

                $id = $this->Users->cadastrar_loja_virtual($dados);

                $this->set('salvou', 1);
                $this->getRequest()->getSession()->write('cliente', ['id' => $id]);

                return $this->redirect('/');
            } catch (Exception $e) {
                $this->Flash->error($e->getMessage());
            }
        }

        return null;
    }

    /**
     * @return void
     */
    public function home()
    {
    }
}
