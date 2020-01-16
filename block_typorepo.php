<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   block_typorepo
 * @copyright 2020 bdecent gmbh <https://bdecent.de>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_typorepo extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_typorepo');
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('add', 'block_typorepo'));
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG, $USER, $COURSE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();

        // calculate the url
        $time = time();
	// '0' .
        $token = MD5($USER->username . $USER->firstname . $USER->lastname . $COURSE->id . $time . $USER->email . get_config('typorepo', 'typorepo_secret'));
	if(isset($this->config->url)) {
		$fullurl = $this->config->url . '&token=' . $token . '&time=' . $time . '&login=' . $USER->username . '&firstname=' .  $USER->firstname . '&lastname=' .  $USER->lastname . '&courseid=' .  $COURSE->id . '&email=' .  $USER->email;


		    $this->content->text = '<iframe style="margin-left: 0px;" src="' . $fullurl . '" frameborder="0" scrolling=no width="100%"  height="' . $this->config->height . '"> </iframe>';
		}
        return $this->content;
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }
}
