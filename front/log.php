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

include '../../../inc/includes.php';

$plugin = new Plugin();
if (!$plugin->isActivated('historical')) {
    Html::displayNotFoundError();
}

Html::header(Log::getTypeName(1), $_SERVER['PHP_SELF'], 'admin', 'PluginHistoricalLog');

if (Session::haveRight(Log::$rightname, READ)) {
    $_GET['sort'] = 8;
    $_GET['order'] = 'DESC';
    Search::show('PluginHistoricalLog');
} else {
    Html::displayRightError();
}
Html::footer();
