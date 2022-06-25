<?php

/**
  * @var \App\View\AppView $this
  */
echo $this->Html->css(['form']);
echo $this->Html->script('cadastrar_usuario.js');
echo $this->element('noscript');
?>
<div class="container-fluid" id="cadastro">
    <h1>Cadastro</h1>
    <?php if (isset($salvou)) { ?>
        <div class="col-xs-12 col-md-12" style="text-align:center">
            <?php if ($this->Cart->temProdutos()) : ?>
                <div class="alert alert-success" data-cypress="msg-cadastro-cliente" role="alert">
                    Seu cadastro foi realizado com sucesso!
                    <?php echo $this->Html->link('Clique aqui', '/pedido_rapido'); ?> para realizar o seu pedido!
                </div>
            <?php endif; ?>
                <div class="alert alert-success" data-cypress="msg-cadastro-cliente" role="alert">
                    Seu cadastro foi realizado com sucesso!
                </div>
        </div>
    <?php } ?>
    <?php echo $this->Flash->render(); ?>
    <div class="row" id="cadastro">
        <?php if (!isset($salvou)) : ?>
        <div class="col-12">
            <?php echo $this->Form->create($user, ['url' => '/users/cadastrar', 'class' => 'form']); ?>

            <h2>Dados de Cadastro</h2>
            <?php
                echo $this->Form->control('nome', ['label' => false, 'placeholder' => 'Nome*','div' => false,'class' => 'form-control', 'data-cypress' => 'cliente-nome']);
                echo $this->Form->control('email', ['label' => false, 'placeholder' => 'Email* ','div' => false,'class' => 'form-control', 'data-cypress' => 'cliente-email']);
                echo $this->Form->control('senha', ['label' => false, 'placeholder' => 'Senha* ', 'type' => 'password', 'div' => false,'class' => 'form-control']);
                echo $this->Form->control('senha_confirma', ['label' => false, 'placeholder' => 'Repita a senha*', 'type' => 'password','div' => false,'class' => 'form-control']);
                echo $this->Form->button('cadastrar', ['type' => 'submit']);
                echo $this->Form->end();
            ?>
        </div>

        <?php endif; ?>
    </div>

</div>
