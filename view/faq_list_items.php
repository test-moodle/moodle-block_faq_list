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
 * Display items (questions and answers) for selected FAQ list.
 *
 * File         faq_list_items.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_faq_list\faq_item;
use block_faq_list\faq_list;

require ('../../../config.php');


require_once ($CFG->libdir.'/adminlib.php');
global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/blocks/faq_list/view/faq_list_items.php');

require_login();
$PAGE->set_context(context_system::instance());


//$faq_list = new faq_list();
$faq_item = new faq_item();

$faq_list_id = optional_param('list_id', null, PARAM_INT);
$faq_lang = optional_param('faq_lang', null, PARAM_ALPHA);

if ($faq_list_id) {
    $faq_item->helper->set_last_edit_faq_list_id($faq_list_id);
}

if ($faq_lang) {
    $faq_item->helper->set_last_edit_faq_lang($faq_lang);
}


$current_list_id = $faq_item->helper->get_last_edit_faq_list_id();
$current_faq_lang = $faq_item->helper->get_last_edit_faq_lang();
$current_faq_list_title = $faq_item->get_title($current_list_id, $current_faq_lang);

$PAGE->set_pagelayout('admin');

$header = get_string('header:faq_item_list', 'block_faq_list');
$PAGE->set_title($header);
$PAGE->set_heading($header);

echo $OUTPUT->header();

$table = new html_table();

$table->head = [
    get_string('label:col_faq_item', 'block_faq_list'),
    get_string('label:col_action_edit', 'block_faq_list'),
    get_string('label:col_action_delete', 'block_faq_list'),
];

$table_rows = [];
$records = $faq_item->get_items($current_list_id, $current_faq_lang);

foreach ($records as $id => $record) {

    $url_param = [
        'faq_item_id' => $record->id,
    ];

    $view_url = new moodle_url('/blocks/faq_list/view/faq_item_manage.php', $url_param);

    // Link to edit faq item.
    $editlink = new moodle_url('/blocks/faq_list/view/faq_item_manage.php', $url_param);
    $editicon = $OUTPUT->action_icon($editlink, new \pix_icon('t/edit', get_string('button:edit_faq_item', 'block_faq_list')));

    //Link to delete faq item.
    $params = array_merge($url_param, ['action' => 'deleteitem']);
    $deletelink = new moodle_url('/blocks/faq_list/view/faq_item_delete.php', $params);
    $deleteicon = $OUTPUT->action_icon($deletelink, new \pix_icon('t/delete', get_string('button:delete_faq_item', 'block_faq_list')));

    $question_answer = '';
    $question_answer .= html_writer::tag('h3', $record->question, []);
    $question_answer .= html_writer::tag('div', $record->answer, []);

    $table_row = [
        //html_writer::link($view_url, $record->shortname),
        $question_answer,
        $editicon,
        $deleteicon,
    ];
    $table_rows[] = $table_row;
}

$table->data = $table_rows;

$options = $faq_item->get_available_faq_list_dropdown_options();
echo $OUTPUT->single_select($PAGE->url, 'list_id', $options, $current_list_id);
echo html_writer::tag('hr','', []);

$faq_title = get_string('header:faq_title', 'block_faq_list');
$faq_title .= ': ';
if ($current_faq_list_title) {
    $faq_title .= $current_faq_list_title->title;
}
else {
    $faq_title .= '/';
}

echo html_writer::tag('h2', $faq_title, []);

if ($current_faq_list_title) {
    $action_url = new moodle_url('/blocks/faq_list/view/faq_list_title.php', ['faq_title_id' => $current_faq_list_title->id]);
    echo $OUTPUT->single_button($action_url,get_string('button:edit_faq_title', 'block_faq_list'), 'POST', ['type' => 'warning']);

}
else {
    $action_url = new moodle_url('/blocks/faq_list/view/faq_list_title.php');
    echo $OUTPUT->single_button($action_url,get_string('button:add_faq_title', 'block_faq_list'), 'POST', ['type' => 'info']);

}

$tabs = $faq_item->helper->get_faq_list_items_language_tabs();
echo $OUTPUT->tabtree($tabs, 'faq_lang_' . $faq_item->helper->get_last_edit_faq_lang());

echo html_writer::table($table);

$action_url = new moodle_url('/blocks/faq_list/view/faq_item_manage.php');
echo $OUTPUT->single_button($action_url,get_string('button:add_faq_item', 'block_faq_list'), 'POST', ['type' => 'success']);

$action_url = new moodle_url('/blocks/faq_list/view/faq_lists.php');
echo $OUTPUT->single_button($action_url,get_string('button:back_to_faq_list', 'block_faq_list'), 'POST', ['type' => 'danger']);

echo $OUTPUT->footer();