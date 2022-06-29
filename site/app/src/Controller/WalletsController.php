<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\TransactionsTable;

/**
 * Wallets Controller
 *
 * @property \App\Model\Table\WalletsTable $Wallets
 * @method \App\Model\Entity\Wallet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WalletsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'conditions' => [
                'Wallets.user_id' => $this->getLoggedUser()->id,
            ],
            'contain' => ['Users'],
        ];
        $wallets = $this->paginate($this->Wallets);

        $this->set(compact('wallets'));
    }

    /**
     * View method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => ['Users'],
        ]);

        if ($wallet->user->id != $this->getLoggedUser()->id) {
            $this->Flash->error('Essa carteira não foi encontrada');
            $this->redirect(['action' => 'index']);
        }

        $config = $this->getTableLocator()->exists('Transactions') ? [] : ['className' => TransactionsTable::class];
        $Transactions = $this->getTableLocator()->get('Transactions', $config);

        $transacoes = $Transactions->find()
            ->where(['wallet_id' => $wallet->id])
            ->order(['id' => 'DESC'])
            ->all();

        $this->set(compact('wallet'));
        $this->set('transactions', $transacoes);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wallet = $this->Wallets->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $this->getLoggedUser()->id;

            $wallet = $this->Wallets->patchEntity($wallet, $data);
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $users = $this->Wallets->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('wallet', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function hide($id = null)
    {
        $wallet = $this->Wallets->get($id);
        if ($this->Wallets->softDelete($wallet)) {
            $this->Flash->success('A carteira foi ocultada');
        } else {
            $this->Flash->error('Houve um erro ao ocultar sua carteira');
        }

        return $this->redirect(['action' => 'index']);
    }
}
