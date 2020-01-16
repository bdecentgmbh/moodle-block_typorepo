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
 * Version information
 *
 * @package   block_typorepo
 * @copyright 2020 bdecent gmbh <https://bdecent.de>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_typorepo_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
	    global $CFG, $USER, $COURSE;

        $config = get_config('typorepo');

        $time = time();
        $course = isset($_GET['course']) ? $_GET['course'] : '';
        $id = isset($_GET['update']) ? $_GET['update'] : '';
        $token = MD5($id . $USER->username . $USER->firstname . $USER->lastname . $course . $time . $USER->email . get_config('typorepo', 'typorepo_secret'));

	    $mform->addElement('html', '<iframe src="' . get_config('typorepo', 'typorepo_url') . '&token=' . $token . '&time=' . $time . '&moodlemodid=' . $id . '&login=' . $USER->username . '&firstname=' .  $USER->firstname . '&lastname=' .  $USER->lastname . '&courseid=' .  $course . '&email=' .  $USER->email . '" frameborder="0" scrolling="' . get_config('typorepo', 'typorepo_scrolling') . '" width="' . get_config('typorepo', 'typorepo_width') . '" height="' . get_config('typorepo', 'typorepo_height') . '"> </iframe>');


	    $woptions = array('frameset' => get_string('frameset', 'typorepo'), 'newwindow' => get_string('newwindow', 'typorepo'), 'iframe' => get_string('iframe', 'typorepo'));

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_typorepo'));
        $mform->setType('config_title', PARAM_TEXT);

        $mform->addElement('text', 'config_url', get_string('url', 'block_typorepo'));
        $mform->setType('config_url', PARAM_URL);

        $mform->addElement('text', 'config_height', get_string('height', 'block_typorepo'));
        $mform->setType('config_height', PARAM_INT);
        $mform->setDefault('config_height', 150);

        //-------------------------------------------------------
        $mform->addElement('hidden', 'revision');
        $mform->setType('revision', PARAM_INT);
        $mform->setDefault('revision', 1);
    }
}
