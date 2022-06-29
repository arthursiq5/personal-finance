<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet $wallet
 */
echo $this->Html->css(['wallet/index', 'wallet/view']);
?>
<div id="carteira">
    <div class="row">
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
        </div>
    </div>
</div>
