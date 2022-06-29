<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet $wallet
 */
echo $this->Html->css(['wallet/index', 'wallet/view', 'form']);
?>
<div id="carteira">
    <div class="container-fluid">
        <div class="row">
                <aside class="column">
                    <div class="side-nav">
                        <a class="side-nav-item voltar" href="<?= $this->Url->build(['controller' => 'Wallets', 'action' => 'index']) ?>">
                            <?= $this->Html->image('ico/back.png', ['class' => 'img-fluid ico']) ?>
                            Listar Carteiras
                        </a>
                        <a class="side-nav-item voltar" href="<?= $this->Url->build(['controller' => 'Wallets', 'action' => 'hide', $wallet->id]) ?>">
                            <?= $this->Html->image('ico/eye.png', ['class' => 'img-fluid ico']) ?>
                            Ocultar carteira
                        </a>
                    </div>
                </aside>
                <div class="column-responsive column-80">
                    <div class="wallets view content">
                        <h3><?= h($wallet->name) ?></h3>
                        <table>
                            <tr>
                                <th>Nome</th>
                                <td><?= h($wallet->name) ?></td>
                            </tr>
                            <tr>
                                <th>Saldo</th>
                                <td><?= $this->Number->currency($wallet->balance, 'BRL') ?></td>
                            </tr>
                        </table>
                        <button id="newTransaction" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransaction">
                            <?= $this->Html->image('ico/transaction.png', ['class' => 'img-fluid ico']) ?>
                            Adicionar nova transação
                        </button>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= $transaction->id ?></td>
                            <td><?= h($transaction->description) ?></td>
                            <td><?= $this->Number->format($transaction->value) ?></td>
                            <td><?= $transaction->created->i18nFormat('dd/MM/yyyy') ?></td>
                            <td><a class="btn btn-primary" href="<?= $this->url->build(['controller' => 'Transactions', 'action' => 'revert_transaction', $transaction->id]) ?>">
                                Reverter transação
                            </a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->element('add_transaction', ['id' => 'addTransaction', 'walletId' => $wallet->id]) ?>
