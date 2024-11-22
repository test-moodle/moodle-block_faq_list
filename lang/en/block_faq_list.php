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
 * Language file for block_faq_list, EN
 *
 * File         block_faq_list.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Capabilities.


// DEFAULT.
$string['blockname'] = 'Faq list';
$string['pluginname'] = 'Faq list';

// Headers.
$string['header:faq_list'] = 'FAQ list';
$string['header:faq_list_add'] = 'Create new FAQ list';
$string['header:faq_list_edit'] = 'Edit FAQ list';
$string['header:faq_list_delete'] = 'Delete FAQ list';
$string['header:faq_item_list'] = 'Questions and Answers list';
$string['header:faq_item_add'] = 'Create new Question';
$string['header:faq_item_edit'] = 'Edit Question';
$string['header:faq_item_delete'] = 'Delete Question';
$string['header:faq_title_management'] = 'FAQ list title translation';
$string['header:faq_title'] = 'Title';

// Success strings.


// URL texts.
$string['admin:faq_category_title'] = 'FAQ list';
$string['admin:faq_manage_list'] = 'FAQ list manage';
$string['admin:faq_manage_item'] = 'FAQ list items manage (Questions and Anwers)';
$string['tab_faq_list'] = 'FAQ list';
$string['tab_faq_list_title'] = 'All FAQ list';
$string['tab_faq_list_add'] = 'Create new FAQ list';
$string['tab_faq_list_add_title'] = 'Create new FAQ list or edit existing one';


// Form Labels.
$string['label:config_faq_list_id'] = 'FAQ list';
$string['label:config_faq_list_id_help'] = 'Select which FAQ list will be displayed.';

$string['label:config_block_title'] = 'Display block title';
$string['label:config_block_title_help'] = 'Select how block title is displayed. If you choose display as faq title, note that this title must be provided for current language.';
$string['label:config_block_title_none'] = 'None - hide block title';
$string['label:config_block_title_pluginname'] = 'Display block title as pluginname';
$string['label:config_block_title_faq'] = 'Display block title as title of selected faq list.';

$string['label:config_show_faq_title'] = 'Show FAQ list title';
$string['label:config_show_faq_title_help'] = 'Display FAQ list title or not. It is possible to show twice the same title if you are not carefully.';

$string['label:config_display_type'] = 'Show FAQ list as';
$string['label:faq_list_shortname'] = 'Unique shortname';
$string['label:faq_list_shortname_help'] = 'Enter unique name. Allowed character are: [0-9][A-Z][a-z][_]';
$string['label:faq_list_description'] = 'Description';
$string['label:faq_list_description_help'] = 'Short description';
$string['label:faq_list_delete_question'] = 'Do you want to delete FAQ list?';
$string['label:faq_item_delete_question'] = 'Do you want to delete FAQ item?';
$string['label:faq_question'] = 'Question';
$string['label:faq_question_help'] = 'Write text for question.';
$string['label:faq_answer'] = 'Answer';
$string['label:faq_answer_help'] = 'Write text for answer the question.';
$string['label:faq_title'] = 'FAQ Title translation';
$string['label:faq_title_help'] = 'Enter translated title for selected language.';

// Errors.
$string['error:required'] = 'This field is required.';
$string['error:unique'] = 'This shortname already exist.';

// Buttons.
$string['button:delete_faq_list'] = 'Delete';
$string['button:edit_faq_list'] = 'Edit';
$string['button:back_to_faq_list'] = 'Back to FAQ list list';
$string['button:add_faq_title'] = 'Create title translation';
$string['button:edit_faq_title'] = 'Edit title translation';
$string['button:add_faq_item'] = 'Add new question';
$string['button:delete_faq_item'] = 'Delete';
$string['button:edit_faq_item'] = 'Edit';

// Tables.
$string['label:col_shortname'] = 'Shortname';
$string['label:col_description'] = 'Description';
$string['label:col_action_edit'] = 'Edit';
$string['label:col_action_delete'] = 'Delete';
$string['label:col_faq_item'] = 'Question and answer';

// Messages.
$string['msg_faq_list_created'] = 'FAQ list was successfully created.';
$string['msg_faq_list_updated'] = 'FAQ list was successfully updated.';
$string['msg_faq_list_deleted'] = 'FAQ list was successfully deleted.';
$string['msg_faq_list_not_exist'] = 'FAQ list not exist.';
$string['msg_faq_title_created'] = 'FAQ title successfully created.';
$string['msg_faq_title_updated'] = 'FAQ title successfully updated.';
$string['msg_faq_title_not_exist'] = 'FAQ title translation not exist.';
$string['msg_faq_item_created'] = 'Question and answer was successfully created.';
$string['msg_faq_item_updated'] = 'Question and answer was successfully updated.';
$string['msg_faq_item_deleted'] = 'Question and answer was successfully deleted.';
$string['msg_faq_item_not_exist'] = 'Question not exist.';

// View strings.


// Privacy.
$string['privacy:metadata'] = 'The Faq list block does not store any user data.';
