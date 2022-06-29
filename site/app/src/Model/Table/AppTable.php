<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;

class AppTable extends Table
{
    /**
     * @param \Cake\Datasource\EntityInterface $entity entidade
     * @param array $options opções
     * @return \Cake\Datasource\EntityInterface|void
     */
    public function save(EntityInterface $entity, $options = [])
    {
        if (!isset($options['atomic'])) {
            $options['atomic'] = false;
        }

        return parent::save($entity, $options);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $entity entidade
     * @param array $options opções
     * @return \Cake\Datasource\EntityInterface|void
     */
    public function saveOrFail(EntityInterface $entity, $options = []): EntityInterface
    {
        if (!isset($options['atomic'])) {
            $options['atomic'] = false;
        }

        return parent::saveOrFail($entity, $options);
    }
}
