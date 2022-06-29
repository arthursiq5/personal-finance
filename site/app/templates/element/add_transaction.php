<?php
/**
 * @var \App\View\AppView $this
 */
$id = $id;
$walletId = $walletId ?? null;
if (empty($id) || empty($walletId)) {
    return;
}
echo $this->Html->script('jquery.inputmask.bundle.js');
echo $this->Html->script('wallet/add_transaction');
?>
<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <?= $this->Form->create(null, ['url' => ['controller' => 'Transactions', 'action' => 'add_transaction']]) ?>
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $id ?>Label">Adicionar Transação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $this->Form->hidden('wallet_id', ['value' => $walletId]) ?>
                <?= $this->Form->control('description', ['label' => 'Descrição', 'placeholder' => 'Descrição']) ?>
                <?= $this->Form->control('value', ['label' => 'Valor', 'placeholder' => 'Valor', 'type' => 'string']) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                <?= $this->Form->button(__('Submit')) ?>
            </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>
