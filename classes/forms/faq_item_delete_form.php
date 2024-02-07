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
 * FAQ list form for delete selected FAQ item.
 *
 * File         faq_item_delete_form.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_faq_list\forms;

use moodleform;

defined('MOODLE_INTERNAL') || die();

class faq_item_delete_form extends moodleform
{

    protected function definition()
    {
        $mform = $this->_form;

        // Header - question to delete.
        $mform->addElement('header', 'deletequestion', get_string('label:faq_item_delete_question', 'block_faq_list'));

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('static', 'question');

        $this->add_action_buttons(true, get_string('button:delete_faq_list', 'block_faq_list'));
    }


    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        return $errors;
    }

}