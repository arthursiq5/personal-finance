<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Exception;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends AppTable
{
    public $validate = [
        'nome' => ['rule' => '/.+/', 'message' => 'Preencha corretamente o campo nome!'],
        'email' => [
            'rule1' => [
                'rule' => 'email',
                'message' => 'Preencha corretamente o campo email!',
                'required' => true,
            ],
            'rule2' => [
                'rule' => 'isUnique',
                'message' => 'Este email já existe',
            ],
        ],
        'ativo' => ['numeric'],
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always',
                ],
            ],
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
            ->scalar('nome')
            ->maxLength('nome', 100)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('senha')
            ->maxLength('senha', 200)
            ->requirePresence('senha', 'create')
            ->notEmptyString('senha');

        $validator
            ->boolean('ativo')
            ->notEmptyString('ativo');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }

    public function getSenhaCriptografada($senha, $salt = null): string
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    public function senhasIguais(string $senhaInformada, string $senhaBancoDados): bool
    {
        return password_verify($senhaInformada, $senhaBancoDados);
    }

    public function getSenhaAleatoria($digitos = 5): string
    {
        $novaSenha = "";
        for ($x = 0; $x < $digitos; $x++) {
            $novaSenha .= rand(0, 9);
        }

        return $novaSenha;
    }

    public function trocarSenha($id, $novaSenha): void
    {
        $senha = $this->getSenhaCriptografada($novaSenha);
        $entity = $this->newEmptyEntity();
        $entity->id = $id;
        $entity->senha = $senha;
        if (!$this->save($entity)) {
            throw new Exception('Não foi possível salvar a nova senha!');
        }
    }

    public function getUsuarioValido($email, $senha): User
    {
        $usuario = $this->findByEmail($email)->first();
        if (empty($usuario)) {
            throw new Exception('Usuário não encontrado!');
        }

        if (!$this->senhasIguais($senha, $usuario->senha)) {
            throw new Exception('Usuário ou senha inválidos!');
        }

        return $usuario;
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!$entity->isNew()) {
            return true;
        }

        $entity->token = md5(time());
        $entity->senha = $this->getSenhaCriptografada($entity->senha);
    }
}
