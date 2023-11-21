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
            'core:docs' => 'info',
            'core:book' => 'menu_book',
            'core:help' => 'help',
            'core:req' => 'error text-danger',
            'core:a/add_file' => 'insert_drive_file',
            'core:a/create_folder' => 'folder',
            'core:a/download_all' => 'get_app',
            'core:a/help' => 'help text-info',
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
            'core:e/absolute' => 'fa-crosshairs',
            'core:e/accessibility_checker' => 'accessibility',
            'core:e/acronym' => 'chat_bubble',
            'core:e/advance_hr' => 'swap_horiz',
            'core:e/align_center' => 'format_align_center',
            'core:e/align_left' => 'format_align_left',
            'core:e/align_right' => 'format_align_right',
            'core:e/anchor' => 'link',
            'core:e/backward' => 'undo',
            'core:e/bold' => 'bold',
            'core:e/bullet_list' => 'format_list_bulleted',
            'core:e/cancel' => 'close',
            'core:e/cancel_solid_circle' => 'cancel',
            'core:e/cell_props' => 'info',
            'core:e/cite' => 'quote_right',
            'core:e/cleanup_messy_code' => 'cleaning_services',
            'core:e/clear_formatting' => 'fa-i-cursor',
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
            'core:e/insert_file' => 'fa-file',
            'core:e/insert_horizontal_ruler' => 'swap_horiz',
            'core:e/insert_nonbreaking_space' => 'check_box_outline_blank',
            'core:e/insert_page_break' => 'fa-level-down',
            'core:e/insert_row_after' => 'add',
            'core:e/insert_row_before' => 'add',
            'core:e/insert' => 'add',
            'core:e/insert_time' => 'fa-clock-o',
            'core:e/italic' => 'fa-italic',
            'core:e/justify' => 'fa-align-justify',
            'core:e/layers_over' => 'fa-level-up',
            'core:e/layers' => 'fa-window-restore',
            'core:e/layers_under' => 'fa-level-down',
            'core:e/left_to_right' => 'chevron_right',
            'core:e/manage_files' => 'content_copy',
            'core:e/math' => 'calculate',
            'core:e/merge_cells' => 'fa-compress',
            'core:e/new_document' => 'fa-file-o',
            'core:e/numbered_list' => 'fa-list-ol',
            'core:e/page_break' => 'fa-level-down',
            'core:e/paste' => 'fa-clipboard',
            'core:e/paste_text' => 'fa-clipboard',
            'core:e/paste_word' => 'fa-clipboard',
            'core:e/prevent_autolink' => 'fa-exclamation',
            'core:e/preview' => 'fa-search-plus',
            'core:e/print' => 'fa-print',
            'core:e/question' => 'fa-question',
            'core:e/redo' => 'fa-repeat',
            'core:e/remove_link' => 'fa-chain-broken',
            'core:e/remove_page_break' => 'fa-remove',
            'core:e/resize' => 'fa-expand',
            'core:e/restore_draft' => 'fa-undo',
            'core:e/restore_last_draft' => 'fa-undo',
            'core:e/right_to_left' => 'chevron_left',
            'core:e/row_props' => 'info',
            'core:e/save' => 'fa-floppy-o',
            'core:e/screenreader_helper' => 'fa-braille',
            'core:e/search' => 'fa-search',
            'core:e/select_all' => 'swap_horiz',
            'core:e/show_invisible_characters' => 'visibility_off',
            'core:e/source_code' => 'fa-code',
            'core:e/special_character' => 'edit-square-o',
            'core:e/spellcheck' => 'fa-check',
            'core:e/split_cells' => 'vertical_split',
            'core:e/strikethrough' => 'fa-strikethrough',
            'core:e/styleparagraph' => 'fa-font',
            'core:e/subscript' => 'fa-subscript',
            'core:e/superscript' => 'fa-superscript',
            'core:e/table_props' => 'fa-table',
            'core:e/table' => 'fa-table',
            'core:e/template' => 'fa-sticky-note',
            'core:e/text_color_picker' => 'fa-paint-brush',
            'core:e/text_color' => 'fa-paint-brush',
            'core:e/text_highlight_picker' => 'fa-lightbulb-o',
            'core:e/text_highlight' => 'fa-lightbulb-o',
            'core:e/tick' => 'fa-check',
            'core:e/toggle_blockquote' => 'fa-quote-left',
            'core:e/underline' => 'fa-underline',
            'core:e/undo' => 'fa-undo',
            'core:e/visual_aid' => 'fa-universal-access',
            'core:e/visual_blocks' => 'fa-audio-description',
            'theme:fp/add_file' => 'fa-file-o',
            'theme:fp/alias' => 'fa-share',
            'theme:fp/alias_sm' => 'fa-share',
            'theme:fp/check' => 'fa-check',
            'theme:fp/create_folder' => 'fa-folder-o',
            'theme:fp/cross' => 'fa-remove',
            'theme:fp/download_all' => 'download',
            'theme:fp/help' => 'help',
            'theme:fp/link' => 'link',
            'theme:fp/link_sm' => 'link',
            'theme:fp/logout' => 'fa-sign-out',
            'theme:fp/path_folder' => 'fa-folder',
            'theme:fp/path_folder_rtl' => 'fa-folder',
            'theme:fp/refresh' => 'fa-refresh',
            'theme:fp/search' => 'fa-search',
            'theme:fp/setting' => 'settings',
            'theme:fp/view_icon_active' => 'fa-th',
            'theme:fp/view_list_active' => 'fa-list',
            'theme:fp/view_tree_active' => 'fa-folder',
            'core:i/activities' => 'fa-file-pen',
            'core:i/addblock' => 'fa-plus-square',
            'core:i/assignroles' => 'person_add',
            'core:i/asterisk' => 'fa-asterisk',
            'core:i/backup' => 'fa-file-zip-o',
            'core:i/badge' => 'fa-shield',
            'core:i/breadcrumbdivider' => 'fa-angle-right',
            'core:i/bullhorn' => 'fa-bullhorn',
            'core:i/calc' => 'calculate',
            'core:i/calendar' => 'calendar_month',
            'core:i/calendareventdescription' => 'fa-align-left',
            'core:i/calendareventtime' => 'fa-clock-o',
            'core:i/caution' => 'fa-exclamation text-warning',
            'core:i/checked' => 'fa-check',
            'core:i/checkedcircle' => 'fa-check-circle',
            'core:i/checkpermissions' => 'lock_open',
            'core:i/cohort' => 'groups',
            'core:i/competencies' => 'fa-check-square-o',
            'core:i/completion_self' => 'person',
            'core:i/contentbank' => 'brush',
            'core:i/dashboard' => 'fa-tachometer',
            'core:i/categoryevent' => 'fa-cubes',
            'core:i/course' => 'fa-graduation-cap',
            'core:i/courseevent' => 'fa-graduation-cap',
            'core:i/customfield' => 'fa-hand-o-right',
            'core:i/db' => 'fa-database',
            'core:i/delete' => 'delete',
            'core:i/down' => 'arrow_downward',
            'core:i/dragdrop' => 'open_with',
            'core:i/duration' => 'fa-clock-o',
            'core:i/emojicategoryactivities' => 'fa-futbol-o',
            'core:i/emojicategoryanimalsnature' => 'fa-leaf',
            'core:i/emojicategoryflags' => 'fa-flag',
            'core:i/emojicategoryfooddrink' => 'fa-cutlery',
            'core:i/emojicategoryobjects' => 'fa-lightbulb-o',
            'core:i/emojicategorypeoplebody' => 'fa-male',
            'core:i/emojicategoryrecent' => 'fa-clock-o',
            'core:i/emojicategorysmileysemotion' => 'emoji_emotions',
            'core:i/emojicategorysymbols' => 'fa-heart',
            'core:i/emojicategorytravelplaces' => 'fa-plane',
            'core:i/edit' => 'edit',
            'core:i/email' => 'fa-envelope',
            'core:i/empty' => 'fa-fw',
            'core:i/enrolmentsuspended' => 'fa-pause',
            'core:i/enrolusers' => 'person_add',
            'core:i/excluded' => 'fa-minus-circle',
            'core:i/expired' => 'fa-exclamation text-warning',
            'core:i/export' => 'download',
            'core:i/link' => 'link',
            'core:i/externallink' => 'fa-external-link',
            'core:i/files' => 'fa-file',
            'core:i/filter' => 'fa-filter',
            'core:i/flagged' => 'fa-flag',
            'core:i/folder' => 'fa-folder',
            'core:i/grade_correct' => 'fa-check text-success',
            'core:i/grade_incorrect' => 'fa-remove text-danger',
            'core:i/grade_partiallycorrect' => 'fa-check-square',
            'core:i/grades' => 'fa-table',
            'core:i/grading' => 'fa-magic',
            'core:i/gradingnotifications' => 'notifications',
            'core:i/groupevent' => 'groups',
            'core:i/group' => 'groups',
            'core:i/home' => 'fa-home',
            'core:i/hide' => 'visibility',
            'core:i/hierarchylock' => 'lock',
            'core:i/import' => 'fa-level-up',
            'core:i/incorrect' => 'fa-exclamation',
            'core:i/info' => 'info',
            'core:i/invalid' => 'close text-danger',
            'core:i/item' => 'circle',
            'core:i/loading' => 'hourglass_empty',
            'core:i/loading_small' => 'hourglass_empty',
            'core:i/location' => 'location_on',
            'core:i/lock' => 'lock',
            'core:i/log' => 'list-alt',
            'core:i/mahara_host' => 'badge',
            'core:i/manual_item' => 'edit-square-o',
            'core:i/marked' => 'radio_button_checked',
            'core:i/marker' => 'radio_button_unchecked',
            'core:i/mean' => 'calculate',
            'core:i/menu' => 'more_vert',
            'core:i/menubars' => 'menu',
            'core:i/messagecontentaudio' => 'headphones',
            'core:i/messagecontentimage' => 'image',
            'core:i/messagecontentvideo' => 'theaters',
            'core:i/messagecontentmultimediageneral' => 'videocam',
            'core:i/mnethost' => 'fa-external-link',
            'core:i/moodle_host' => 'fa-graduation-cap',
            'core:i/moremenu' => 'more_horiz',
            'core:i/move_2d' => 'open_with',
            'core:i/muted' => 'fa-microphone-slash',
            'core:i/navigationitem' => 'fa-fw',
            'core:i/ne_red_mark' => 'fa-remove',
            'core:i/new' => 'fa-bolt',
            'core:i/news' => 'fa-newspaper-o',
            'core:i/next' => 'chevron_right',
            'core:i/nosubcat' => 'fa-plus-square-o',
            'core:i/notifications' => 'notifications',
            'core:i/open' => 'folder_open',
            'core:i/otherevent' => 'calendar_month',
            'core:i/outcomes' => 'fa-tasks',
            'core:i/overriden_grade' => 'fa-edit',
            'core:i/payment' => 'fa-money',
            'core:i/permissionlock' => 'lock',
            'core:i/permissions' => 'edit-square-o',
            'core:i/persona_sign_in_black' => 'fa-male',
            'core:i/portfolio' => 'fa-id-badge',
            'core:i/preview' => 'fa-search-plus',
            'core:i/previous' => 'chevron_left',
            'core:i/privatefiles' => 'fa-file-o',
            'core:i/progressbar' => 'fa-spinner fa-spin',
            'core:i/publish' => 'fa-share',
            'core:i/questions' => 'fa-question',
            'core:i/reload' => 'fa-refresh',
            'core:i/report' => 'fa-area-chart',
            'core:i/repository' => 'fa-hdd-o',
            'core:i/restore' => 'fa-level-up',
            'core:i/return' => 'west',
            'core:i/risk_config' => 'fa-exclamation text-muted',
            'core:i/risk_managetrust' => 'fa-exclamation-triangle text-warning',
            'core:i/risk_personal' => 'fa-exclamation-circle text-info',
            'core:i/risk_spam' => 'fa-exclamation text-primary',
            'core:i/risk_xss' => 'fa-exclamation-triangle text-danger',
            'core:i/role' => 'fa-user-md',
            'core:i/rss' => 'fa-rss',
            'core:i/rsssitelogo' => 'fa-graduation-cap',
            'core:i/scales' => 'fa-balance-scale',
            'core:i/scheduled' => 'event_available',
            'core:i/search' => 'fa-search',
            'core:i/section' => 'fa-folder-o',
            'core:i/sendmessage' => 'fa-paper-plane',
            'core:i/settings' => 'settings',
            'core:i/share' => 'fa-share-square-o',
            'core:i/show' => 'visibility_off',
            'core:i/siteevent' => 'fa-globe',
            'core:i/star' => 'fa-star',
            'core:i/star-o' => 'fa-star-o',
            'core:i/star-rating' => 'fa-star',
            'core:i/stats' => 'fa-line-chart',
            'core:i/switch' => 'fa-exchange',
            'core:i/switchrole' => 'fa-user-secret',
            'core:i/trash' => 'delete',
            'core:i/twoway' => 'swap_horiz',
            'core:i/unchecked' => 'check_box_outline_blank',
            'core:i/uncheckedcircle' => 'radio_button_unchecked',
            'core:i/unflagged' => 'fa-flag-o',
            'core:i/unlock' => 'lock_open',
            'core:i/up' => 'arrow_upward',
            'core:i/upload' => 'fa-upload',
            'core:i/userevent' => 'person',
            'core:i/user' => 'person',
            'core:i/users' => 'groups',
            'core:i/valid' => 'fa-check text-success',
            'core:i/warning' => 'fa-exclamation text-warning',
            'core:i/window_close' => 'fa-window-close',
            'core:i/withsubcat' => 'fa-plus-square',
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
            'core:t/award' => 'fa-trophy',
            'core:t/backpack' => 'fa-shopping-bag',
            'core:t/backup' => 'arrow_circle_down',
            'core:t/block' => 'block',
            'core:t/block_to_dock_rtl' => 'chevron_right',
            'core:t/block_to_dock' => 'chevron_left',
            'core:t/blocks_drawer' => 'chevron_left',
            'core:t/blocks_drawer_rtl' => 'chevron_right',
            'core:t/calc_off' => 'calculate', // TODO: Change to better icon once we have stacked icon support or more icons.
            'core:t/calc' => 'calculate',
            'core:t/check' => 'fa-check',
            'core:t/clipboard' => 'fa-clipboard',
            'core:t/cohort' => 'groups',
            'core:t/collapsed_empty_rtl' => 'fa-caret-square-o-left',
            'core:t/collapsed_empty' => 'fa-caret-square-o-right',
            'core:t/collapsed_rtl' => 'fa-caret-left',
            'core:t/collapsed' => 'fa-caret-right',
            'core:t/collapsedcaret' => 'fa-caret-right',
            'core:t/collapsedchevron' => 'chevron_right',
            'core:t/collapsedchevron_rtl' => 'chevron_left',
            'core:t/collapsedchevron_up' => 'fa-chevron-up',
            'core:t/completion_complete' => 'done',
            'core:t/completion_fail' => 'close',
            'core:t/completion_incomplete' => 'radio_button_unchecked',
            'core:t/contextmenu' => 'settings',
            'core:t/copy' => 'content_copy',
            'core:t/delete' => 'delete',
            'core:t/dockclose' => 'fa-window-close',
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
            'core:t/emailno' => 'fa-ban',
            'core:t/email' => 'fa-envelope-o',
            'core:t/emptystar' => 'fa-star-o',
            'core:t/enrolusers' => 'person_add',
            'core:t/expanded' => 'fa-caret-down',
            'core:t/expandedchevron' => 'fa-chevron-down',
            'core:t/go' => 'fa-play',
            'core:t/grades' => 'fa-table',
            'core:t/groupn' => 'person',
            'core:t/groups' => 'account_circle',
            'core:t/groupv' => 'account_circle',
            'core:t/hide' => 'visibility',
            'core:t/index_drawer' => 'fa-list',
            'core:t/left' => 'west',
            'core:t/less' => 'fa-caret-up',
            'core:t/life-ring' => 'fa-life-ring',
            'core:t/locked' => 'lock',
            'core:t/lock' => 'lock_open',
            'core:t/locktime' => 'lock',
            'core:t/markasread' => 'fa-check',
            'core:t/messages' => 'forum',
            'core:t/messages-o' => 'forum',
            'core:t/message' => 'chat-bubble',
            'core:t/more' => 'fa-caret-down',
            'core:t/move' => 'swap_vert',
            'core:t/online' => 'fa-circle',
            'core:t/passwordunmask-edit' => 'edit',
            'core:t/passwordunmask-reveal' => 'visibility',
            'core:t/play' => 'fa-play',
            'core:t/portfolioadd' => 'add',
            'core:t/preferences' => 'fa-wrench',
            'core:t/preview' => 'fa-search-plus',
            'core:t/print' => 'fa-print',
            'core:t/removecontact' => 'fa-user-times',
            'core:t/reload' => 'fa-refresh',
            'core:t/reset' => 'fa-repeat',
            'core:t/restore' => 'arrow_circle_up',
            'core:t/right' => 'east',
            'core:t/sendmessage' => 'fa-paper-plane',
            'core:t/show' => 'visibility_off',
            'core:t/sort_by' => 'fa-sort-amount-asc',
            'core:t/sort_asc' => 'fa-sort-asc',
            'core:t/sort_desc' => 'fa-sort-desc',
            'core:t/sort' => 'fa-sort',
            'core:t/stealth' => 'fa-low-vision',
            'core:t/stop' => 'fa-stop',
            'core:t/switch_minus' => 'remove',
            'core:t/switch_plus' => 'add',
            'core:t/switch_whole' => 'check_box_outline_blank',
            'core:t/tags' => 'fa-tags',
            'core:t/unblock' => 'textsms',
            'core:t/unlocked' => 'lock_open',
            'core:t/unlock' => 'lock',
            'core:t/up' => 'arrow_upward',
            'core:t/uplong' => 'arrow_upward',
            'core:t/user' => 'person',
            'core:t/viewdetails' => 'fa-list',
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
        $isquestionicon = strpos($data['key'], 'fa-question') !== false;
        if ($isquestionicon && right_to_left() && get_string('questioniconfollowlangdirection', 'langconfig') === 'yes') {
            $data['extraclasses'] = "fa-flip-horizontal";
        }

        return $output->render_from_template('theme_boost_union/pix_icon_materialicons', $data);
    }

}
