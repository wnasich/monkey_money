<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MovementType Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $output
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \App\Model\Entity\Movement[] $movements
 */
class MovementType extends Entity
{

    const OUTPUT_NO = 0;
    const OUTPUT_YES = 1;

    const VIEW_PUBLIC_NO = 0;
    const VIEW_PUBLIC_YES = 1;

    /**
     * Output names
     *
     * @var array
     */
    private static $outputNames;

    /**
     * View public names
     *
     * @var array
     */
    private static $viewPublicNames;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Output names
     *
     * @return arrray Array of names
     */
    public static function outputNames() {
        if (!static::$outputNames) {
            static::$outputNames = [
                static::OUTPUT_NO => __('No'),
                static::OUTPUT_YES => __('Yes'),
            ];
        }

        return static::$outputNames;
    }

    /**
     * outputName
     *
     * @return string Output name
     */
    public function outputName() {
        $names = self::outputNames();
        return isset($names[$this->output]) ? $names[$this->output] : null;
    }

    /**
     * View public names
     *
     * @return arrray Array of names
     */
    public static function viewPublicNames() {
        if (!static::$viewPublicNames) {
            static::$viewPublicNames = [
                static::VIEW_PUBLIC_NO => __('No'),
                static::VIEW_PUBLIC_YES => __('Yes'),
            ];
        }

        return static::$viewPublicNames;
    }

    /**
     * viewPublicName
     *
     * @return string Output name
     */
    public function viewPublicName() {
        $names = self::viewPublicNames();
        return isset($names[$this->view_public]) ? $names[$this->view_public] : null;
    }
}
