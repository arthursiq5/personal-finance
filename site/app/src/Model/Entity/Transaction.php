<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Lib\HashableInterface;
use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int $wallet_id
 * @property string|null $description
 * @property string $value
 * @property string $hash
 * @property string $previous_hash
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Wallet $wallet
 */
class Transaction extends Entity implements HashableInterface
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'wallet_id' => true,
        'description' => true,
        'value' => true,
        'hash' => true,
        'previous_hash' => true,
        'created' => true,
        'wallet' => true,
    ];

    /**
     * @return string
     */
    public function getData(): string
    {
        $data = [
            'wallet_id' => $this->wallet_id,
            'description' => $this->description,
            'value' => $this->value,
            'previous_hash' => $this->previous_hash ?? '',
            'created' => $this->created,
        ];

        return json_encode($data);
    }
}
