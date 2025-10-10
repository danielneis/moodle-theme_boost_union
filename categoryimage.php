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
 * Manage category cover files.
 *
 * @package   theme_boost_union
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

require_login(null, false);

$categoryid = required_param('id', PARAM_INT);

$context = \core\context\coursecat::instance($categoryid);

if (!core_course_category::has_capability_on_any(array('moodle/category:manage'))) {
    // The user isn't able to manage any categories. Lets redirect them to the relevant course/index.php page.
    $url = new moodle_url('/course/index.php');
    if ($categoryid) {
        $url->param('id', $categoryid);
    }
    redirect($url);
}

$title = get_string('categoryimageupload', 'theme_boost_union');

$url = new moodle_url('/theme/boost_union/categoryimage.php', ['id' => $categoryid]);
$PAGE->set_url($url);
$PAGE->set_pagetype('course-index-category');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_primary_active_tab('home');


$form = new \theme_boost_union\form\categoryimage();

if ($data = $form->get_data()) {
    $form->process_dynamic_submission();
    redirect($url);
} else if ($form->is_cancelled()) {
    redirect(new moodle_url('/course/index.php', ['categoryid' => $categoryid]));
} else {
    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    $form->set_data_for_dynamic_submission();
    $form->display();
    echo $OUTPUT->footer();
}
