<?php
/**
 * @var \App\View\AppView $this
 */
if (!empty($loggedUser)) {
    echo $this->element('topo_links/logado');
} else {
    echo $this->element('topo_links/nao_logado');
}
?>
