<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table
{
    public function save(\Cake\Datasource\EntityInterface $entity, $options = [])
    {
        if (!isset($options['atomic'])) {
            $options['atomic'] = false;
        }

        return parent::save($entity, $options);
    }

    public function saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = []): \Cake\Datasource\EntityInterface
    {
        if (!isset($options['atomic'])) {
            $options['atomic'] = false;
        }

        return parent::saveOrFail($entity, $options);
    }
}
