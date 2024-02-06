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
 * Delete existing FAQ list.
 *
 * File         faq_list_delete.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_faq_list\faq_list;
use block_faq_list\forms\faq_list_delete_form;

require ('../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once ($CFG->libdir.'/adminlib.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/blocks/faq_list/view/faq_list_delete.php');

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');

$faq_list = new faq_list();

$faq_list_id = optional_param('list_id', null, PARAM_INT);

$redirect_url  =new moodle_url('/blocks/faq_list/view/faq_lists.php', []);

if($faq_list_id) {
    $faq_list_data = $faq_list->get_by_id($faq_list_id);
    $faq_list_delete_form = new faq_list_delete_form();
    $faq_list_delete_form->set_data($faq_list_data);
}

else {
    $faq_list_delete_form = new faq_list_delete_form();
    if ($faq_list_delete_form->is_cancelled()) {
        redirect($redirect_url);
    }
}

if ($data = $faq_list_delete_form->get_data()) {
    // validation
    if($data->id) {
        $faq_list->delete($data->id);
        redirect($redirect_url,
            get_string('msg_faq_list_deleted', 'block_faq_list'),
            0,
            'info');
    }
    else {
        redirect($redirect_url,
            get_string('msg_faq_list_not_exist', 'block_faq_list'),
            0,
            'error');
    }
}

$header = get_string('header:faq_list_delete', 'block_faq_list');
$PAGE->set_title($header);
$PAGE->set_heading($header);

echo $OUTPUT->header();

$faq_list_delete_form->display();

echo $OUTPUT->footer();