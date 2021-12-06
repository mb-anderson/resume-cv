<?php

namespace Src\Entity;

use CoreDB\Kernel\Model;
use CoreDB\Kernel\Database\DataType\ShortText;
use CoreDB\Kernel\Database\DataType\TableReference;

/**
 * Object relation with table sessions
 * @author murat
 */

class Session extends Model
{

    public const POLICY_FULL_ONE_DEVICE_LOGIN = "full_one_device_login";
    public const POLICY_ROLE_BASED_ONE_DEVICE_LOGIN = "role_based_one_device_login";
    public const POLICY_NO_RESTRICTIONS = "no_restrictions";

    /**
    * @var ShortText $session_key
    * Session key generated by php.
    */
    public ShortText $session_key;
    /**
    * @var ShortText $ip_address
    * Ip adress of user logged in device.
    */
    public ShortText $ip_address;
    /**
    * @var TableReference $user
    * User reference. Logged in user.
    */
    public TableReference $user;
    /**
    * @var ShortText $remember_me_token
    * Remember me token for session.
    */
    public ShortText $remember_me_token;

    /**
     * @inheritdoc
     */
    public static function getTableName(): string
    {
        return "sessions";
    }

    public function save()
    {
        self::checkLoginPolicy(\CoreDB::currentUser());
        return parent::save();
    }

    public static function checkLoginPolicy(User $user)
    {
        if (defined("LOGIN_POLICY") && LOGIN_POLICY != self::POLICY_NO_RESTRICTIONS) {
            switch (LOGIN_POLICY) {
                case self::POLICY_FULL_ONE_DEVICE_LOGIN:
                    self::clearUserSessions($user);
                    break;
                case self::POLICY_ROLE_BASED_ONE_DEVICE_LOGIN:
                    if (!empty($user->roles->getValue())) {
                        foreach (LOGIN_POLICY_ROLES as $role) {
                            if ($user->isUserInRole($role)) {
                                self::clearUserSessions($user);
                                break;
                            }
                        }
                    }
                    break;
            }
        }
    }

    private static function clearUserSessions(User $user)
    {
        \CoreDB::database()->delete(Session::getTableName())
        ->condition("user", $user->ID->getValue())
        ->condition("ip_address", User::getUserIp(), "=", "OR")
        ->execute();
    }
}
