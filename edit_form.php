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
use block_faq_list\faq_list;


/**
 * Edit form for each block instance.
 *
 * File         block_faq_list_edit_form.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_faq_list_edit_form extends block_edit_form {

    protected function specific_definition($mform) {


        $has_config = $this->block->config;

        $faq_list = new faq_list();

        $choices = $faq_list->get_available_faq_list_dropdown_options();

        $mform->addElement('select', 'config_faq_list_id', get_string('label:config_faq_list_id', 'block_faq_list'), $choices);
        $mform->setType('config_faq_list_id', PARAM_ALPHANUM);

        $show_title_choices = [];
        $show_title_choices[] = $mform->createElement('radio', 'show_title', '', get_string('yes'), true);
        $show_title_choices[] = $mform->createElement('radio', 'show_title', '', get_string('no'), false);
        $mform->addGroup($show_title_choices, 'config_show_title', 'Display faq title');
        $mform->setType('config_show_title', PARAM_BOOL);

        if($has_config) {
            $mform->setDefault('faq_list_id',$has_config->faq_list_id);
            $mform->setDefault('show_title', (bool)$has_config->show_title);
        }
    }


    //public function validation($data, $files) {
    //    return $this->validation($data, $files);
    //}

    /**
     * Display the configuration form when block is being added to the page
     *
     * @return bool
     */
    public static function display_form_when_adding(): bool {
        return true;
    }
}