<?php

namespace Dbogdanoff\Model;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * Class SubscriptionTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DATE_INSERT datetime mandatory
 * <li> DATE_UPDATE datetime optional
 * <li> USER_ID int optional
 * <li> ACTIVE bool optional default 'Y'
 * <li> EMAIL string(255) mandatory
 * <li> FORMAT string(4) mandatory default 'text'
 * <li> CONFIRM_CODE string(8) optional
 * <li> CONFIRMED bool optional default 'N'
 * <li> DATE_CONFIRM datetime mandatory
 * </ul>
 *
 * @package Dbogdanoff\Model
 **/

class SubscriptionTable extends Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_subscription';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_ID_FIELD'),
            ),
            'DATE_INSERT' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_DATE_INSERT_FIELD'),
            ),
            'DATE_UPDATE' => array(
                'data_type' => 'datetime',
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_DATE_UPDATE_FIELD'),
            ),
            'USER_ID' => array(
                'data_type' => 'integer',
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_USER_ID_FIELD'),
            ),
            'ACTIVE' => array(
                'data_type' => 'boolean',
                'values' => array('N', 'Y'),
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_ACTIVE_FIELD'),
            ),
            'EMAIL' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateEmail'),
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_EMAIL_FIELD'),
            ),
            'FORMAT' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateFormat'),
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_FORMAT_FIELD'),
            ),
            'CONFIRM_CODE' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateConfirmCode'),
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_CONFIRM_CODE_FIELD'),
            ),
            'CONFIRMED' => array(
                'data_type' => 'boolean',
                'values' => array('N', 'Y'),
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_CONFIRMED_FIELD'),
            ),
            'DATE_CONFIRM' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_DATE_CONFIRM_FIELD'),
            ),
        );
    }

    /**
     * Returns validators for EMAIL field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateEmail()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Returns validators for FORMAT field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateFormat()
    {
        return array(
            new Main\Entity\Validator\Length(null, 4),
        );
    }

    /**
     * Returns validators for CONFIRM_CODE field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateConfirmCode()
    {
        return array(
            new Main\Entity\Validator\Length(null, 8),
        );
    }
}