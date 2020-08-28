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

class PluginHistoricalLog extends CommonDBTM {

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
}