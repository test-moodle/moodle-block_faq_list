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
 * Create new FAQ list or edit existing one.
 *
 * File         faq_item_manage.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_faq_list\faq_item;
use block_faq_list\forms\faq_item_form;
use core\output\notification;

require ('../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once ($CFG->libdir.'/adminlib.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/blocks/faq_list/view/faq_item_manage.php');

require_login();
$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('admin');

//$faq_list = new faq_list();
$faq_item = new faq_item();
$faq_item_form = new faq_item_form();

$faq_item_id = optional_param('faq_item_id', null, PARAM_INT);

$header = get_string('header:faq_item_add', 'block_faq_list');
$PAGE->set_title($header);
$PAGE->set_heading($header);

$redirect_url  =new moodle_url('/blocks/faq_list/view/faq_list_items.php', []);


if($faq_item_form->is_cancelled()) {
    // Redirect to list of faq lists.
    redirect($redirect_url);
}

elseif ($data = $faq_item_form->get_data()) {
    // validation
    if($data->id) {
        $faq_item->update($data);
        redirect($redirect_url,
            get_string('msg_faq_item_updated', 'block_faq_list'),
            0,
            notification::NOTIFY_SUCCESS);
    }
    else {
        $faq_item->create($data);
        redirect($redirect_url,
            get_string('msg_faq_item_created', 'block_faq_list'),
            0,
            notification::NOTIFY_SUCCESS);
    }

}

if ($faq_item_id) {
    $existing_faq_item =  $faq_item->get_by_id($faq_item_id);

    $data = new stdClass();
    $data->id = $existing_faq_item->id;
    $data->question = $existing_faq_item->question;
    $data->answer['text'] = $existing_faq_item->answer;
    $data->answer['format'] = $existing_faq_item->answer_format;
    if($existing_faq_item) {
        $faq_item_form->set_data($data);
    }
    else {
        redirect($redirect_url,
            get_string('msg_faq_item_not_exist', 'block_faq_list'),
            0,
            notification::NOTIFY_ERROR
        );
    }
}


echo $OUTPUT->header();

$faq_item_form->display();

echo $OUTPUT->footer();