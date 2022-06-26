<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet[]|\Cake\Collection\CollectionInterface $wallets
 */
?>
<div class="wallets index content">
    <?= $this->Html->link(__('New Wallet'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Wallets') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('balance') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wallets as $wallet): ?>
                <tr>
                    <td><?= $this->Number->format($wallet->id) ?></td>
                    <td><?= h($wallet->name) ?></td>
                    <td><?= $this->Number->format($wallet->balance) ?></td>
                    <td><?= $wallet->has('user') ? $this->Html->link($wallet->user->id, ['controller' => 'Users', 'action' => 'view', $wallet->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $wallet->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wallet->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wallet->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
