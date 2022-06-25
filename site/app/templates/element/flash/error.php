<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
echo $this->Html->css('flash/error.css')
?>
<div class="message error alert alert-danger" onclick="this.classList.add('hidden');"><?= $message ?></div>
