<?php

/**
 * Form for editing typorepo block instances.
 *
 * @package   block_typorepo
 * @copyright 2011 Giedrius Balbieris (http://metalot.com)
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
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $DB;
/*
        $config = clone($data);
        // Move embedded files into a proper filearea and adjust HTML links to match
        $config->text = file_save_draft_area_files($data->text['itemid'], $this->context->id, 'block_typorepo', 'content', 0, array('subdirs'=>true), $data->text['text']);
        $config->format = $data->text['format'];
*/
        // saving happens here
        parent::instance_config_save($data, $nolongerused);
    }

    function instance_delete() {
        global $DB;
/*        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_html');
*/        return true;
    }

    function content_is_trusted() {
        global $SCRIPT;
/*
        if (!$context = get_context_instance_by_id($this->instance->parentcontextid)) {
            return false;
        }
        //find out if this block is on the profile page
        if ($context->contextlevel == CONTEXT_USER) {
            if ($SCRIPT === '/my/index.php') {
                // this is exception - page is completely private, nobody else may see content there
                // that is why we allow JS here
                return true;
            } else {
                // no JS on public personal pages, it would be a big security issue
                return false;
            }
        }
*/
        return true;
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
