<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTransactions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('transactions');
        $table->addColumn('wallet_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('description', 'string', [
            'default' => '',
            'limit' => 32,
            'null' => true,
        ]);
        $table->addColumn('value', 'decimal', [
            'default' => 0,
            'null' => false,
            'precision' => 8,
            'scale' => 2,
        ]);
        $table->addColumn('previous_hash', 'string', [
            'default' => '',
            'limit' => 128
        ]);
        $table->addColumn('created', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->create();

        $table->addForeignKey('wallet_id', 'wallets', 'id', [
            'update' => 'CASCADE',
            'delete' => 'CASCADE',
        ]);
        $table->update();
    }
}
