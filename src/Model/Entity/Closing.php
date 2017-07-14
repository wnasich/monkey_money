<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Closing Entity.
 *
 * @property int $id
 * @property string $number
 * @property float $closing_amount
 * @property float $change_amount
 * @property string $change_bills
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $created_by
 * @property \App\Model\Entity\User $created_by_user
 * @property int $modified_by
 */
class Closing extends Entity
{

    const STATUS_CREATED = 'created';
    const STATUS_TO_VERIFY = 'to_verify';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REMOVED = 'removed';

    const BILL_LEVEL_OK = 'level_ok';
    const BILL_LEVEL_LOW = 'level_low';
    const BILL_LEVEL_HIGH = 'level_high';

    /**
     * Status names
     *
     * @var array
     */
    private static $statusNames;

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
     * Status names
     *
     * @return arrray Array of names
     */
    public static function statusNames() {
        if (!static::$statusNames) {
            static::$statusNames = [
                static::STATUS_CREATED => __('Created'),
                static::STATUS_TO_VERIFY => __('To verify'),
                static::STATUS_VERIFIED => __('Verified'),
                static::STATUS_REMOVED => __('Removed'),
            ];
        }

        return static::$statusNames;
    }

    /**
     * statusName
     *
     * @return string Status name
     */
    public function statusName() {
        $names = self::statusNames();
        return isset($names[$this->status]) ? $names[$this->status] : null;
    }

    /**
     * billCodeIsPackage
     *
     * @param string $billCode Bill code for determine package or normal change
     * @return boolean
     */
    public function billCodeIsPackage($billCode) {
        $billsDef = getBillsDefinitions();
        return isset($billsDef['packages'][$billCode]);
    }

    /**
     * billLevel
     *
     * @param string $billCode Bill code for determine level
     * @return string Level: BILL_LEVEL_OK, BILL_LEVEL_LOW, BILL_LEVEL_HIGH
     */
    public function billLevel($billCode)
    {
        $billsDef = getBillsDefinitions();
        $bills = $billsDef['bills'] + $billsDef['packages'];

        $billLevel = self::BILL_LEVEL_OK;
        $billCount = isset($this->change_bills[$billCode]) ? $this->change_bills[$billCode] : 0;
        if ($bills[$billCode]['lowLevel'] !== null) {
            if ($billCount < $bills[$billCode]['lowLevel']) {
                $billLevel = self::BILL_LEVEL_LOW;
            }
        }
        if ($bills[$billCode]['highLevel'] !== null) {
            if ($billCount > $bills[$billCode]['highLevel']) {
                $billLevel = self::BILL_LEVEL_HIGH;
            }
        }

        return $billLevel;
    }

    /**
     * isBillLow
     *
     * @param string $billCode Bill code for determine if level is BILL_LEVEL_LOW
     * @return boolean
     */
    public function isBillLow($billCode)
    {
        return ($this->billLevel($billCode) === self::BILL_LEVEL_LOW);
    }

    /**
     * isBillHigh
     *
     * @param string $billCode Bill code for determine if level is BILL_LEVEL_HIGH
     * @return boolean
     */
    public function isBillHigh($billCode)
    {
        return ($this->billLevel($billCode) === self::BILL_LEVEL_HIGH);
    }
}
