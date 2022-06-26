<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet[]|\Cake\Collection\CollectionInterface $wallets
 */
echo $this->Html->css(['wallet/index', 'card']);
?>
<div id="carteira">
    <div class="container-fluid">
        <div class="row">
            <h3>Minhas carteiras</h3>
            <p class="ordenar-por">
                <span class="badge"><?= $this->Paginator->sort('id') ?></span>
                <span class="badge"><?= $this->Paginator->sort('name') ?></span>
                <span class="badge"><?= $this->Paginator->sort('balance') ?></span>
            </p>
            <?php foreach ($wallets as $wallet): ?>
                <div class="col-12 col-md-4">
                    <a href="<?= $this->Url->build(['action' => 'view', $wallet->id]) ?>" class="card">
                        <div class="card-body">
                            <?= $this->Html->image('ico/wallet.png', ['class' => 'img-fluid ico']) ?>
                            <h5><?= $wallet->name ?></h5>
                            <h6><?= $wallet->balance ?></h6>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
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
    </div>
</div>

<?= $this->element('btn_add', ['url' => ['controller' => 'Wallets', 'action' => 'add']]) ?>
