<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Transaction'), ['action' => 'edit', $transaction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Transaction'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactions view content">
            <h3><?= h($transaction->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Wallet') ?></th>
                    <td><?= $transaction->has('wallet') ? $this->Html->link($transaction->wallet->name, ['controller' => 'Wallets', 'action' => 'view', $transaction->wallet->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($transaction->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hash') ?></th>
                    <td><?= h($transaction->hash) ?></td>
                </tr>
                <tr>
                    <th><?= __('Previous Hash') ?></th>
                    <td><?= h($transaction->previous_hash) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transaction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Value') ?></th>
                    <td><?= $this->Number->format($transaction->value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($transaction->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
