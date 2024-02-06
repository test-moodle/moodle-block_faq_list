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
 * FAQ list class.
 *
 * File         faq_list.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_faq_list;

use block_faq_list\helper;
use stdClass;

class faq_list {

    public $DB;

    public $helper;

    public $table;

    public $table_titles;

    public $table_items;

    public function __construct() {
        global $DB;
        $this->DB = $DB;
        $this->helper = new helper();
        $this->table = 'faq_list';
        $this->table_titles = 'faq_list_title';
        $this->table_items = 'faq_list_item';
    }

    public function exist($shortname){
        $conditions = [
            'shortname' => $shortname,
        ];

        return $this->DB->record_exists($this->table, $conditions);
    }

    public function get_by_shortname($shortname) {
        $conditions = [
            'shortname' => $shortname,
        ];
        if($this->DB->record_exists($this->table, $conditions)) {
            return $this->DB->get_record($this->table, $conditions);
        }
        return false;
    }

    public function get_by_id($id) {
        $conditions = [
            'id' => $id,
        ];
        if($this->DB->record_exists($this->table, $conditions)) {
            return $this->DB->get_record($this->table, $conditions);
        }
        return false;
    }

    public function get_all() {
        return $this->DB->get_records($this->table, []);
    }

    public function get_items($list_id, $lang = null) {
        if (!$lang) {
            $lang = current_language();
        }

        $conditions = [
            'list_id' => $list_id,
            'lang' => $lang,
        ];

        return $this->DB->get_records($this->table_items, $conditions, 'sortorder');
    }

    public function create($faq_list) {
        $data = new stdClass();
        $data->shortname = $faq_list->shortname;
        //$faq_group_data->description = $data->description;

        return $this->DB->insert_record($this->table, $data, true);
    }

    public function update($faq_list) {
        $data = new stdClass();
        $data->id = $faq_list->id;
        $data->shortname = $faq_list->shortname;
        //$faq_group_data->description = $data->description;

        return $this->DB->update_record($this->table, $data);
    }

    public function delete($id) {
        $this->DB->delete_records($this->table, ['id' => $id]);
        $this->DB->delete_records($this->table_titles, ['list_id' => $id]);
        $this->DB->delete_records($this->table_items, ['list_id' => $id]);
    }

    public function get_available_faq_list_dropdown_options(){
        $data = [];
        $faq_lists = $this->get_all();

        foreach ($faq_lists as $faq_list) {
            $data[$faq_list->id] = $faq_list->shortname;
        }

        return $data;
    }

    public function get_title($list_id, $lang = null) {
        if (!$lang) {
            $lang = current_language();
        }
        $conditions = [
            'list_id' => $list_id,
            'lang' => $lang,
        ];
        if ($this->DB->record_exists($this->table_titles, $conditions)) {
            return $this->DB->get_record($this->table_titles, $conditions);
        }

        return false;
    }

    public function get_title_by_id($title_id) {
        $conditions = [
            'id' => $title_id,
        ];
        if ($this->DB->record_exists($this->table_titles, $conditions)) {
            return $this->DB->get_record($this->table_titles, $conditions);
        }
        return false;
    }

    public function add_title_translation($list_id, $title) {
        $data = new stdClass();
        $data->list_id = $list_id;
        $data->lang = $this->helper->get_last_edit_faq_lang();
        $data->title = $title;

        return $this->DB->insert_record($this->table_titles, $data, true);
    }

    public function update_title_translation($title_id, $title) {
        $data = new stdClass();
        $data->id = $title_id;
        $data->title = $title;

        return $this->DB->update_record($this->table_titles, $data);
    }

    public function export_faq_list($shortname, $show_title = false) {
        $data = [];

        if (!$this->exist($shortname)) {
            return $data;
        }

        $existing_list = $this->get_by_shortname($shortname);
        $faq_list_title = $this->get_title($existing_list->id);
        $faq_list_items = $this->get_items($existing_list->id);

        $data['show_title'] = $show_title;

        if ($show_title && $faq_list_title) {
            $data['faq_title'] = $faq_list_title->title;
        }
        else {
            $data['faq_title'] = '';
        }

        foreach ($faq_list_items as $faq_list_item) {
            $item = [
                'question' => $faq_list_item->question,
                'answer' => $faq_list_item->answer,
            ];
            $data['faq_items'][] = $item;
        }
        return $data;
    }

    public function export_faq_list_by_id($list_id, $show_title = false) {
        $existing_list = $this->get_by_id($list_id);

        if($existing_list) {
            return $this->export_faq_list($existing_list->shortname, $show_title);
        }

        return [];

    }
}