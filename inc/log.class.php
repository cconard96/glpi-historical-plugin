<?php
/*
 -------------------------------------------------------------------------
 Historical Plugin for GLPI
 Copyright (C) 2020-2021 by Curtis Conard
 https://github.com/cconard96/historical
 -------------------------------------------------------------------------
 LICENSE
 This file is part of Historical Plugin for GLPI.
 Historical Plugin for GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 Historical Plugin for GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with Historical Plugin for GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

class PluginHistoricalLog extends Log {

    /**
     * Get name of this type by language of the user connected
     *
     * @param integer $nb number of elements
     * @return string name of this type
     */
    public static function getTypeName($nb = 0) {
        return Log::getTypeName($nb);
    }

    public static function getMenuName()
    {
        return Log::getTypeName();
    }

    public static function getIcon() {
        return 'fas fa-clock';
    }

    /**
     * Check if can view item
     *
     * @return boolean
     */
    static function canView() {
        return Log::canView();
    }

    public static function getTable($classname = null)
    {
        return Log::getTable();
    }

    public static function getItemtypes()
    {
        static $glpiClasses = null;

        if ($glpiClasses === null) {
            $loadedClasses = get_declared_classes();
            $glpiClasses = [];

            foreach ($loadedClasses as $class) {
                if (is_subclass_of($class, 'CommonDBTM') && !is_subclass_of($class, 'CommonDBRelation')) {
                    $rc = new \ReflectionClass($class);
                    if (!$rc->isAbstract()) {
                        $glpiClasses[] = $class;
                    }
                }
            }
            sort($glpiClasses);
        }
        return $glpiClasses ?? [];
    }

    function rawSearchOptions() {
        $tab = [];
        $log_table = self::getTable();

        $tab[] = [
            'id'                 => 'common',
            'name'               => __('Characteristics')
        ];

        $tab[] = [
            'id'                 => '2',
            'table'              => $log_table,
            'field'              => 'id',
            'name'               => __('ID'),
            'massiveaction'      => false,
            'datatype'           => 'number'
        ];

        $tab[] = [
            'id'                 => '3',
            'table'              => $log_table,
            'field'              => 'itemtype',
            'name'               => __('Item type'),
            'searchtype'         => 'equals',
            'datatype'           => 'specific',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '4',
            'table'              => $log_table,
            'field'              => 'items_id',
            'name'               => __('Item ID'),
            'datatype'           => 'specific',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '5',
            'table'              => $log_table,
            'field'              => 'itemtype_link',
            'name'               => __('Item type link'),
            'datatype'           => 'string',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '6',
            'table'              => $log_table,
            'field'              => 'linked_action',
            'name'               => __('Action'),
            'datatype'           => 'specific',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '7',
            'table'              => $log_table,
            'field'              => 'user_name',
            'name'               => __('User'),
            'datatype'           => 'string',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '8',
            'table'              => $log_table,
            'field'              => 'date_mod',
            'name'               => __('Timestamp'),
            'datatype'           => 'datetime',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '9',
            'table'              => $log_table,
            'field'              => 'id_search_option',
            'name'               => __('Search option'),
            'datatype'           => 'specific',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '10',
            'table'              => $log_table,
            'field'              => 'old_value',
            'name'               => __('Old value'),
            'datatype'           => 'string',
            'massiveaction'      => false,
        ];

        $tab[] = [
            'id'                 => '11',
            'table'              => $log_table,
            'field'              => 'new_value',
            'name'               => __('New value'),
            'datatype'           => 'string',
            'massiveaction'      => false,
        ];

        return $tab;
    }

    static function getSpecificValueToSelect($field, $name = '', $values = '', array $options = [])
    {
        switch ($field) {
            case 'itemtype':
                return Dropdown::showItemTypes($name, self::getItemtypes(), $options);
        }
        return parent::getSpecificValueToSelect($field, $name, $values, $options); // TODO: Change the autogenerated stub
    }

    static function getSpecificValueToDisplay($field, $values, array $options = []) {
        if (!is_array($values)) {
            $values = [$field => $values];
        }
        switch ($field) {
            case 'itemtype':
                if (class_exists($values[$field])) {
                    return $values[$field]::getTypeName(1);
                }
                return $values[$field];
            case 'linked_action':
                if ($values[$field] === 0) {
                    return __('Update the item');
                }
                return Log::getLinkedActionLabel($values[$field]);
            case 'id_search_option':
                if ($options['raw_data']['raw']['ITEM_PluginHistoricalLog_3']) {
                    $itemtype = $options['raw_data']['raw']['ITEM_PluginHistoricalLog_3'];
                    if (class_exists($itemtype)) {
                        $search_options = (new $options['raw_data']['raw']['ITEM_PluginHistoricalLog_3']())->searchOptions();
                        return $search_options[$values[$field]]['name'] ?? $values[$field];
                    }
                }
                return __('Data not available');
            case 'items_id':
                if ($options['raw_data']['raw']['ITEM_PluginHistoricalLog_3']) {
                    /** @var CommonDBTM $itemtype */
                    $itemtype = $options['raw_data']['raw']['ITEM_PluginHistoricalLog_3'];
                    if (class_exists($itemtype)) {
                        return Html::link($values[$field], $itemtype::getFormUrlWithID($values[$field]));
                    }
                }
                return $values[$field];
        }
        return parent::getSpecificValueToDisplay($field, $values, $options);
    }
}
