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

namespace theme_boost_union\output;

use renderer_base;
use pix_icon;

defined('MOODLE_INTERNAL') || die();

/**
 * Class allowing different systems for mapping and rendering icons.
 *
 * Possible icon styles are:
 *   1. standard - image tags are generated which point to pix icons stored in a plugin pix folder.
 *   2. materialicons - material icons is generated with the name of the icon mapped from the moodle icon name.
 *   3. inline - inline tags are used for svg and png so no separate page requests are made (at the expense of page size).
 *
 * Icon mapping for Google Material Icons
 * https://fonts.google.com/icons?icon.style=Two+tone&icon.set=Material+Icons
 *
 * @package    theme_boost_union
 * @copyright  2023 Daniel Neis Araujo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class icon_system_materialicons extends \core\output\icon_system_font {

    /**
     * @var array $map Cached map of moodle icon names to font awesome icon names.
     */
    private $map = [];

    public function get_core_icon_map() {
        return [
            'atto_collapse:icon' => 'expand_more',
            'atto_recordrtc:i/audiortc' => 'mic',
            'atto_recordrtc:i/videortc' => 'videocam',
            'core:docs' => 'info',
            'core:book' => 'menu_book',
            'core:help' => 'help',
            'core:req' => 'error',
            'core:a/add_file' => 'insert_drive_file',
            'core:a/create_folder' => 'folder',
            'core:a/download_all' => 'get_app',
            'core:a/help' => 'help',
            'core:a/logout' => 'logout',
            'core:a/refresh' => 'refresh',
            'core:a/search' => 'search',
            'core:a/setting' => 'settings',
            'core:a/view_icon_active' => 'apps',
            'core:a/view_list_active' => 'list',
            'core:a/view_tree_active' => 'folder',
            'core:b/bookmark-new' => 'bookmark',
            'core:b/document-edit' => 'edit',
            'core:b/document-new' => 'note-add',
            'core:b/document-properties' => 'info',
            'core:b/edit-copy' => 'content_copy',
            'core:b/edit-delete' => 'delete',
            'core:e/abbr' => 'chat_bubble',
            'core:e/absolute' => 'crop_free',
            'core:e/accessibility_checker' => 'accessibility',
            'core:e/acronym' => 'chat_bubble',
            'core:e/advance_hr' => 'swap_horiz',
            'core:e/align_center' => 'format_align_center',
            'core:e/align_left' => 'format_align_left',
            'core:e/align_right' => 'format_align_right',
            'core:e/anchor' => 'link',
            'core:e/backward' => 'undo',
            'core:e/bold' => 'format_bold',
            'core:e/bullet_list' => 'format_list_bulleted',
            'core:e/cancel' => 'close',
            'core:e/cancel_solid_circle' => 'cancel',
            'core:e/cell_props' => 'info',
            'core:e/cite' => 'quote_right',
            'core:e/cleanup_messy_code' => 'cleaning_services',
            'core:e/clear_formatting' => 'format_clear',
            'core:e/copy' => 'content_copy',
            'core:e/cut' => 'content_cut',
            'core:e/decrease_indent' => 'format_indent_decrease',
            'core:e/delete_col' => 'remove',
            'core:e/delete_row' => 'remove',
            'core:e/delete' => 'remove',
            'core:e/delete_table' => 'remove',
            'core:e/document_properties' => 'info',
            'core:e/emoticons' => 'emoji_emotions',
            'core:e/find_replace' => 'find_replace',
            'core:e/file-text' => 'description',
            'core:e/forward' => 'east',
            'core:e/fullpage' => 'zoom_out_map',
            'core:e/fullscreen' => 'zoom_out_map',
            'core:e/help' => 'help',
            'core:e/increase_indent' => 'format_indent_increase',
            'core:e/insert_col_after' => 'view_week',
            'core:e/insert_col_before' => 'view_week',
            'core:e/insert_date' => 'calendar_month',
            'core:e/insert_edit_image' => 'insert_photo',
            'core:e/insert_edit_link' => 'link',
            'core:e/insert_edit_video' => 'videocam',
            'core:e/insert_file' => 'insert_drive_file',
            'core:e/insert_horizontal_ruler' => 'swap_horiz',
            'core:e/insert_nonbreaking_space' => 'check_box_outline_blank',
            'core:e/insert_page_break' => 'insert_page_break',
            'core:e/insert_row_after' => 'add',
            'core:e/insert_row_before' => 'add',
            'core:e/insert' => 'add',
            'core:e/insert_time' => 'schedule',
            'core:e/italic' => 'format_italic',
            'core:e/justify' => 'format_align_justify',
            'core:e/layers_over' => 'arrow_upward',
            'core:e/layers' => 'layers',
            'core:e/layers_under' => 'arrow_downward',
            'core:e/left_to_right' => 'chevron_right',
            'core:e/manage_files' => 'content_copy',
            'core:e/math' => 'calculate',
            'core:e/merge_cells' => 'compress',
            'core:e/new_document' => 'insert_drive_file',
            'core:e/numbered_list' => 'format_list_numbered',
            'core:e/page_break' => 'arrow_downward',
            'core:e/paste' => 'content_paste',
            'core:e/paste_text' => 'content_paste',
            'core:e/paste_word' => 'content_paste',
            'core:e/prevent_autolink' => 'priority_high',
            'core:e/preview' => 'zoom-in',
            'core:e/print' => 'print',
            'core:e/question' => 'question_mark',
            'core:e/redo' => 'redo',
            'core:e/remove_link' => 'link_off',
            'core:e/remove_page_break' => 'close',
            'core:e/resize' => 'open_in_full',
            'core:e/restore_draft' => 'undo',
            'core:e/restore_last_draft' => 'undo',
            'core:e/right_to_left' => 'chevron_left',
            'core:e/row_props' => 'info',
            'core:e/save' => 'save',
            'core:e/screenreader_helper' => 'blind',
            'core:e/search' => 'search',
            'core:e/select_all' => 'swap_horiz',
            'core:e/show_invisible_characters' => 'visibility_off',
            'core:e/source_code' => 'code',
            'core:e/special_character' => 'edit',
            'core:e/spellcheck' => 'done',
            'core:e/split_cells' => 'vertical_split',
            'core:e/strikethrough' => 'strikethrough_s',
            'core:e/styleparagraph' => 'format_size',
            'core:e/subscript' => 'subscript',
            'core:e/superscript' => 'superscript',
            'core:e/table_props' => 'table_chart',
            'core:e/table' => 'table_chart',
            'core:e/template' => 'sticky_note_2',
            'core:e/text_color_picker' => 'brush',
            'core:e/text_color' => 'brush',
            'core:e/text_highlight_picker' => 'lightbulb',
            'core:e/text_highlight' => 'lightbulb',
            'core:e/tick' => 'done',
            'core:e/toggle_blockquote' => 'format_quote',
            'core:e/underline' => 'format_underlined',
            'core:e/undo' => 'undo',
            'core:e/visual_aid' => 'accessibility',
            'core:e/visual_blocks' => 'lyrics',
            'theme:fp/add_file' => 'insert_drive_file',
            'theme:fp/alias' => 'share',
            'theme:fp/alias_sm' => 'share',
            'theme:fp/check' => 'done',
            'theme:fp/create_folder' => 'create_new_folder',
            'theme:fp/cross' => 'close',
            'theme:fp/download_all' => 'download',
            'theme:fp/help' => 'help',
            'theme:fp/link' => 'link',
            'theme:fp/link_sm' => 'link',
            'theme:fp/logout' => 'logout',
            'theme:fp/path_folder' => 'folder',
            'theme:fp/path_folder_rtl' => 'folder',
            'theme:fp/refresh' => 'refresh',
            'theme:fp/search' => 'search',
            'theme:fp/setting' => 'settings',
            'theme:fp/view_icon_active' => 'apps',
            'theme:fp/view_list_active' => 'list',
            'theme:fp/view_tree_active' => 'folder',
            'core:i/activities' => 'edit',
            'core:i/addblock' => 'add_box',
            'core:i/assignroles' => 'person_add',
            'core:i/asterisk' => 'emergency',
            'core:i/backup' => 'folder_zip',
            'core:i/badge' => 'shield',
            'core:i/breadcrumbdivider' => 'chevron_right',
            'core:i/bullhorn' => 'campaign',
            'core:i/calc' => 'calculate',
            'core:i/calendar' => 'calendar_month',
            'core:i/calendareventdescription' => 'format_align_left',
            'core:i/calendareventtime' => 'schedule',
            'core:i/caution' => 'priority_high',
            'core:i/checked' => 'done',
            'core:i/checkedcircle' => 'done-circle',
            'core:i/checkpermissions' => 'lock_open',
            'core:i/cohort' => 'groups',
            'core:i/competencies' => 'done-square-o',
            'core:i/completion_self' => 'person',
            'core:i/contentbank' => 'brush',
            'core:i/dashboard' => 'dashboard',
            'core:i/categoryevent' => 'workspaces',
            'core:i/course' => 'school',
            'core:i/courseevent' => 'school',
            'core:i/customfield' => 'arrow_forward',
            'core:i/db' => 'storage',
            'core:i/delete' => 'delete',
            'core:i/down' => 'arrow_downward',
            'core:i/dragdrop' => 'open_with',
            'core:i/duration' => 'schedule',
            'core:i/emojicategoryactivities' => 'sports_basketball',
            'core:i/emojicategoryanimalsnature' => 'emoji_nature',
            'core:i/emojicategoryflags' => 'flag',
            'core:i/emojicategoryfooddrink' => 'emoji_food_beverage',
            'core:i/emojicategoryobjects' => 'emoji_objects',
            'core:i/emojicategorypeoplebody' => 'man',
            'core:i/emojicategoryrecent' => 'schedule',
            'core:i/emojicategorysmileysemotion' => 'emoji_emotions',
            'core:i/emojicategorysymbols' => 'emoji_symbols',
            'core:i/emojicategorytravelplaces' => 'emoji_transportation',
            'core:i/edit' => 'edit',
            'core:i/email' => 'email',
            'core:i/empty' => 'check_box_outline_blank',
            'core:i/enrolmentsuspended' => 'pause',
            'core:i/enrolusers' => 'person_add',
            'core:i/excluded' => 'do_not_disturb_on',
            'core:i/expired' => 'priority_high',
            'core:i/export' => 'download',
            'core:i/link' => 'link',
            'core:i/externallink' => 'output',
            'core:i/files' => 'insert_drive_file',
            'core:i/filter' => 'filter_alt',
            'core:i/flagged' => 'flag',
            'core:i/folder' => 'folder',
            'core:i/grade_correct' => 'done',
            'core:i/grade_incorrect' => 'close',
            'core:i/grade_partiallycorrect' => 'done-square',
            'core:i/grades' => 'table_chart',
            'core:i/grading' => 'auto_fix_high',
            'core:i/gradingnotifications' => 'notifications',
            'core:i/groupevent' => 'groups',
            'core:i/group' => 'groups',
            'core:i/home' => 'home',
            'core:i/hide' => 'visibility',
            'core:i/hierarchylock' => 'lock',
            'core:i/import' => 'arrow_upward',
            'core:i/incorrect' => 'priority_high',
            'core:i/info' => 'info',
            'core:i/invalid' => 'close',
            'core:i/item' => 'circle',
            'core:i/loading' => 'hourglass_empty',
            'core:i/loading_small' => 'hourglass_empty',
            'core:i/location' => 'location_on',
            'core:i/lock' => 'lock',
            'core:i/log' => 'list-alt',
            'core:i/mahara_host' => 'badge',
            'core:i/manual_item' => 'edit',
            'core:i/marked' => 'radio_button_checked',
            'core:i/marker' => 'radio_button_unchecked',
            'core:i/mean' => 'calculate',
            'core:i/menu' => 'more_vert',
            'core:i/menubars' => 'menu',
            'core:i/messagecontentaudio' => 'headphones',
            'core:i/messagecontentimage' => 'image',
            'core:i/messagecontentvideo' => 'theaters',
            'core:i/messagecontentmultimediageneral' => 'videocam',
            'core:i/mnethost' => 'output',
            'core:i/moodle_host' => 'school',
            'core:i/moremenu' => 'more_horiz',
            'core:i/move_2d' => 'open_with',
            'core:i/muted' => 'mic_off',
            'core:i/navigationitem' => 'empty',
            'core:i/ne_red_mark' => 'close',
            'core:i/new' => 'bolt',
            'core:i/news' => 'newspaper',
            'core:i/next' => 'chevron_right',
            'core:i/nosubcat' => 'add_box',
            'core:i/notifications' => 'notifications',
            'core:i/open' => 'folder_open',
            'core:i/otherevent' => 'calendar_month',
            'core:i/outcomes' => 'article',
            'core:i/overriden_grade' => 'edit',
            'core:i/payment' => 'attach_money',
            'core:i/permissionlock' => 'lock',
            'core:i/permissions' => 'edit',
            'core:i/persona_sign_in_black' => 'man',
            'core:i/portfolio' => 'badge',
            'core:i/preview' => 'zoom_in',
            'core:i/previous' => 'chevron_left',
            'core:i/privatefiles' => 'insert_drive_file',
            'core:i/progressbar' => 'hourglass_top',
            'core:i/publish' => 'share',
            'core:i/questions' => 'question_mark',
            'core:i/reload' => 'refresh',
            'core:i/report' => 'area_chart',
            'core:i/repository' => 'storage',
            'core:i/restore' => 'arrow_upward',
            'core:i/return' => 'west',
            'core:i/risk_config' => 'priority_high',
            'core:i/risk_managetrust' => 'warning',
            'core:i/risk_personal' => 'error',
            'core:i/risk_spam' => 'priority_high',
            'core:i/risk_xss' => 'warning',
            'core:i/role' => 'engineering',
            'core:i/rss' => 'rss_feed',
            'core:i/rsssitelogo' => 'school',
            'core:i/scales' => 'balance',
            'core:i/scheduled' => 'event_available',
            'core:i/search' => 'search',
            'core:i/section' => 'folder',
            'core:i/sendmessage' => 'send',
            'core:i/settings' => 'settings',
            'core:i/share' => 'share',
            'core:i/show' => 'visibility_off',
            'core:i/siteevent' => 'public',
            'core:i/star' => 'star',
            'core:i/star-o' => 'star_border',
            'core:i/star-rating' => 'star',
            'core:i/stats' => 'show_chart',
            'core:i/switch' => 'swap_horiz',
            'core:i/switchrole' => 'supervised_user_circle',
            'core:i/trash' => 'delete',
            'core:i/twoway' => 'swap_horiz',
            'core:i/unchecked' => 'check_box_outline_blank',
            'core:i/uncheckedcircle' => 'radio_button_unchecked',
            'core:i/unflagged' => 'flag',
            'core:i/unlock' => 'lock_open',
            'core:i/up' => 'arrow_upward',
            'core:i/upload' => 'upload',
            'core:i/userevent' => 'person',
            'core:i/user' => 'person',
            'core:i/users' => 'groups',
            'core:i/valid' => 'done',
            'core:i/warning' => 'priority_high',
            'core:i/window_close' => 'cancel_presentation',
            'core:i/withsubcat' => 'add_box',
            'core:i/language' => 'language',
            'core:m/USD' => 'attach_money',
            'core:t/addcontact' => 'contact_mail',
            'core:t/add' => 'add',
            'core:t/angles-down' => 'keyboard_arrow_down',
            'core:t/angles-left' => 'keyboard_arrow_left',
            'core:t/angles-right' => 'keyboard_arrow_right',
            'core:t/angles-up' => 'keyboard_arrow_up',
            'core:t/approve' => 'thumbs_up',
            'core:t/assignroles' => 'account_circle',
            'core:t/award' => 'emoji_events',
            'core:t/backpack' => 'shopping_bag',
            'core:t/backup' => 'arrow_circle_down',
            'core:t/block' => 'block',
            'core:t/block_to_dock_rtl' => 'chevron_right',
            'core:t/block_to_dock' => 'chevron_left',
            'core:t/blocks_drawer' => 'chevron_left',
            'core:t/blocks_drawer_rtl' => 'chevron_right',
            'core:t/calc_off' => 'calculate', // TODO: Change to better icon once we have stacked icon support or more icons.
            'core:t/calc' => 'calculate',
            'core:t/check' => 'done',
            'core:t/clipboard' => 'content_paste',
            'core:t/cohort' => 'groups',
            'core:t/collapsed_empty_rtl' => 'chevron_left',
            'core:t/collapsed_empty' => 'chevron_right',
            'core:t/collapsed_rtl' => 'arrow_left',
            'core:t/collapsed' => 'arrow_right',
            'core:t/collapsedcaret' => 'arrow_right',
            'core:t/collapsedchevron' => 'chevron_right',
            'core:t/collapsedchevron_rtl' => 'chevron_left',
            'core:t/collapsedchevron_up' => 'expand-less',
            'core:t/completion_complete' => 'done',
            'core:t/completion_fail' => 'close',
            'core:t/completion_incomplete' => 'radio_button_unchecked',
            'core:t/contextmenu' => 'settings',
            'core:t/copy' => 'content_copy',
            'core:t/delete' => 'delete',
            'core:t/dockclose' => 'cancel_presentation',
            'core:t/dock_to_block_rtl' => 'chevron_right',
            'core:t/dock_to_block' => 'chevron_left',
            'core:t/download' => 'download',
            'core:t/down' => 'arrow_downward',
            'core:t/downlong' => 'arrow_downward',
            'core:t/dropdown' => 'settings',
            'core:t/editinline' => 'edit',
            'core:t/edit_menu' => 'settings',
            'core:t/editstring' => 'edit',
            'core:t/edit' => 'settings',
            'core:t/emailno' => 'block',
            'core:t/email' => 'email',
            'core:t/emptystar' => 'star_border',
            'core:t/enrolusers' => 'person_add',
            'core:t/expanded' => 'arrow_drop_down',
            'core:t/expandedchevron' => 'expand_more',
            'core:t/go' => 'play_arrow',
            'core:t/grades' => 'table_chart',
            'core:t/groupn' => 'person',
            'core:t/groups' => 'account_circle',
            'core:t/groupv' => 'account_circle',
            'core:t/hide' => 'visibility',
            'core:t/index_drawer' => 'list',
            'core:t/left' => 'west',
            'core:t/less' => 'chevron_up',
            'core:t/life-ring' => 'support',
            'core:t/locked' => 'lock',
            'core:t/lock' => 'lock_open',
            'core:t/locktime' => 'lock',
            'core:t/markasread' => 'done',
            'core:t/messages' => 'forum',
            'core:t/messages-o' => 'forum',
            'core:t/message' => 'chat_bubble',
            'core:t/more' => 'arrow_drop_down',
            'core:t/move' => 'swap_vert',
            'core:t/online' => 'circle',
            'core:t/passwordunmask-edit' => 'edit',
            'core:t/passwordunmask-reveal' => 'visibility',
            'core:t/play' => 'play_arrow',
            'core:t/portfolioadd' => 'add',
            'core:t/preferences' => 'build',
            'core:t/preview' => 'zoom-in',
            'core:t/print' => 'print',
            'core:t/removecontact' => 'person_remove',
            'core:t/reload' => 'autorenew',
            'core:t/reset' => 'refresh',
            'core:t/restore' => 'arrow_circle_up',
            'core:t/right' => 'east',
            'core:t/sendmessage' => 'send',
            'core:t/show' => 'visibility_off',
            'core:t/sort_by' => 'sort',
            'core:t/sort_asc' => 'arrow_drop_up',
            'core:t/sort_desc' => 'arrow_drop_down',
            'core:t/sort' => 'sort',
            'core:t/stealth' => 'visibility_off',
            'core:t/stop' => 'stop',
            'core:t/switch_minus' => 'remove',
            'core:t/switch_plus' => 'add',
            'core:t/switch_whole' => 'check_box_outline_blank',
            'core:t/tags' => 'more',
            'core:t/unblock' => 'textsms',
            'core:t/unlocked' => 'lock_open',
            'core:t/unlock' => 'lock',
            'core:t/up' => 'arrow_upward',
            'core:t/uplong' => 'arrow_upward',
            'core:t/user' => 'person',
            'core:t/viewdetails' => 'list',
        ];
    }

    /**
     * Overridable function to get a mapping of all icons.
     * Default is to do no mapping.
     */
    public function get_icon_name_map() {
        if ($this->map === []) {
            //$cache = \cache::make('core', 'materialiconsiconmapping');
            $cache = [];

            // Create different mapping keys for different icon system classes, there may be several different
            // themes on the same site.
            $mapkey = 'mapping_'.preg_replace('/[^a-zA-Z0-9_]/', '_', get_class($this));
            //$this->map = $cache->get($mapkey);

            //if (empty($this->map)) {
                $this->map = $this->get_core_icon_map();
                $callback = 'get_materialicons_icon_map';

                if ($pluginsfunction = get_plugins_with_function($callback)) {
                    foreach ($pluginsfunction as $plugintype => $plugins) {
                        foreach ($plugins as $pluginfunction) {
                            $pluginmap = $pluginfunction();
                            $this->map += $pluginmap;
                        }
                    }
                }
              //  $cache->set($mapkey, $this->map);
            //}

        }
        return $this->map;
    }


    public function get_amd_name() {
        return 'theme_boost_union/icon_system_materialicons';
    }

    public function render_pix_icon(renderer_base $output, pix_icon $icon) {
        $subpix = new \theme_boost_union\output\pix_icon_materialicons($icon);

        $data = $subpix->export_for_template($output);

        if (!$subpix->is_mapped()) {
            $data['unmappedIcon'] = $icon->export_for_template($output);
        }
        if (isset($icon->attributes['aria-hidden'])) {
            $data['aria-hidden'] = $icon->attributes['aria-hidden'];
        }

        // Flip question mark icon orientation when the `questioniconfollowlangdirection` lang config string is set to `yes`.
        $isquestionicon = strpos($data['key'], 'question_mark') !== false;
        if ($isquestionicon && right_to_left() && get_string('questioniconfollowlangdirection', 'langconfig') === 'yes') {
            $data['extraclasses'] = "fa-flip-horizontal";
        }

        return $output->render_from_template('theme_boost_union/pix_icon_materialicons', $data);
    }

}