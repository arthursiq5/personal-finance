<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Lib\HashGenerationService;
use App\Model\Entity\Transaction;
use App\Model\Table\TransactionsTable;
use App\Model\Table\WalletsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransactionsTable Test Case
 */
class TransactionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransactionsTable
     */
    protected $Transactions;
    /**
     * @var \App\Model\Table\WalletsTable
     */
    protected $Wallets;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Transactions',
        'app.Wallets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Transactions') ? [] : ['className' => TransactionsTable::class];
        $this->Transactions = $this->getTableLocator()->get('Transactions', $config);
        $config = $this->getTableLocator()->exists('Wallets') ? [] : ['className' => WalletsTable::class];
        $this->Wallets = $this->getTableLocator()->get('Wallets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Transactions);

        parent::tearDown();
    }

    public function testAddTransaction():void
    {
        $previousTransaction = $this->Transactions->get(1);
        $transaction = $this->Transactions->addTransaction(new Transaction([
            'description' => 'teste',
            'wallet_id' => 1,
            'value' => 1.5,
        ]));
        $this->assertEquals(2, $transaction->id);
        $this->assertEquals('teste', $transaction->description);
        $this->assertEquals($previousTransaction->hash, $transaction->previous_hash);
        $this->assertEquals(
            128,
            strlen($transaction->hash)
        );
        $this->assertEquals(3, $this->Wallets->get(1)->balance);
    }

    public function testRevertTransaction():void
    {
        $previousTransaction = $this->Transactions->get(1);
        $transaction = $this->Transactions->revertTransaction(1);
        $this->assertEquals(2, $transaction->id);
        $this->assertEquals('[REVERT TRANSACTION] 1', $transaction->description);
        $this->assertEquals($previousTransaction->hash, $transaction->previous_hash);
        $this->assertEquals(
            128,
            strlen($transaction->hash)
        );
        $this->assertEquals(0, $this->Wallets->get(1)->balance);
    }
}
