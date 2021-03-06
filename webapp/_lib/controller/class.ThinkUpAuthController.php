<?php
/**
 *
 * ThinkUp/webapp/_lib/controller/class.ThinkUpAuthController.php
 *
 * Copyright (c) 2009-2011 Gina Trapani
 *
 * LICENSE:
 *
 * This file is part of ThinkUp (http://thinkupapp.com).
 *
 * ThinkUp is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any
 * later version.
 *
 * ThinkUp is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with ThinkUp.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 *
 * ThinkUp Authorized Controller
 *
 * Parent controller for all logged-in user-only actions
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2009-2010 Gina Trapani
 * @author Gina Trapani <ginatrapani[at]gmail[dot]com>
 *
 */
abstract class ThinkUpAuthController extends ThinkUpController {
    public function __construct($session_started=false) {
        parent::__construct($session_started);
    }

    public function control() {
        if ($this->isLoggedIn()) {
            return $this->authControl();
        } else {
            return $this->bounce();
        }
    }

    /**
     * Bounce user to public page or to error page.
     * @TODO bounce back to original action once signed in
     */
    protected function bounce() {
        if (get_class($this)=='DashboardController' || get_class($this)=='PostController') {
            $controller = new DashboardController(true);
            return $controller->go();
        } else {
            $config = Config::getInstance();
            throw new Exception('You must <a href="'.$config->getValue('site_root_path').
            'session/login.php">log in</a> to do this.');
        }
    }
}