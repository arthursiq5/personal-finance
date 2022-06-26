<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateWallet extends AbstractMigration
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
        $table = $this->table('wallets');
        $table->addColumn('name', 'string', [
            'default' => '',
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('balance', 'decimal', [
            'default' => 0,
            'null' => false,
            'precision' => 8,
            'scale' => 2,
        ]);
        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
        $table->create();

        $table->addForeignKey('user_id', 'users', 'id', [
            'update' => 'CASCADE',
            'delete' => 'CASCADE',
        ]);
        $table->update();
    }

    public function down()
    {
        $this->table('wallets')
            ->dropForeignKey('user_id')
            ->save();
        $this->table('wallets')
            ->drop()
            ->save();
    }
}
