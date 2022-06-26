<?php
/**
 * @var \App\View\AppView $this
 */
if (empty($url)) {
    return;
}
echo $this->Html->css('btn_add');
?>
<a id="btn-add" href="<?= $this->Url->build($url) ?>">
    <span></span>
</a>
