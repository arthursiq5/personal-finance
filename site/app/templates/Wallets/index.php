<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet[]|\Cake\Collection\CollectionInterface $wallets
 */
echo $this->Html->css(['wallet/index', 'card', 'pagination']);
echo $this->Html->script('wallet/index');
?>
<div id="carteira">
    <div class="container-fluid">
        <div class="row">
            <h3>Minhas carteiras</h3>
            <a id="show-hide" href="#">
                <span class="img-show">
                    <?= $this->Html->image('ico/show.png', ['class' => 'img-fluid']) ?>
                    Mostrar
                </span>
                <span class="img-hide">
                    <?= $this->Html->image('ico/hide.png', ['class' => 'img-fluid']) ?>
                    Ocultar
                </span>
            </a>
            <p class="ordenar-por">
                <span class="badge"><?= $this->Paginator->sort('id') ?></span>
                <span class="badge"><?= $this->Paginator->sort('name') ?></span>
                <span class="badge"><?= $this->Paginator->sort('balance') ?></span>
            </p>
            <?php foreach ($wallets as $wallet): ?>
                <div class="wallet-item col-12 col-md-4" data-active="<?= $wallet->active ? 'true' : 'false' ?>">
                    <a href="<?= $this->Url->build(['action' => 'view', $wallet->id]) ?>" class="card">
                        <div class="card-body">
                            <?= $this->Html->image('ico/wallet.png', ['class' => 'img-fluid ico']) ?>
                            <h5><?= $wallet->name ?></h5>
                            <h6><?= $wallet->balance ?></h6>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="mt-3"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} carteiras de um total de {{count}}')) ?></p>
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                <?= $this->Paginator->prev('<', [], null, ['class' => 'prev disabled']); ?>
                <?= $this->Paginator->numbers(['separator' => '']); ?>
                <?= $this->Paginator->next('>', [], null, array('class' => 'next disabled')); ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->element('btn_add', ['url' => ['controller' => 'Wallets', 'action' => 'add']]) ?>
