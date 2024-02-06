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
 * Display list of all faq list.
 *
 * File         faq_lists.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_faq_list\faq_list;

require ('../../../config.php');

require_once ($CFG->libdir.'/adminlib.php');
global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/blocks/faq_list/view/faq_lists.php');

require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');

$header = get_string('header:faq_list', 'block_faq_list');
$PAGE->set_title($header);
$PAGE->set_heading($header);

echo $OUTPUT->header();

$faq_list = new faq_list();
$table = new html_table();

$table->head = [
    get_string('label:col_shortname', 'block_faq_list'),
    get_string('label:col_action_edit', 'block_faq_list'),
    get_string('label:col_action_delete', 'block_faq_list'),
];

$table_rows = [];
$records = $faq_list->get_all();

foreach ($records as $id => $record) {

    // Link to view faq list.
    $url_param = [
        'list_id' => $record->id,
    ];
    $view_url = new moodle_url('/blocks/faq_list/view/faq_list_items.php', $url_param);

    // Link to edit faq froup.
    $editlink = new moodle_url('/blocks/faq_list/view/faq_list_manage.php', $url_param);
    $editicon = $OUTPUT->action_icon($editlink, new \pix_icon('t/edit', get_string('button:edit_faq_list', 'block_faq_list')));

    //Link to delete faq list.
    $params = array_merge($url_param, ['action' => 'deletelist']);
    $deletelink = new moodle_url('/blocks/faq_list/view/faq_list_delete.php', $params);
    $deleteicon = $OUTPUT->action_icon($deletelink, new \pix_icon('t/delete', get_string('button:delete_faq_list', 'block_faq_list')));

    // Build table row.
    $table_row = [
        html_writer::link($view_url, $record->shortname),
        $editicon,
        $deleteicon,
    ];
    $table_rows[] = $table_row;
}

$table->data = $table_rows;

echo html_writer::table($table);

$action_url = new moodle_url('/blocks/faq_list/view/faq_list_manage.php');
echo $OUTPUT->single_button($action_url,get_string('header:faq_list_add', 'block_faq_list'), 'POST');

$neka = $faq_list->export_faq_list('login_page', true);
echo $OUTPUT->footer();