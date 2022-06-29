<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Exception;

/**
 * User component
 */
class UserComponent extends Component
{
    private $usuarioLogado;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    protected function getRequest(): \Cake\Http\ServerRequest
    {
        return $this->controller->getRequest();
    }

    private function setUsuarioLogado()
    {
        $this->usuarioLogado = $this->getUsuarioLogado();
        if (empty($this->usuarioLogado)) {
            return;
        }
    }

    /**
     * O usuário pode estar logado de duas maneiras:
     * Sessao
     * Token na requisição
     *
     * @return array|null
     */
    public function getUsuarioLogado(): ?array
    {
        $usuario = $this->Session->read('Usuario');
        if (!empty($usuario)) {
            return $usuario;
        }

        $auth = $this->getRequest()->getHeader('Authorization');
        if (empty($auth)) {
            return null;
        }

        [$tipo, $valor] = explode(' ', $auth[0]);
        if (strtolower($tipo) == 'basic') {
            [$login, $senha] = explode(':', base64_decode($valor));
            /** @var \App\Model\Table\UsersTable $usuarios */
            $usuarios = TableRegistry::getTableLocator()->get('Users');
            try {
                $usuario = $usuarios->getUsuarioValido($login, $senha);
                $usuarioArray = $usuario->toArray();
                unset($usuarioArray['senha'], $usuarioArray['created'], $usuarioArray['updated']);

                return $usuarioArray;
            } catch (Exception $e) {
                return null;
            }
        }

        if (strtolower($tipo) == 'bearer') {
            $token = $valor;
            /** @var \OwCore\Model\Table\UsuariosTable $usuarios */
            $usuarios = TableRegistry::getTableLocator()->get('OwCore.Usuarios');
            $usuario = $usuarios->findByToken($token)->first();
            if (empty($usuario)) {
                return null;
            }
            $usuarioArray = $usuario->toArray();
            unset($usuarioArray['senha']);

            return $usuarioArray;
        }

        return null;
    }

    public function isUsuarioLogado(): bool
    {
        return !empty($this->usuarioLogado);
    }
}
