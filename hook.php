<?php

/*
 -------------------------------------------------------------------------
 Historical Plugin for GLPI
 Copyright (C) 2020 by Curtis Conard
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

function plugin_historical_install()
{
   return true;
}

function plugin_historical_uninstall()
{
   return true;
}

function plugin_historical_getAddSearchOptions($itemtype)
{
   $opt = [];
   $plugin = new Plugin();
   if ($plugin->isActivated('historical')) {
      if ($itemtype === PluginHistoricalLog::class) {
         $log_table = PluginHistoricalLog::getTable();
         $opt = [
            '23002' => [
               'table'           => $log_table,
               'field'           => 'id',
               'name'            => __('ID'),
               'datatype'        => 'number',
               'massiveaction'   => false,
            ],
            '23003' => [
               'table'           => $log_table,
               'field'           => 'itemtype',
               'name'            => __('Item type'),
               'datatype'        => 'string',
               'massiveaction'   => false,
            ],
            '23004' => [
               'table'           => $log_table,
               'field'           => 'items_id',
               'name'            => __('Item ID'),
               'datatype'        => 'number',
               'massiveaction'   => false,
            ],
            '23005' => [
               'table'           => $log_table,
               'field'           => 'itemtype_link',
               'name'            => __('Item type link'),
               'datatype'        => 'string',
               'massiveaction'   => false,
            ],
            '23006' => [
               'table'           => $log_table,
               'field'           => 'linked_action',
               'name'            => __('Action'),
               'datatype'        => 'string',
               'massiveaction'   => false,
            ],
            '23007' => [
               'table'           => $log_table,
               'field'           => 'user_name',
               'name'            => __('User'),
               'datatype'        => 'string',
               'massiveaction'   => false,
            ],
            '23008' => [
               'table'           => $log_table,
               'field'           => 'date_mod',
               'name'            => __('Timestamp'),
               'datatype'        => 'datetime',
               'massiveaction'   => false,
            ],
            '23009' => [
               'table'           => $log_table,
               'field'           => 'id_search_option',
               'name'            => __('Search option'),
               'datatype'        => 'number',
               'massiveaction'   => false,
            ],
            '23010' => [
               'table'           => $log_table,
               'field'           => 'old_value',
               'name'            => __('Old value'),
               'datatype'        => 'string',
               'massiveaction'   => false,
            ],
            '23011' => [
               'table'           => $log_table,
               'field'           => 'new_value',
               'name'            => __('New value'),
               'datatype'        => 'string',
               'massiveaction'   => false,
            ],
         ];
      }
   }
   return $opt;
}