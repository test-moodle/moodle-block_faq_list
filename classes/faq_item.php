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
 * FAQ item class.
 *
 * File         faq_item.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_faq_list;

use stdClass;

class faq_item extends faq_list {

    public function __construct() {
        parent::__construct();
    }


    public function get_by_id($id) {
        $conditions = [
            'id' => $id,
        ];
        if($this->DB->record_exists($this->table_items, $conditions)) {
            return $this->DB->get_record($this->table_items, $conditions);
        }
        return false;
    }

    public function get_items($list_id, $lang = null) {
        $conditions = [
            'list_id' => $list_id,
            'lang' => $lang,
        ];
        return $this->DB->get_records($this->table_items, $conditions, 'sortorder');
    }

    public function count_items($list_id, $lang) {
        $conditions = [
            'list_id' => $list_id,
            'lang' => $lang,
        ];

        return $this->DB->count_records($this->table_items, $conditions);
    }

    public function create($data) {

        $faq_list_id = $this->helper->get_last_edit_faq_list_id();
        $faq_lang = $this->helper->get_last_edit_faq_lang();
        $item_count = $this->count_items($faq_list_id, $faq_lang);

        $faq_item_data = new stdClass();
        $faq_item_data->list_id = $faq_list_id;
        $faq_item_data->lang = $faq_lang;
        $faq_item_data->question = $data->question;
        $faq_item_data->answer = $data->answer['text'];
        $faq_item_data->answer_format = $data->answer['format'];
        $faq_item_data->sortorder = $item_count + 1;

        return $this->DB->insert_record($this->table_items, $faq_item_data, true);
    }

    public function update($data) {
        $faq_item_data = new stdClass();
        $faq_item_data->id = $data->id;
        $faq_item_data->question = $data->question;
        $faq_item_data->answer = $data->answer['text'];
        $faq_item_data->answer_format = $data->answer['format'];

        return $this->DB->update_record($this->table_items, $faq_item_data);
    }

/*
        public function delete($id) {
            $this->DB->delete_records($this->table, ['id' => $id]);
            $this->DB->delete_records('block_faq_list_titles', ['group_id' => $id]);
            $this->DB->delete_records('block_faq_list_qa', ['group_id' => $id]);
        }
    */
}