<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Lib\HashGenerationService;
use App\Model\Entity\Transaction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use DateTime;

/**
 * Transactions Model
 *
 * @property \App\Model\Table\WalletsTable&\Cake\ORM\Association\BelongsTo $Wallets
 *
 * @method \App\Model\Entity\Transaction newEmptyEntity()
 * @method \App\Model\Entity\Transaction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transaction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Transaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TransactionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Wallets', [
            'foreignKey' => 'wallet_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('wallet_id')
            ->requirePresence('wallet_id', 'create')
            ->notEmptyString('wallet_id');

        $validator
            ->scalar('description')
            ->maxLength('description', 32)
            ->allowEmptyString('description');

        $validator
            ->decimal('value')
            ->notEmptyString('value');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 128)
            ->notEmptyString('hash');

        $validator
            ->scalar('previous_hash')
            ->maxLength('previous_hash', 128)
            ->notEmptyString('previous_hash');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('wallet_id', 'Wallets'), ['errorField' => 'wallet_id']);

        return $rules;
    }

    public function addTransaction(Transaction $transaction): Transaction
    {
        $previousTransaction = $this->find()->order(['id' => 'DESC'])->first();
        $transaction->previous_hash = $previousTransaction->hash ?? '';
        $transaction->created = (new DateTime())->getTimestamp();
        $transaction->hash = (new HashGenerationService($transaction))->crypt();

        $transaction = $this->saveOrFail($transaction);

        $config = TableRegistry::getTableLocator()->exists('Wallets') ? [] : ['className' => WalletsTable::class];
        $Wallets = TableRegistry::getTableLocator()->get('Wallets', $config);

        $wallet = $Wallets->get($transaction->wallet_id);
        $wallet->balance += $transaction->value;

        $Wallets->save($wallet);

        return $transaction;
    }
}

