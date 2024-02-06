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
 * Manage FAQ list title translation.
 *
 * File         faq_list_title.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_faq_list\faq_list;
use block_faq_list\forms\faq_list_title_form;
use core\output\notification;

require ('../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once ($CFG->libdir.'/adminlib.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/blocks/faq_list/view/faq_list_title.php');

require_login();
$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('admin');

//$faq_list = new faq_list();
$faq_list = new faq_list();
$faq_title_form = new faq_list_title_form();

$faq_title_id = optional_param('faq_title_id', null, PARAM_INT);

$header = get_string('header:faq_title_management', 'block_faq_list');
$PAGE->set_title($header);
$PAGE->set_heading($header);

$redirect_url  =new moodle_url('/blocks/faq_list/view/faq_list_items.php', []);


if($faq_title_form->is_cancelled()) {
    // Redirect to list of faq lists.
    redirect($redirect_url);
}

elseif ($data = $faq_title_form->get_data()) {
    // validation
    if($data->id) {
        $faq_list->update_title_translation($data->id, $data->title);
        redirect($redirect_url,
            get_string('msg_faq_title_updated', 'block_faq_list'),
            0,
            notification::NOTIFY_SUCCESS);
    }
    else {
        $faq_list->add_title_translation($faq_list->helper->get_last_edit_faq_list_id(), $data->title,);
        redirect($redirect_url,
            get_string('msg_faq_title_created', 'block_faq_list'),
            0,
            notification::NOTIFY_SUCCESS);
    }

}

if ($faq_title_id) {
    $existing_faq_title =  $faq_list->get_title_by_id($faq_title_id);

    $data = new stdClass();
    $data->id = $existing_faq_title->id;
    $data->title = $existing_faq_title->title;

    if($existing_faq_title) {
        $faq_title_form->set_data($data);
    }
    else {
        redirect($redirect_url,
            get_string('msg_faq_title_not_exist', 'block_faq_list'),
            0,
            notification::NOTIFY_ERROR
        );
    }
}


echo $OUTPUT->header();

$faq_title_form->display();

echo $OUTPUT->footer();