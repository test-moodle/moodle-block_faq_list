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
 * FAQ list helper class.
 *
 * File         helper.php
 * Encoding     UTF-8
 *
 * @package     block_faq_list
 *
 * @copyright   Agiledrop, 2024
 * @author      Agiledrop 2024 <hello@agiledrop.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_faq_list;

use cache;

class helper {

    private $DB;

    private $cache;

    private $table;

    private $table_titles;

    private $table_items;

    public function __construct() {
        global $DB;
        $this->DB = $DB;
        $this->cache = cache::make('block_faq_list', 'last_edit');
        $this->table = 'faq_list';
        $this->table_titles = 'faq_list_title';
        $this->table_items = 'faq_list_item';
    }

    // Cache funtions.
    public function get_last_edit_faq_list_id() {
        return $this->cache->get('faq_list_id');
    }

    public function set_last_edit_faq_list_id($list_id) {
        return $this->cache->set('faq_list_id', (int)$list_id);
    }

    public function get_last_edit_faq_item_id() {
        return $this->cache->get('faq_item_id');
    }

    public function set_last_edit_faq_item_id($item_id) {
        return $this->cache->set('faq_item_id', (int)$item_id);
    }

    public function get_last_edit_faq_lang() {
        if($this->cache->get('faq_lang')) {
            return $this->cache->get('faq_lang');
        }

        $current_language = current_language();
        $this->set_last_edit_faq_lang($current_language);
        return $current_language;
    }

    public function set_last_edit_faq_lang($lang) {
        return $this->cache->set('faq_lang', $lang);
    }

    public function get_faq_list_items_language_tabs() {

        $tabs = [];
        $translations = get_string_manager()->get_list_of_translations();

        foreach ($translations as $translation_id => $translation) {
            $url = new \moodle_url('/blocks/faq_list/view/faq_list_items.php',[
                'faq_lang' => $translation_id,
            ]);

            $tabs[] = new \tabobject(
                'faq_lang_' . $translation_id,
                $url,
                strtoupper($translation_id),
                $translation,
                false,
            );
        }
        return $tabs;
    }
}