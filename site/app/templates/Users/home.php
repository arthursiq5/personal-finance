<?php
/**
 * @var \App\View\AppView $this
 */
echo $this->Html->css(['home', 'card']);
?>
<div id="home">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-4">
                <a href="<?= $this->Url->build(['controller' => 'Wallets', 'action' => 'index']) ?>" class="card">
                    <div class="card-body">
                        <?= $this->Html->image('ico/wallet.png', ['class' => 'img-fluid ico']) ?>
                        <h5>Carteiras</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
