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
 * Provides the restore activity task class
 *
 * @package   mod_scormadaptivequiz
 * @category  backup
 * @copyright 2015 Your Name <your@email.adress>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/scormadaptivequiz/backup/moodle2/restore_scormadaptivequiz_stepslib.php');

/**
 * Restore task for the scormadaptivequiz activity module
 *
 * Provides all the settings and steps to perform complete restore of the activity.
 *
 * @package   mod_scormadaptivequiz
 * @category  backup
 * @copyright 2015 Your Name <your@email.adress>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_scormadaptivequiz_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // We have just one structure step here.
        $this->add_step(new restore_scormadaptivequiz_activity_structure_step('scormadaptivequiz_structure', 'scormadaptivequiz.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('scormadaptivequiz', array('intro'), 'scormadaptivequiz');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('SCORMADAPTIVEQUIZVIEWBYID', '/mod/scormadaptivequiz/view.php?id=$1', 'course_module');
        $rules[] = new restore_decode_rule('SCORMADAPTIVEQUIZINDEX', '/mod/scormadaptivequiz/index.php?id=$1', 'course');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * scormadaptivequiz logs. It must return one array
     * of {@link restore_log_rule} objects
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('scormadaptivequiz', 'add', 'view.php?id={course_module}', '{scormadaptivequiz}');
        $rules[] = new restore_log_rule('scormadaptivequiz', 'update', 'view.php?id={course_module}', '{scormadaptivequiz}');
        $rules[] = new restore_log_rule('scormadaptivequiz', 'view', 'view.php?id={course_module}', '{scormadaptivequiz}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@link restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course() {
        $rules = array();

        $rules[] = new restore_log_rule('scormadaptivequiz', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}
