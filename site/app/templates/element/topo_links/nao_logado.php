<?php
/**
 * @var \App\View\AppView $this
 */
?>
<li class="nav-item">
    <a class="nav-link" href="<?= $this->Url->build('/login') ?>">
    <?= $this->Html->image('ico/user_add.png', ['class' => 'img-fluid ico']) ?>
        Entrar
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">
        <?= $this->Html->image('ico/info.png', ['class' => 'img-fluid ico']) ?>
        Sobre
    </a>
</li>
