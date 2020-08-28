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

define('PLUGIN_HISTORICAL_VERSION', '1.0.0');
define('PLUGIN_HISTORICAL_MIN_GLPI', '9.5.0');
define('PLUGIN_HISTORICAL_MAX_GLPI', '9.6.0');

function plugin_init_historical() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['historical'] = true;
   if (Log::canView()) {
      $PLUGIN_HOOKS['menu_toadd']['historical'] = ['admin' => 'PluginHistoricalLog'];
   }
}

function plugin_version_historical() {
   
   return [
      'name' => __('Historical Plugin for GLPI', 'historical'),
      'version' => PLUGIN_HISTORICAL_VERSION,
      'author'  => 'Curtis Conard',
      'license' => 'GPLv2',
      'homepage'=>'https://github.com/cconard96/historical',
      'requirements'   => [
         'glpi'   => [
            'min' => PLUGIN_HISTORICAL_MIN_GLPI,
            'max' => PLUGIN_HISTORICAL_MAX_GLPI
         ]
      ]
   ];
}

function plugin_historical_check_prerequisites() {
   if (!method_exists('Plugin', 'checkGlpiVersion')) {
      $version = preg_replace('/^((\d+\.?)+).*$/', '$1', GLPI_VERSION);
      $matchMinGlpiReq = version_compare($version, PLUGIN_HISTORICAL_MIN_GLPI, '>=');
      $matchMaxGlpiReq = version_compare($version, PLUGIN_HISTORICAL_MAX_GLPI, '<');
      if (!$matchMinGlpiReq || !$matchMaxGlpiReq) {
         echo vsprintf(
            'This plugin requires GLPI >= %1$s and < %2$s.',
            [
               PLUGIN_HISTORICAL_MIN_GLPI,
               PLUGIN_HISTORICAL_MAX_GLPI,
            ]
         );
         return false;
      }
   }
   return true;
}

function plugin_historical_check_config()
{
   return true;
}
