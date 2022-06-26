<?php
/**
 * @var \App\View\AppView $this
 */
?>
<li class="nav-item">
    <a class="nav-link" href="<?= $this->Url->build('/login') ?>">
    <?= $this->Html->image('ico/user.png', ['class' => 'img-fluid ico']) ?>
        <?= $loggedUser->nome ?>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
        <?= $this->Html->image('ico/logout.png', ['class' => 'img-fluid ico']) ?>
        Logout
    </a>
</li>
