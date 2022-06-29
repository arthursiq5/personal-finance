<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransactionsFixture
 */
class TransactionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'wallet_id' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'value' => 1.5,
                'hash' => 'Lorem ipsum dolor sit amet',
                'hash' => 'a2297e409d13db8ace7177bc9c07eb17be614b40d510d0b7b250c6967a96cc02bbed081241714146ceeb705d75701f6569e83c9932996b58502b57abf25ccc16',
                'previous_hash' => '',
                'created' => 1656473725,
            ],
        ];
        parent::init();
    }
}
