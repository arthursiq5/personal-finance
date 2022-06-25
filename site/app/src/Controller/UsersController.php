<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;
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
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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

    /**
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        if ($this->User->isUsuarioLogado()) {
            return $this->redirect($this->User->loginRedirect);
        }

        if (!empty($this->request->getData())) {
            try {
                $email = $this->request->getData()['email'];
                $senha = $this->request->getData()['senha'];
                $user = $this->Usuarios->getUsuarioValido($email, $senha);
                $this->User->fazerLogin($user);
            } catch (Exception $e) {
                $this->Flash->error($e->getMessage());
            }
        }
    }

    public function autenticar()
    {
        if (!$this->getRequest()->is('post')) {
            throw new BadRequestException('Deve ser uma requisição POST!');
        }

        if (!$this->getRequest()->is('json')) {
            throw new BadRequestException('A rerquisição deve ser JSON!');
        }

        $email = $this->request->getData()['email'];
        $senha = $this->request->getData()['senha'];

        try {
            $user = $this->Usuarios->getUsuarioValido($email, $senha);
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
        $this->set('token', $user->token);
        $this->viewBuilder()->setOption('serialize', ['token']);
    }

    public function logout()
    {
        $this->User->fazerLogout();
    }

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
}
