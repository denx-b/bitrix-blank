<?php

namespace Legacy\Model;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * Class PostingTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TIMESTAMP_X datetime mandatory default 'CURRENT_TIMESTAMP'
 * <li> STATUS string(1) mandatory default 'D'
 * <li> VERSION string(1) optional
 * <li> DATE_SENT datetime optional
 * <li> SENT_BCC string optional
 * <li> FROM_FIELD string(255) mandatory
 * <li> TO_FIELD string(255) optional
 * <li> BCC_FIELD string optional
 * <li> EMAIL_FILTER string(255) optional
 * <li> SUBJECT string(255) mandatory
 * <li> BODY_TYPE enum ('text', 'html') optional default 'text'
 * <li> BODY string mandatory
 * <li> DIRECT_SEND bool optional default 'N'
 * <li> CHARSET string(50) optional
 * <li> MSG_CHARSET string(255) optional
 * <li> SUBSCR_FORMAT string(4) optional
 * <li> ERROR_EMAIL string optional
 * <li> AUTO_SEND_TIME datetime optional
 * <li> BCC_TO_SEND string optional
 * </ul>
 *
 * @package Legacy\Model
 **/

class PostingTable extends Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_posting';
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
                'title' => Loc::getMessage('POSTING_ENTITY_ID_FIELD'),
            ),
            'TIMESTAMP_X' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => Loc::getMessage('POSTING_ENTITY_TIMESTAMP_X_FIELD'),
            ),
            'STATUS' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateStatus'),
                'title' => Loc::getMessage('POSTING_ENTITY_STATUS_FIELD'),
            ),
            'VERSION' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateVersion'),
                'title' => Loc::getMessage('POSTING_ENTITY_VERSION_FIELD'),
            ),
            'DATE_SENT' => array(
                'data_type' => 'datetime',
                'title' => Loc::getMessage('POSTING_ENTITY_DATE_SENT_FIELD'),
            ),
            'SENT_BCC' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('POSTING_ENTITY_SENT_BCC_FIELD'),
            ),
            'FROM_FIELD' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateFromField'),
                'title' => Loc::getMessage('POSTING_ENTITY_FROM_FIELD_FIELD'),
            ),
            'TO_FIELD' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateToField'),
                'title' => Loc::getMessage('POSTING_ENTITY_TO_FIELD_FIELD'),
            ),
            'BCC_FIELD' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('POSTING_ENTITY_BCC_FIELD_FIELD'),
            ),
            'EMAIL_FILTER' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateEmailFilter'),
                'title' => Loc::getMessage('POSTING_ENTITY_EMAIL_FILTER_FIELD'),
            ),
            'SUBJECT' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateSubject'),
                'title' => Loc::getMessage('POSTING_ENTITY_SUBJECT_FIELD'),
            ),
            'BODY_TYPE' => array(
                'data_type' => 'enum',
                'values' => array('text', 'html'),
                'title' => Loc::getMessage('POSTING_ENTITY_BODY_TYPE_FIELD'),
            ),
            'BODY' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => Loc::getMessage('POSTING_ENTITY_BODY_FIELD'),
            ),
            'DIRECT_SEND' => array(
                'data_type' => 'boolean',
                'values' => array('N', 'Y'),
                'title' => Loc::getMessage('POSTING_ENTITY_DIRECT_SEND_FIELD'),
            ),
            'CHARSET' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateCharset'),
                'title' => Loc::getMessage('POSTING_ENTITY_CHARSET_FIELD'),
            ),
            'MSG_CHARSET' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateMsgCharset'),
                'title' => Loc::getMessage('POSTING_ENTITY_MSG_CHARSET_FIELD'),
            ),
            'SUBSCR_FORMAT' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateSubscrFormat'),
                'title' => Loc::getMessage('POSTING_ENTITY_SUBSCR_FORMAT_FIELD'),
            ),
            'ERROR_EMAIL' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('POSTING_ENTITY_ERROR_EMAIL_FIELD'),
            ),
            'AUTO_SEND_TIME' => array(
                'data_type' => 'datetime',
                'title' => Loc::getMessage('POSTING_ENTITY_AUTO_SEND_TIME_FIELD'),
            ),
            'BCC_TO_SEND' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('POSTING_ENTITY_BCC_TO_SEND_FIELD'),
            ),
        );
    }

    /**
     * Returns validators for STATUS field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateStatus()
    {
        return array(
            new Main\Entity\Validator\Length(null, 1),
        );
    }

    /**
     * Returns validators for VERSION field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateVersion()
    {
        return array(
            new Main\Entity\Validator\Length(null, 1),
        );
    }

    /**
     * Returns validators for FROM_FIELD field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateFromField()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Returns validators for TO_FIELD field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateToField()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Returns validators for EMAIL_FILTER field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateEmailFilter()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Returns validators for SUBJECT field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateSubject()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Returns validators for CHARSET field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateCharset()
    {
        return array(
            new Main\Entity\Validator\Length(null, 50),
        );
    }

    /**
     * Returns validators for MSG_CHARSET field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateMsgCharset()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Returns validators for SUBSCR_FORMAT field.
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateSubscrFormat()
    {
        return array(
            new Main\Entity\Validator\Length(null, 4),
        );
    }
}
