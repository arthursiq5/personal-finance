<?php
/**
 * @var \App\View\AppView $this
 */
echo $this->Html->css(['form', 'login']);
?>
<div class="container-fluid">
    <?php echo $this->Flash->render(); ?>
    <div class="row" id="login">
        <div class="col-12">
            <h1 class="title">Faça login ou <span>cadastre-se</span></h1>
        </div>
        <div class="content col-12 col-sm-6">
            <h2>Já tenho cadastro!</h2>
            <?php
                echo $this->Form->create(null, ['url' => '/cliente/login', 'class' => 'form']);
                ?>
                <div class="campos">
                    <?php
                        echo $this->Form->control('Login.email', ['label' => false, 'placeholder' => 'E-mail','div' => ['class' => 'form-group'],'class' => 'form-control','data-cypress' => 'login-email']);
                        echo $this->Form->control('Login.senha', ['label' => false, 'placeholder' => 'Senha', 'type' => 'password' ,'data-cypress' => 'login-senha' ,'div' => ['class' => 'form-group'],'class' => 'form-control']);
                    ?>
                </div>
                <?php
                echo $this->Form->submit('fazer login', ['name' => 'data[Login][login]','div' => false ,'data-cypress' => 'login-btn']);
                echo $this->Form->end();
            ?>
        </div>
        <div class="content col-12 col-sm-6">
            <h2>Quero me cadastrar!</h2>
            <p>
                Ao criar uma conta você poderá registrar suas finanças pessoais com facilidade
            </p>
            <?php echo $this->Html->link('cadastrar-se', '/cadastrar', ['class' => 'botao']); ?>
        </div>
    </div>
</div>
