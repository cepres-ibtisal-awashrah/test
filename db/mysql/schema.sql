DROP TABLE IF EXISTS announcements;

CREATE TABLE announcements (
  id int(11) NOT NULL auto_increment,
  title varchar(250) NOT NULL,
  start_date int(11) NULL,
  end_date int(11) NULL,
  height int(11) NULL,
  width int(11) NULL,
  view varchar(250) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS attachments;

CREATE TABLE attachments (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  filename varchar(250) NOT NULL,
  size int(11) NOT NULL,
  created_on int(11) NOT NULL,
  project_id int(11) default NULL,
  case_id int(11) default NULL,
  test_change_id int(11) default NULL,
  user_id int(11) default NULL,
  PRIMARY KEY  (id),
  KEY ix_attachments_case_id (case_id),
  KEY ix_attachments_test_change_id (test_change_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS case_assocs;

CREATE TABLE case_assocs (
  id int(11) NOT NULL auto_increment,
  case_id int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_case_assocs_case_id (case_id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS case_changes;

CREATE TABLE case_changes (
  id int(11) NOT NULL auto_increment,
  case_id int(11) NOT NULL,
  type_id int(11) NOT NULL,
  created_on int(11) NOT NULL,
  user_id int(11) NOT NULL,
  changes longtext,
  PRIMARY KEY (id),
  KEY ix_case_changes_case_id (case_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE INDEX `ix_type_id` ON `case_changes` (`type_id`);

DROP TABLE IF EXISTS case_types;

CREATE TABLE case_types (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  is_default tinyint(1) NOT NULL,
  is_deleted tinyint(1) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS cases;

CREATE TABLE cases (
  id int(11) NOT NULL AUTO_INCREMENT,
  section_id int(11) NOT NULL,
  title varchar(250) NOT NULL,
  display_order int(11) NOT NULL,
  priority_id int(11) NOT NULL,
  estimate int(11) default NULL,
  milestone_id int(11) default NULL,
  custom_preconds longtext,
  custom_steps longtext,
  custom_expected longtext,
  custom_steps_separated longtext,
  custom_mission longtext,
  custom_goals longtext,
  custom_automation_type int(11) default 0,
  type_id int(11) NOT NULL,
  is_copy tinyint(1) NOT NULL,
  copyof_id int(11) default NULL,
  created_on int(11) NOT NULL,
  user_id int(11) NOT NULL,
  estimate_forecast int(11) default NULL,
  refs varchar(250) default NULL,
  suite_id int(11) NOT NULL,
  updated_on int(11) NOT NULL,
  updated_by int(11) NOT NULL,
  template_id int(11) NOT NULL,
  is_deleted tinyint(1) NOT NULL DEFAULT 0,
  status_id int(11) NOT NULL DEFAULT 1,
  assigned_to_id int(11) DEFAULT NULL,
  PRIMARY KEY  (id),
  KEY ix_cases_section_id (section_id),
  KEY ix_cases_suite_id (suite_id),
  KEY ix_cases_copyof_id (copyof_id),
  KEY status_id (status_id),
  KEY assigned_to_id (assigned_to_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS config_groups;

CREATE TABLE config_groups (
  id int(11) NOT NULL auto_increment,
  project_id int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY  (id),
  KEY ix_config_groups_project_id (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS configs;

CREATE TABLE configs (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  group_id int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ix_configs_group_id (group_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS defects;

CREATE TABLE defects (
  id int(11) NOT NULL auto_increment,
  defect_id varchar(250) NOT NULL,
  test_change_id int(11) NOT NULL,
  case_id int(11) NULL,
  project_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_defects_defect_id (defect_id),
  KEY ix_defects_test_change_id (test_change_id),
  KEY ix_defects_case_id (case_id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS exports;

CREATE TABLE exports (
  id int(11) NOT NULL auto_increment,
  filename varchar(250) NOT NULL,
  size bigint(20) NOT NULL,
  created_on int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ix_exports_created_on (created_on)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS fields;

CREATE TABLE fields (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  system_name varchar(250) NOT NULL,
  entity_id int(11) NOT NULL,
  label varchar(250) NOT NULL,
  description longtext,
  type_id int(11) NOT NULL,
  location_id int(11) NOT NULL,
  display_order int(11) NOT NULL,
  configs longtext NOT NULL,
  is_multi tinyint(1) NOT NULL,
  is_active tinyint(1) NOT NULL,
  status_id int(11) NOT NULL,
  is_system tinyint(1) NOT NULL,
  include_all tinyint(1) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_fields_name (entity_id,name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS field_templates;

CREATE TABLE field_templates (
  field_id int(11) NOT NULL,
  template_id int(11) NOT NULL,
  PRIMARY KEY  (field_id,template_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS group_users;

CREATE TABLE group_users (
  group_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  PRIMARY KEY  (group_id,user_id),
  KEY ix_group_users_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS jobs;

CREATE TABLE jobs (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  created_on int(11) NOT NULL,
  is_locked tinyint(1) NOT NULL,
  heartbeat int(11) NOT NULL,
  is_done tinyint(1) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE ux_jobs_name (name)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS message_recps;

CREATE TABLE message_recps (
  user_id int(11) NOT NULL,
  message_id int(11) NOT NULL,
  PRIMARY KEY  (message_id,user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS messages;

CREATE TABLE messages (
  id int(11) NOT NULL auto_increment,
  `subject` varchar(250) NOT NULL,
  body longtext NOT NULL,
  created_on int(11) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS milestones;

CREATE TABLE milestones (
  id int(11) NOT NULL auto_increment,
  project_id int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  due_on int(11) default NULL,
  completed_on int(11) default NULL,
  is_completed tinyint(1) NOT NULL,
  description longtext,
  start_on int(11) default NULL,
  started_on int(11) default NULL,
  is_started tinyint(1) NOT NULL,
  parent_id int(11) default NULL,
  PRIMARY KEY  (id),
  KEY ix_milestones_project_id (project_id),
  KEY ix_milestones_parent_id (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS preferences;

CREATE TABLE preferences (
  id int(11) NOT NULL auto_increment,
  user_id int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` longtext,
  PRIMARY KEY  (id),
  KEY ix_preferences_user_id (user_id),
  UNIQUE KEY ux_preferences_name (user_id,name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS priorities;

CREATE TABLE priorities (
  id int(11) NOT NULL auto_increment,
  priority int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  short_name varchar(250) NOT NULL,
  is_default tinyint(1) NOT NULL,
  is_deleted tinyint(1) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS project_access;

CREATE TABLE project_access (
  project_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  access int(11) NOT NULL,
  role_id int(11) default NULL,
  PRIMARY KEY  (project_id,user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS project_groups;

CREATE TABLE project_groups (
  project_id int(11) NOT NULL,
  group_id int(11) NOT NULL,
  access int(11) NOT NULL,
  role_id int(11) default NULL,
  PRIMARY KEY  (project_id,group_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS project_history;

CREATE TABLE project_history (
  id int(11) NOT NULL auto_increment,
  project_id int(11) NOT NULL,
  `action` int(11) NOT NULL,
  created_on int(11) NOT NULL,
  user_id int(11) NOT NULL,
  suite_id int(11) default NULL,
  milestone_id int(11) default NULL,
  run_id int(11) default NULL,
  `name` varchar(250) default NULL,
  is_deleted tinyint(1) NOT NULL,
  plan_id int(11) default NULL,
  PRIMARY KEY  (id),
  KEY ix_project_history_project_order (project_id,created_on)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS project_favs;

CREATE TABLE project_favs (
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  created_on int(11) NOT NULL,
  PRIMARY KEY (user_id, project_id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS projects;

CREATE TABLE projects (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  announcement longtext,
  show_announcement tinyint(1) NOT NULL,
  defect_id_url varchar(250) default NULL,
  defect_add_url varchar(250) default NULL,
  default_access int(11) NOT NULL,
  default_role_id int(11) default NULL,
  reference_id_url varchar(250) default NULL,
  reference_add_url varchar(250) default NULL,
  defect_plugin varchar(250) default NULL,
  defect_config longtext,
  is_completed tinyint(1) NOT NULL,
  completed_on int(11) default NULL,
  defect_template longtext,
  suite_mode int(11) NOT NULL,
  master_id int(11) NULL,
  reference_plugin varchar(250) default NULL,
  reference_config longtext,
  case_statuses_enabled tinyint(1) NOT NULL,
  is_test_case_approval_enabled tinyint(1) NOT NULL default 0,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS refs;

CREATE TABLE refs (
  id int(11) NOT NULL auto_increment,
  reference_id varchar(250) NOT NULL,
  case_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_refs_reference_id (reference_id),
  KEY ix_refs_case_id (case_id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS runs_refs;

CREATE TABLE runs_refs (
  id int(11) NOT NULL auto_increment,
  reference_id varchar(250) NOT NULL,
  run_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS reports;

CREATE TABLE reports (
  id int(11) NOT NULL auto_increment,
  plugin varchar(250) NOT NULL,
  project_id int(11) NOT NULL,
  name varchar(250) NOT NULL,
  description longtext,
  access int(11) NOT NULL,
  created_by int(11) NOT NULL,
  created_on int(11) NOT NULL,
  executed_on int(11) NULL,
  execution_time int(11) NULL,
  dir varchar(250) NULL,
  formats longtext NOT NULL,
  system_options longtext,
  custom_options longtext,
  status int(11) NOT NULL,
  status_message longtext,
  status_trace longtext,
  is_locked tinyint(1) NOT NULL,
  heartbeat int(11) NOT NULL,
  PRIMARY KEY  (id),
  KEY ix_reports_project_id (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS report_jobs;

CREATE TABLE report_jobs (
  id int(11) NOT NULL auto_increment,
  plugin varchar(250) NOT NULL,
  project_id int(11) NOT NULL,
  created_by int(11) NOT NULL,
  created_on int(11) NOT NULL,
  executed_on int(11) NULL,
  system_options longtext,
  custom_options longtext,
  PRIMARY KEY  (id),
  KEY ix_report_jobs_project_id (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  permissions int(11) NOT NULL,
  is_default int(11) NOT NULL,
  display_order int(11) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE roles ADD is_project_admin INT(11) NOT NULL default '0';

DROP TABLE IF EXISTS project_assignment;

CREATE TABLE IF NOT EXISTS project_assignment (
   user_id int(11) NOT NULL,
   project_id int(11) NOT NULL,
   PRIMARY KEY (user_id, project_id)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS runs;

CREATE TABLE runs (
  id int(11) NOT NULL auto_increment,
  suite_id int(11) default NULL,
  milestone_id int(11) default NULL,
  created_on int(11) NOT NULL,
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  is_completed tinyint(1) NOT NULL,
  completed_on int(11) default NULL,
  include_all tinyint(1) NOT NULL,
  `name` varchar(250) NOT NULL,
  description longtext,
  passed_count int(11) NOT NULL default '0',
  retest_count int(11) NOT NULL default '0',
  failed_count int(11) NOT NULL default '0',
  untested_count int(11) NOT NULL default '0',
  assignedto_id int(11) default NULL,
  is_plan tinyint(1) NOT NULL default '0',
  plan_id int(11) default NULL,
  entry_id varchar(250) default NULL,
  entries longtext,
  config varchar(250) default NULL,
  config_ids varchar(250) default NULL,
  entry_index int(11) default NULL,
  blocked_count int(11) NOT NULL default '0',
  is_editable tinyint(1) NOT NULL,
  content_id int(11) default NULL,
  custom_status1_count int(11) NOT NULL default '0',
  custom_status2_count int(11) NOT NULL default '0',
  custom_status3_count int(11) NOT NULL default '0',
  custom_status4_count int(11) NOT NULL default '0',
  custom_status5_count int(11) NOT NULL default '0',
  custom_status6_count int(11) NOT NULL default '0',
  custom_status7_count int(11) NOT NULL default '0',
  updated_by int(11) NOT NULL,
  updated_on int(11) NOT NULL,
  refs varchar (250) default NULL,
  PRIMARY KEY  (id),
  KEY ix_runs_project_id (project_id),
  KEY ix_runs_plan_id (plan_id),
  KEY ix_runs_milestone_id (milestone_id),
  KEY ix_runs_suite_id (suite_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS sections;

CREATE TABLE sections (
  id int(11) NOT NULL auto_increment,
  suite_id int(11) default NULL,
  `name` varchar(250) NOT NULL,
  display_order int(11) NOT NULL,
  is_copy tinyint(1) NOT NULL,
  copyof_id int(11) default NULL,
  parent_id int(11) default NULL,
  depth int(11) NOT NULL default '0',
  description longtext,
  PRIMARY KEY  (id),
  KEY ix_sections_suite_id (suite_id),
  KEY ix_sections_copyof_id (copyof_id),
  KEY ix_sections_parent_id (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS sessions;

CREATE TABLE sessions (
  session_id varchar(40) NOT NULL,
  ip_address varchar(16) NOT NULL,
  user_agent varchar(250) NOT NULL,
  last_activity int(10) NOT NULL,
  user_data longtext,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_sessions_session_id (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS settings;

DROP TABLE IF EXISTS shared_steps;

CREATE TABLE shared_steps (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_shared_steps_project_id (project_id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS shared_step_elements;

CREATE TABLE shared_step_elements (
  `id` int(11) NOT NULL auto_increment,
  `shared_step_id` int(11) NOT NULL,
  `display_order` int(11) NOT NULL,
  `content` longtext,
  `additional_info` longtext,
  `expected` longtext,
  `refs` varchar(250),
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_shared_step_elements_shared_step_id (shared_step_id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS cases_shared_steps;

CREATE TABLE cases_shared_steps (
  `id` int(11) NOT NULL auto_increment,
  `case_id` int(11) NOT NULL,
  `shared_step_id` int(11) NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_cases_shared_steps_case_id (case_id),
  KEY ix_cases_shared_steps_shared_step_id (shared_step_id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE settings (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  `value` longtext,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_settings_name (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS subscriptions;

CREATE TABLE subscriptions (
  id int(11) NOT NULL auto_increment,
  user_id int(11) NOT NULL,
  is_subscribed tinyint(1) NOT NULL,
  test_id int(11) NOT NULL,
  run_id int(11) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_subscriptions_run_test (run_id,test_id,user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS audit_log_exports;

CREATE TABLE audit_log_exports (
  id int(11) NOT NULL auto_increment,
  status int(11) NULL,
  created_on int(11) NOT NULL,
  filename varchar(250) NOT NULL,
  size bigint(20) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS audit_log_exports;

CREATE TABLE audit_log_exports (
  id int(11) NOT NULL auto_increment,
  status int(11) NULL,
  created_on int(11) NOT NULL,
  filename varchar(250) NOT NULL,
  size bigint(20) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS suites;

CREATE TABLE suites (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  project_id int(11) NOT NULL,
  description longtext,
  created_on int(11) NOT NULL,
  created_by int(11) NOT NULL,
  is_copy tinyint(1) NOT NULL,
  copyof_id int(11) default NULL,
  is_master tinyint(1) NOT NULL,
  is_baseline tinyint(1) NOT NULL,
  parent_id int(11) default NULL,
  is_completed tinyint(1) NOT NULL,
  completed_on int(11) NULL,
  PRIMARY KEY  (id),
  KEY ix_suites_project_id (project_id),
  KEY ix_suites_copyof_id (copyof_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS statuses;

CREATE TABLE statuses (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  system_name varchar(250) NOT NULL,
  label varchar(250) NOT NULL,
  color_dark int(11) NOT NULL,
  color_medium int(11) NOT NULL,
  color_bright int(11) NOT NULL,
  display_order int(11) NOT NULL,
  is_system tinyint(1) NOT NULL,
  is_active tinyint(1) NOT NULL,
  is_untested tinyint(1) NOT NULL,
  is_final tinyint(1) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_statuses_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS task;

CREATE TABLE task (
  id int(11) NOT NULL,
  is_locked tinyint(1) NOT NULL,
  heartbeat int(11) default NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS templates;

CREATE TABLE templates (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  is_default tinyint(1) NOT NULL,
  is_deleted tinyint(1) NOT NULL,
  include_all tinyint(1) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS template_projects;

CREATE TABLE template_projects (
  template_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  PRIMARY KEY  (template_id,project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS test_assocs;

CREATE TABLE test_assocs (
  id int(11) NOT NULL auto_increment,
  test_change_id int(11) NOT NULL,
  test_id int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY ix_test_assocs_test_change_id (test_change_id),
  KEY ix_test_assocs_test_id (test_id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS test_activities;

CREATE TABLE test_activities (
  `date` int(11) NOT NULL,
  project_id int(11) NOT NULL,
  run_id int(11) NOT NULL,
  passed_count int(11) NOT NULL,
  retest_count int(11) NOT NULL,
  failed_count int(11) NOT NULL,
  untested_count int(11) NOT NULL,
  blocked_count int(11) NOT NULL,
  custom_status1_count int(11) NOT NULL,
  custom_status2_count int(11) NOT NULL,
  custom_status3_count int(11) NOT NULL,
  custom_status4_count int(11) NOT NULL,
  custom_status5_count int(11) NOT NULL,
  custom_status6_count int(11) NOT NULL,
  custom_status7_count int(11) NOT NULL,
  PRIMARY KEY (`date`,project_id,run_id),
  KEY ix_test_activities_run_id (run_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS test_changes;

CREATE TABLE test_changes (
  id int(11) NOT NULL auto_increment,
  test_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  status_id int(11) default NULL,
  `comment` longtext,
  version varchar(250) default NULL,
  elapsed varchar(20) default NULL,
  defects varchar(250) default NULL,
  created_on int(11) NOT NULL,
  assignedto_id int(11) default NULL,
  unassigned tinyint(1) NOT NULL,
  project_id int(11) NOT NULL,
  run_id int(11) NOT NULL,
  is_selected tinyint(1) NOT NULL,
  caching int(11) NOT NULL,
  custom_step_results longtext,
  PRIMARY KEY  (id),
  KEY ix_test_changes_test_id (test_id),
  KEY ix_test_changes_project_order (project_id,is_selected,created_on),
  KEY ix_test_changes_run_order (run_id,is_selected,created_on)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS test_progress;

CREATE TABLE test_progress (
  `date` int(11) NOT NULL,
  project_id int(11) NOT NULL,
  run_id int(11) NOT NULL,
  tests int(11) NOT NULL,
  forecasts int(11) NOT NULL,
  PRIMARY KEY (`date`,project_id,run_id),
  KEY ix_test_progress_run_id (run_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS test_timers;

CREATE TABLE test_timers (
  test_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  started_on int(11) NOT NULL,
  elapsed int(11) NOT NULL,
  is_paused tinyint(1) NOT NULL,
  PRIMARY KEY  (test_id,user_id),
  KEY ix_test_timers_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tests;

CREATE TABLE tests (
  id int(11) NOT NULL AUTO_INCREMENT,
  run_id int(11) NOT NULL,
  case_id int(11) NULL,
  status_id int(11) NOT NULL,
  assignedto_id int(11) default NULL,
  is_selected tinyint(1) NOT NULL,
  last_status_change_id int(11) default NULL,
  is_completed tinyint(1) NOT NULL,
  in_progress int(11) NOT NULL,
  in_progress_by int(11) default NULL,
  content_id int(11) NULL,
  tested_by int(11) default NULL,
  tested_on int(11) default NULL,
  added_dynamic TINYINT(1) DEFAULT 0,
  PRIMARY KEY  (id),
  KEY ix_tests_run_id (run_id),
  KEY ix_tests_case_id (case_id,is_selected),
  KEY ix_tests_content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS uiscripts;

CREATE TABLE uiscripts (
  id int(11) NOT NULL auto_increment,
  `name` varchar( 250 ) NOT NULL,
  is_active tinyint(1) NOT NULL,
  includes varchar( 250 ) default NULL,
  excludes varchar( 250 ) default NULL,
  meta longtext default NULL,
  js longtext default NULL,
  css longtext default NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  email varchar(250) NOT NULL,
  is_admin tinyint(1) NOT NULL,
  salt varchar(250) NOT NULL,
  `hash` varchar(250) NOT NULL,
  is_active tinyint(1) NOT NULL,
  rememberme varchar(250) NOT NULL,
  locale varchar(250) default NULL,
  `language` varchar(250) default NULL,
  notifications tinyint(1) NOT NULL,
  csrf varchar(250) NOT NULL,
  role_id int(11) NOT NULL,
  login_token varchar(250) default NULL,
  timezone varchar(250) default NULL,
  login_token_until int(11) default NULL,
  last_activity INT default NULL,
  is_reset_password_forced tinyint(1) NOT NULL DEFAULT 0,
  data_processing_agreement longtext default NULL,
  theme INT DEFAULT 0,
  is_mfa_enabled INT default 0,
  auth_app_connected INT default 0,
  mfa_secret varchar(250) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS user_columns;

CREATE TABLE user_columns (
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  area_id int(11) NOT NULL,
  columns longtext NOT NULL,
  group_by varchar(250) NOT NULL,
  group_order varchar(250) NOT NULL,
  PRIMARY KEY (user_id, project_id, area_id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS user_exports;

CREATE TABLE user_exports (
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  area_id int(11) NOT NULL,
  format varchar(250) NOT NULL,
  options longtext NOT NULL,
  PRIMARY KEY (user_id, project_id, area_id, format)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS user_fields;

CREATE TABLE user_fields (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  system_name varchar(250) NOT NULL,
  label varchar(250) NOT NULL,
  description longtext,
  type_id int(11) NOT NULL,
  fallback varchar(250) NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_user_fields_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS user_filters;

CREATE TABLE user_filters (
  user_id int(11) NOT NULL,
  project_id int(11) NOT NULL,
  area_id int(11) NOT NULL,
  filters longtext NOT NULL,
  PRIMARY KEY (user_id, project_id, area_id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS user_logins;

CREATE TABLE user_logins (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  created_on int(11) NOT NULL,
  updated_on int(11) NOT NULL,
  attempts int(11) NOT NULL,
  mfa_attempts int(11) NOT NULL default 0,
  mfa_updated_on int(11) NOT NULL default 0,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_user_logins_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS user_settings;

CREATE TABLE user_settings (
  id int(11) NOT NULL auto_increment,
  user_id int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` longtext,
  PRIMARY KEY  (id),
  UNIQUE KEY ux_user_settings_name (user_id,name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS user_tokens;

CREATE TABLE user_tokens (
  id int(11) NOT NULL auto_increment,
  user_id int(11) NOT NULL,
  type_id int(11) NOT NULL,
  name varchar(250) NULL,
  series varchar(250) NULL,
  hash varchar(250) NOT NULL,
  created_on int(11) NOT NULL,
  expires_on int(11) NULL,
  PRIMARY KEY (id),
  KEY ix_user_tokens_user_id (user_id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS sso_settings;

CREATE TABLE  sso_settings(
 id int(11) NOT NULL auto_increment,
 sso_integration_name varchar(250) NOT NULL,
 testrail_entity_id varchar(250),
 sso_url varchar(250),
 idp_sso_url varchar(250),
 idp_issuer_url varchar(250),
 ssl_certificate longtext,
 saml_encryption_private_key longtext,
 PRIMARY KEY (id),
 UNIQUE KEY ux_sso_integration_name (sso_integration_name)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS report_api_templates;

CREATE TABLE `report_api_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` int(11) NOT NULL,
  `system_options` longtext COLLATE utf8_unicode_ci,
  `custom_options` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `ix_report_jobs_project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS audit_log;

CREATE TABLE audit_log (
  id bigint auto_increment not null,
  entity_id bigint not null,
  entity_type tinyint not null,
  action_type tinyint not null,
  user_id int not null,
  created_at datetime(6) null,
  `mode` tinyint null,
  entity_name varchar(256) null,
  project_name varchar(256) null,
  uuid_entity_id varchar(50) null,
  PRIMARY KEY (`id`)
);

create index audit_log_entity_type_action_type_mode_index on audit_log (entity_type, action_type, mode);

DROP TABLE IF EXISTS run_dynamic_filters;

CREATE TABLE run_dynamic_filters (
  run_id BIGINT NOT NULL,
  filters LONGTEXT NOT NULL,
  PRIMARY KEY (run_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `banners`;

CREATE TABLE `banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `last_reset_cookie_date` int(11) DEFAULT NULL,
  `force_reset_cookie` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `saml_assertions`;

CREATE TABLE `saml_assertions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `assertion_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `saml_assertions` ADD UNIQUE INDEX ix_saml_assertions_assertion_id (assertion_id);

DROP TABLE IF EXISTS `entity_attachments`;

CREATE TABLE IF NOT EXISTS `entity_attachments` (
    `id`             BIGINT unsigned NOT NULL AUTO_INCREMENT,
    `entity_id`      varchar(50) DEFAULT NULL,
    `attachment_id`  BIGINT unsigned NOT NULL,
    `entity_type_id` BIGINT unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `entity_types`;

CREATE TABLE IF NOT EXISTS `entity_types` (
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50)      NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

ALTER TABLE `entity_attachments` CHANGE COLUMN `entity_id` `entity_id` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_bin' AFTER `id`;

DROP TABLE IF EXISTS oauth_access_tokens;

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` int(11) NOT NULL auto_increment,
  `access_token` varchar(4000) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS oauth_authorization_codes;

CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
  `id` int(11) NOT NULL auto_increment,
  `authorization_code` varchar(4000) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS oauth_refresh_tokens;

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` int(11) NOT NULL auto_increment,
  `refresh_token` varchar(4000) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE milestones ADD COLUMN refs varchar(500) DEFAULT NULL;

DROP TABLE IF EXISTS milestones_refs;

CREATE TABLE milestones_refs (
  id int(11) NOT NULL auto_increment,
  reference_id varchar(500) NOT NULL,
  milestone_id int(11) NOT NULL,
  project_id int(11) NOT NULL, PRIMARY KEY (id)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS oauth_connection_tokens;

CREATE TABLE oauth_connection_tokens (
    id                      int(11)      NOT NULL AUTO_INCREMENT,
    user_id                 int(11)      NOT NULL,
    access_token            varchar(100) NOT NULL,
    refresh_token           varchar(100) NOT NULL,
    token_type              varchar(30)  NOT NULL,
    oauth_connection_server varchar(50)  NOT NULL,
    expires_in              int(11)      NOT NULL,
    created_date            int(11)      NOT NULL,
    modified_date           int(11)      NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB
  CHARACTER SET utf8
  COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `oauth_scopes`;

ALTER TABLE `oauth_access_tokens` ADD `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `expires`;

ALTER TABLE `oauth_refresh_tokens` ADD `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `expires`;

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
 `scope`      text,
 `is_default` tinyint(1) DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE oauth_access_tokens MODIFY COLUMN expires DATETIME;

DROP TABLE IF EXISTS `saml_assertions`;

CREATE TABLE `saml_assertions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `assertion_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `saml_assertions` ADD UNIQUE INDEX ix_saml_assertions_assertion_id (assertion_id);

ALTER TABLE `entity_attachments` CHANGE COLUMN `entity_id` `entity_id` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_bin' AFTER `id`;

DROP TABLE IF EXISTS oauth_clients;

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(11) NOT NULL auto_increment,
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(40) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS oauth_access_tokens;

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` int(11) NOT NULL auto_increment,
  `access_token` varchar(4000) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS oauth_authorization_codes;

CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
  `id` int(11) NOT NULL auto_increment,
  `authorization_code` varchar(4000) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS oauth_refresh_tokens;

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` int(11) NOT NULL auto_increment,
  `refresh_token` varchar(4000) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` timestamp NOT NULL,
  `scope` varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE `oauth_connection_tokens` ADD `oauth_server_region` VARCHAR(20) NOT NULL AFTER `modified_date`;

DROP TABLE IF EXISTS `oauth_scopes`;

ALTER TABLE `oauth_access_tokens` ADD `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `expires`;

ALTER TABLE `oauth_refresh_tokens` ADD `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `expires`;

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
 `scope`      text,
 `is_default` tinyint(1) DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE oauth_access_tokens MODIFY COLUMN expires DATETIME;

DROP TABLE IF EXISTS `saml_assertions`;

CREATE TABLE `saml_assertions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `assertion_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `saml_assertions` ADD UNIQUE INDEX ix_saml_assertions_assertion_id (assertion_id);

-- TR-1917 --
ALTER TABLE `oauth_clients` CHANGE `redirect_uri` `redirect_uri` VARCHAR(500)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT NULL;

ALTER TABLE `oauth_clients` ADD INDEX (`client_id`, `client_secret`, `redirect_uri`);

ALTER TABLE `oauth_access_tokens` CHANGE `access_token` `access_token` VARCHAR(400)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';

ALTER TABLE `oauth_access_tokens` ADD INDEX (`access_token`, `expires`);

ALTER TABLE `oauth_connection_tokens` ADD INDEX (`user_id`, `access_token`, `oauth_server_region`, `refresh_token`);

ALTER TABLE `oauth_authorization_codes` CHANGE `authorization_code` `authorization_code` VARCHAR(400)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';

ALTER TABLE `oauth_authorization_codes` CHANGE `redirect_uri` `redirect_uri` VARCHAR(200)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT NULL;

ALTER TABLE `oauth_authorization_codes` ADD INDEX (`authorization_code`, `user_id`);

ALTER TABLE `oauth_refresh_tokens` CHANGE `refresh_token` `refresh_token` VARCHAR(400)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';

ALTER TABLE `oauth_refresh_tokens` ADD INDEX (`refresh_token`, `created_on`, `user_id`);

ALTER TABLE `entity_attachments` CHANGE COLUMN `entity_id` `entity_id` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_bin' AFTER `id`;

-- TR-1922 --
ALTER TABLE `entity_attachments` ADD INDEX (`attachment_id`, `entity_id`);

-- TR-1922 --
ALTER TABLE `entity_attachments` ADD INDEX (`attachment_id`, `entity_id`);

DROP TABLE IF EXISTS `email_notification_template`;

CREATE TABLE IF NOT EXISTS `email_notification_template` (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email_template VARCHAR(255) NOT NULL,
    email_template_subject VARCHAR(255) NOT NULL,
    email_template_body TEXT NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE email_notification_template MODIFY email_template_subject TEXT;

-- PLA-142 --
ALTER TABLE `email_notification_template` ADD INDEX (`email_template`);

-- PEN-1 --
DROP TABLE IF EXISTS `pendo_data`;

CREATE TABLE IF NOT EXISTS `pendo_data` (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  processed tinyint(1) DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `pendo_auth`;

CREATE TABLE IF NOT EXISTS `pendo_auth` (
  `name` varchar(80)  NOT NULL,
  `value` varchar(2048)  NOT NULL,
  UNIQUE ux_pendo_auth_name (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- TR-2269 --
CREATE INDEX `ix_entity_id_and_entity_type_id` ON `entity_attachments` (`entity_id`, `entity_type_id`);

ALTER TABLE users ADD COLUMN is_sso_enabled INT DEFAULT 0;

ALTER TABLE user_logins ADD COLUMN current_auth VARCHAR (10) DEFAULT 'local';

ALTER TABLE users ADD COLUMN is_fallback_password_set INT DEFAULT 1;

DROP TABLE IF EXISTS `phinxlog`;

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE case_statuses (
  id int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL,
  short_name varchar(100),
  display_order int(11) NOT NULL,
  is_system tinyint(1) NOT NULL,
  is_approved tinyint(1) NOT NULL,
  is_default tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- TR-2245 --
CREATE INDEX `ix_milestone_id` ON `cases` (`milestone_id`);

DROP TABLE IF EXISTS case_comments;

CREATE TABLE case_comments (
  id int(11) NOT NULL auto_increment,
  case_id int(11) NOT NULL,
  change_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  created_on int(11) NOT NULL,
  `comment` longtext,
  PRIMARY KEY  (id),
  KEY case_id (case_id),
  KEY change_id (change_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE INDEX `ix_case_id_and_change_id` ON `case_comments` (`case_id`, `change_id`);

CREATE TABLE shared_step_changes (
  id int(11) NOT NULL auto_increment,
  shared_step_id int(11) NOT NULL,
  version int(11) NOT NULL,
  type_id int(11) NOT NULL,
  created_on int(11) NOT NULL,
  updated_by int(11) NOT NULL,
  changes longtext,
  PRIMARY KEY (id),
  KEY ix_shared_step_changes_shared_step_id (shared_step_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `message_queue`;

CREATE TABLE IF NOT EXISTS `message_queue` (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` text COLLATE utf8_unicode_ci NOT NULL,
  `data` longtext NOT NULL,
  processed tinyint(1) DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE FULLTEXT INDEX `ix_message_queue_message_id` ON `message_queue` (message_id(250));

CREATE TABLE IF NOT EXISTS `otp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` int,
  `user_id` int,
  `used` tinyint,
  `valid_upto` int,
  `created_date` int,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `sso_settings_oauth`;

CREATE TABLE `sso_settings_oauth`(
 `id` int(11) NOT NULL auto_increment,
 `sso_configuration` varchar(250) NOT NULL,
 `oauth_client_id` varchar(250),
 `oauth_client_secret` varchar(250),
 `oauth_issuer_uri` varchar(250),
 `oauth_user_auth_uri` varchar(250),
 `oauth_user_info_uri` varchar(250),
 `oauth_create_account_on_first_login` int(1) DEFAULT 1,
 `oauth_whitelist_domains` TEXT,
 `oauth_sso_url` varchar(250),
  PRIMARY KEY (`id`),
  UNIQUE KEY ux_sso_configuration_oauth (`sso_configuration`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `sso_settings_openid`;

CREATE TABLE `sso_settings_openid` (
 `id` int(11) NOT NULL auto_increment,
 `sso_configuration` varchar(250) NOT NULL,
 `client_id` varchar(250),
 `client_secret` varchar(250),
 `issuer_uri` varchar(250),
 `openid_create_account_on_first_login` int(1) DEFAULT 1,
 `whitelist_domains` TEXT,
 `sso_url` varchar(250),
 PRIMARY KEY (`id`),
 UNIQUE KEY ux_sso_configuration_openid (`sso_configuration`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- WP1-3 --
CREATE TABLE IF NOT EXISTS `webhooks` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `hook_id` varchar(50) NOT NULL,
    `webhook_name` varchar(300) NOT NULL,
    `payload_url` varchar(300) NOT NULL,
    `method` varchar(10) NOT NULL,
    `content_type`   longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `request_headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `response_headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `response_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `state` varchar(3) DEFAULT 404,
    `secret` varchar(100) DEFAULT NULL,
    `events` text DEFAULT NULL,
    `projects` tinyint(1) DEFAULT 0,
    `active` tinyint(1) DEFAULT 1,
    `user_id` int(11) NOT NULL,
    `created_at` timestamp NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `attempt` int(4) NOT NULL DEFAULT 0,
    `retry_at` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `webhook_deliveries` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `delivery_id` varchar(50) NOT NULL,
    `hook_id` varchar(50) NOT NULL,
    `user_id` varchar(50) NOT NULL,
    `request_headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `response_headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `response_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `state` varchar(3) DEFAULT 404,
    `created_at` timestamp NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `webhook_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hook_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS case_comments;

CREATE TABLE case_comments (
  `id` int(11) NOT NULL auto_increment,
  `case_id` int(11) NOT NULL,
  `change_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` int(11) NOT NULL,
  `comment` longtext,
  PRIMARY KEY  (`id`),
  KEY case_id (`case_id`),
  KEY change_id (`change_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE INDEX `ix_case_id_and_change_id` ON `case_comments` (`case_id`, `change_id`);
