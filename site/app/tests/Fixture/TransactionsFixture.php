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
                'previous_hash' => 'Lorem ipsum dolor sit amet',
                'created' => 1656472373,
            ],
        ];
        parent::init();
    }
}
