<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 */
class User extends Entity
{

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    const ROLE_ADMIN = 'admin';
    const ROLE_OPERATOR = 'operator';

    const ALERT_CLOSING_CREATED = 'closing_created';
    const ALERT_CLOSING_PACKAGES_CHANGED = 'closing_packages_changed';
    const ALERT_CLOSING_OUT_OF_LEVELS = 'closing_out_of_levels';
    const ALERT_CLOSING_STATUS_CHANGED = 'closing_status_changed';
    const ALERT_MOVEMENT_CREATED = 'movement_created';

    /**
     * Status names
     *
     * @var array
     */
    private static $statusNames;

    /**
     * Role names
     *
     * @var array
     */
    private static $roleNames;

    /**
     * Alert names
     *
     * @var array
     */
    private static $alertNames;

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
     * List of property names that should **not** be included in JSON or Array
     * representations of this Entity.
     *
     * @var array
     */
    protected $_hidden = ['password'];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * isAdmin
     *
     * @return boolean
     */
    public function isAdmin() {
        return $this->role === static::ROLE_ADMIN;
    }

    /**
     * Status names
     *
     * @return arrray Array of names
     */
    public static function statusNames() {
        if (!static::$statusNames) {
            static::$statusNames = [
                static::STATUS_ENABLED => __('Enabled'),
                static::STATUS_DISABLED => __('Disabled'),
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
     * Role names
     *
     * @return arrray Array of names
     */
    public static function roleNames() {
        if (!static::$roleNames) {
            static::$roleNames = [
                static::ROLE_ADMIN => __('Administrator'),
                static::ROLE_OPERATOR => __('Operator'),
            ];
        }

        return static::$roleNames;
    }

    /**
     * roleName
     *
     * @return string Role name
     */
    public function roleName() {
        $names = self::roleNames();
        return isset($names[$this->role]) ? $names[$this->role] : null;
    }

    /**
     * Alert names
     *
     * @return arrray Array of names
     */
    public static function alertNames() {
        if (!static::$alertNames) {
            static::$alertNames = [
                static::ALERT_MOVEMENT_CREATED => __('Movement created'),
                static::ALERT_CLOSING_CREATED => __('Closing created'),
                static::ALERT_CLOSING_PACKAGES_CHANGED => __('Packages changed at closing'),
                static::ALERT_CLOSING_OUT_OF_LEVELS => __('Out of levels at closing'),
                static::ALERT_CLOSING_STATUS_CHANGED => __('Closing status changed'),
            ];
        }

        return static::$alertNames;
    }

    /**
     * alertsName
     *
     * @return array Alerts name
     */
    public function alertsName() {
        if (!$this->alerts) {
            return [];
        }
        $names = self::alertNames();
        $alertsName = [];
        foreach ($this->alerts as $alert) {
            $alertsName[$alert] = isset($names[$alert]) ? $names[$alert] : null;
        }

        return $alertsName;
    }
}
