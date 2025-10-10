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

namespace theme_boost_union\form;

use html_writer;
use moodle_url;

/**
 * Manage user private area files form
 *
 * @package    theme_boost_union
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class categoryimage extends \core_form\dynamic_form {

    /**
     * Add elements to this form.
     */
    public function definition() {
        global $OUTPUT;
        $mform = $this->_form;
        $options = $this->get_options();

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $options);

        $this->add_action_buttons();
    }

    /**
     * Validate incoming data.
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        $errors = array();
        $draftitemid = $data['files_filemanager'];
        $options = $this->get_options();
        if (file_is_draft_area_limit_reached($draftitemid, $options['areamaxbytes'])) {
            $errors['files_filemanager'] = get_string('userquotalimit', 'error');
        }

        return $errors;
    }

    /**
     * Check if current user has access to this form, otherwise throw exception
     *
     * Sometimes permission check may depend on the action and/or id of the entity.
     * If necessary, form data is available in $this->_ajaxformdata or
     * by calling $this->optional_param()
     */
    public function check_access_for_dynamic_submission(): void {
        core_course_category::has_capability_on_any(array('moodle/category:manage'));
    }

    /**
     * Returns form context
     *
     * If context depends on the form data, it is available in $this->_ajaxformdata or
     * by calling $this->optional_param()
     *
     * @return \context
     */
    protected function get_context_for_dynamic_submission(): \context {
        $categoryid = required_param('id', PARAM_INT);
        return \core\context\coursecat::instance($categoryid);
    }

    /**
     * File upload options
     *
     * @return array
     * @throws \coding_exception
     */
    public function get_options(): array {
        return ['subdirs' => 1, 'maxfiles' => -1, 'accepted_types' => '*',
            'areamaxbytes' => FILE_AREA_MAX_BYTES_UNLIMITED];
    }

    /**
     * Process the form submission, used if form was submitted via AJAX
     *
     * This method can return scalar values or arrays that can be json-encoded, they will be passed to the caller JS.
     *
     * Submission data can be accessed as: $this->get_data()
     *
     * @return mixed
     */
    public function process_dynamic_submission() {
        $categoryid = required_param('id', PARAM_INT);
        file_postupdate_standard_filemanager($this->get_data(), 'files',
            $this->get_options(), $this->get_context_for_dynamic_submission(), 'theme_boost_union', 'categoryimage', $categoryid);
        return null;
    }

    /**
     * Load in existing data as form defaults
     *
     * Can be overridden to retrieve existing values from db by entity id and also
     * to preprocess editor and filemanager elements
     *
     * Example:
     *     $this->set_data(get_entity($this->_ajaxformdata['id']));
     */
    public function set_data_for_dynamic_submission(): void {
        $categoryid = required_param('id', PARAM_INT);
        $data = new \stdClass();
        $data->id = $categoryid;
        file_prepare_standard_filemanager($data, 'files', $this->get_options(),
            $this->get_context_for_dynamic_submission(), 'theme_boost_union', 'categoryimage', $categoryid);
        $this->set_data($data);
    }

    /**
     * Returns url to set in $PAGE->set_url() when form is being rendered or submitted via AJAX
     *
     * This is used in the form elements sensitive to the page url, such as Atto autosave in 'editor'
     *
     * If the form has arguments (such as 'id' of the element being edited), the URL should
     * also have respective argument.
     *
     * @return \moodle_url
     */
    protected function get_page_url_for_dynamic_submission(): \moodle_url {
        return new moodle_url('/theme/boost_union/categoryimage.php');
    }
}
