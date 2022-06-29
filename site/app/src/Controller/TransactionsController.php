<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Transaction;
use Exception;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Wallets'],
        ];
        $transactions = $this->paginate($this->Transactions);

        $this->set(compact('transactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Wallets'],
        ]);

        $this->set(compact('transaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addTransaction()
    {
        if (!empty($this->request->getData())) {
            try {
                $data = $this->request->getData();
                $transaction = $this->montaNovaTransacao($data);
                $transaction = $this->Transactions->addTransaction($transaction);
                $this->Flash->success('A transação foi criada com sucesso');
            } catch (Exception $e) {
                $this->Flash->error('Não foi possível adicionar uma nova transação');
            }

            return $this->redirect(['controller' => 'Wallets', 'action' => 'view', $data['wallet_id']]);
        }

        return $this->redirect(['controller' => 'Wallets', 'action' => 'index']);
    }

    /**
     * @param int|null $id transaction id
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function revertTransaction(?int $id = null)
    {
        if (!empty($id)) {
            $wallet = $this->Transactions->get($id, ['contain' => ['Wallets']])->wallet;
            if ($this->getLoggedUser()->id == $wallet->user_id) {
                try {
                    $transaction = $this->Transactions->revertTransaction($id);

                    return $this->redirect(['controller' => 'Wallets', 'action' => 'view', $transaction->wallet_id]);
                } catch (Exception $e) {
                    $this->Flash->error('Houve um erro ao reverter sua transação, tente novamente mais tarde');

                    return $this->redirect(['controller' => 'Wallets', 'action' => 'index']);
                }
            }
        }
        $this->Flash->error('Transação inválida, tente novamente');

        return $this->redirect(['controller' => 'Wallets', 'action' => 'index']);
    }

    /**
     * @param array $data dados da transação
     * @return \App\Model\Entity\Transaction
     */
    private function montaNovaTransacao(array $data): Transaction
    {
        $transaction = $this->Transactions->newEmptyEntity();
        $transaction->description = $data['description'];
        $transaction->value = floatval(str_replace(' ', '', $data['value']));
        $transaction->wallet_id = $data['wallet_id'];

        return $transaction;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->Transactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $wallets = $this->Transactions->Wallets->find('list', ['limit' => 200])->all();
        $this->set(compact('transaction', 'wallets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $wallets = $this->Transactions->Wallets->find('list', ['limit' => 200])->all();
        $this->set(compact('transaction', 'wallets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transactions->get($id);
        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
