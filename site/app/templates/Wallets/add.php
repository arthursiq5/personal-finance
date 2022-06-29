<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wallet $wallet
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
echo $this->Html->css(['wallet/index', 'form']);
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
                </div>
            </aside>
            <div class="wallets form content">
                <?= $this->Form->create($wallet) ?>
                <fieldset>
                    <legend>Adicionar Carteira</legend>
                    <?php
                        echo $this->Form->control('name', ['label' => false, 'placeholder' => 'Nome']);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
