<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet $wallet
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Wallet'), ['action' => 'edit', $wallet->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Wallet'), ['action' => 'delete', $wallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wallet->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Wallets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Wallet'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="wallets view content">
            <h3><?= h($wallet->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($wallet->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $wallet->has('user') ? $this->Html->link($wallet->user->id, ['controller' => 'Users', 'action' => 'view', $wallet->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($wallet->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Balance') ?></th>
                    <td><?= $this->Number->format($wallet->balance) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
