IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[announcements]') AND type in (N'U'))
DROP TABLE [announcements]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sso_settings]') AND type in (N'U'))
DROP TABLE [sso_settings]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[audit_log]') AND type in (N'U'))
DROP TABLE [audit_log]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[report_api_templates]') AND type in (N'U'))
DROP TABLE [report_api_templates]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[attachments]') AND type in (N'U'))
DROP TABLE [attachments]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_attachments_case_id]') AND type = 'D')
BEGIN
ALTER TABLE [attachments] DROP CONSTRAINT [DF_attachments_case_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_attachments_test_change_id]') AND type = 'D')
BEGIN
ALTER TABLE [attachments] DROP CONSTRAINT [DF_attachments_test_change_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_attachments_user_id]') AND type = 'D')
BEGIN
ALTER TABLE [attachments] DROP CONSTRAINT [DF_attachments_user_id]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[case_assocs]') AND type in (N'U'))
DROP TABLE [case_assocs]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_case_changes_changes]') AND type = 'D')
BEGIN
ALTER TABLE [case_changes] DROP CONSTRAINT [DF_case_changes_changes]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[case_changes]') AND type in (N'U'))
DROP TABLE [case_changes]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[case_types]') AND type in (N'U'))
DROP TABLE [case_types]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_cases_template_id]') AND type = 'D')
BEGIN
ALTER TABLE [cases] DROP CONSTRAINT [DF_cases_template_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_cases_estimate]') AND type = 'D')
BEGIN
ALTER TABLE [cases] DROP CONSTRAINT [DF_cases_estimate]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_cases_milestone_id]') AND type = 'D')
BEGIN
ALTER TABLE [cases] DROP CONSTRAINT [DF_cases_milestone_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_cases_copyof_id]') AND type = 'D')
BEGIN
ALTER TABLE [cases] DROP CONSTRAINT [DF_cases_copyof_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_cases_estimate_forecast]') AND type = 'D')
BEGIN
ALTER TABLE [cases] DROP CONSTRAINT [DF_cases_estimate_forecast]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_cases_refs]') AND type = 'D')
BEGIN
ALTER TABLE [cases] DROP CONSTRAINT [DF_cases_refs]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[cases]') AND type in (N'U'))
DROP TABLE [cases]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[config_groups]') AND type in (N'U'))
DROP TABLE [config_groups]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[configs]') AND type in (N'U'))
DROP TABLE [configs]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[defects]') AND type in (N'U'))
DROP TABLE [defects]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[exports]') AND type in (N'U'))
DROP TABLE [exports]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_fields_description]') AND type = 'D')
BEGIN
ALTER TABLE [fields] DROP CONSTRAINT [DF_fields_description]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_fields_include_all]') AND type = 'D')
BEGIN
ALTER TABLE [fields] DROP CONSTRAINT [DF_fields_include_all]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[fields]') AND type in (N'U'))
DROP TABLE [fields]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[field_templates]') AND type in (N'U'))
DROP TABLE [field_templates]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[groups]') AND type in (N'U'))
DROP TABLE [groups]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[group_users]') AND type in (N'U'))
DROP TABLE [group_users]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[jobs]') AND type in (N'U'))
DROP TABLE [jobs]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[message_recps]') AND type in (N'U'))
DROP TABLE [message_recps]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[messages]') AND type in (N'U'))
DROP TABLE [messages]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_milestones_due_on]') AND type = 'D')
BEGIN
ALTER TABLE [milestones] DROP CONSTRAINT [DF_milestones_due_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_milestones_start_on]') AND type = 'D')
BEGIN
ALTER TABLE [milestones] DROP CONSTRAINT [DF_milestones_start_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_milestones_started_on]') AND type = 'D')
BEGIN
ALTER TABLE [milestones] DROP CONSTRAINT [DF_milestones_started_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_milestones_completed_on]') AND type = 'D')
BEGIN
ALTER TABLE [milestones] DROP CONSTRAINT [DF_milestones_completed_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_milestones_description]') AND type = 'D')
BEGIN
ALTER TABLE [milestones] DROP CONSTRAINT [DF_milestones_description]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_milestones_parent_id]') AND type = 'D')
BEGIN
ALTER TABLE [milestones] DROP CONSTRAINT [DF_milestones_parent_id]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[milestones]') AND type in (N'U'))
DROP TABLE [milestones]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_preferences_value]') AND type = 'D')
BEGIN
ALTER TABLE [preferences] DROP CONSTRAINT [DF_preferences_value]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[preferences]') AND type in (N'U'))
DROP TABLE [preferences]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[priorities]') AND type in (N'U'))
DROP TABLE [priorities]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_project_access_role_id]') AND type = 'D')
BEGIN
ALTER TABLE [project_access] DROP CONSTRAINT [DF_project_access_role_id]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_access]') AND type in (N'U'))
DROP TABLE [project_access]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_project_groups_role_id]') AND type = 'D')
BEGIN
ALTER TABLE [project_groups] DROP CONSTRAINT [DF_project_groups_role_id]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_groups]') AND type in (N'U'))
DROP TABLE [project_groups]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_project_history_suite_id]') AND type = 'D')
BEGIN
ALTER TABLE [project_history] DROP CONSTRAINT [DF_project_history_suite_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_project_history_milestone_id]') AND type = 'D')
BEGIN
ALTER TABLE [project_history] DROP CONSTRAINT [DF_project_history_milestone_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_project_history_run_id]') AND type = 'D')
BEGIN
ALTER TABLE [project_history] DROP CONSTRAINT [DF_project_history_run_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_project_history_name]') AND type = 'D')
BEGIN
ALTER TABLE [project_history] DROP CONSTRAINT [DF_project_history_name]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_history]') AND type in (N'U'))
DROP TABLE [project_history]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_favs]') AND type in (N'U'))
DROP TABLE [project_favs]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_announcement]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_announcement]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_defect_id_url]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_defect_id_url]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_defect_add_url]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_defect_add_url]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_reference_id_url]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_reference_id_url]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_reference_add_url]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_reference_add_url]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_defect_plugin]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_defect_plugin]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_defect_config]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_defect_config]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_defect_template]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_defect_template]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_reference_plugin]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_reference_plugin]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_reference_config]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_reference_config]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_users_data_processing_agreement]') AND type = 'D')
BEGIN
ALTER TABLE [users] DROP CONSTRAINT [DF_users_data_processing_agreement]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_default_role_id]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_default_role_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_completed_on]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_completed_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_projects_suite_mode]') AND type = 'D')
BEGIN
ALTER TABLE [projects] DROP CONSTRAINT [DF_projects_suite_mode]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[projects]') AND type in (N'U'))
DROP TABLE [projects]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[refs]') AND type in (N'U'))
DROP TABLE [refs]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[reports]') AND type in (N'U'))
DROP TABLE [reports]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[report_jobs]') AND type in (N'U'))
DROP TABLE [report_jobs]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[roles]') AND type in (N'U'))
DROP TABLE [roles]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_suite_id]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_suite_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_content_id]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_content_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_milestone_id]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_milestone_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_completed_on]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_completed_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_description]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_description]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_passed_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_passed_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_retest_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_retest_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_failed_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_failed_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_untested_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_untested_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_assignedto_id]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_assignedto_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_is_plan]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_is_plan]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_plan_id]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_plan_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_entry_id]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_entry_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_entries]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_entries]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_config]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_config]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_config_ids]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_config_ids]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_entry_index]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_entry_index]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_blocked_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_blocked_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status1_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status1_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status2_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status2_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status3_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status3_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status4_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status4_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status5_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status5_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status6_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status6_count]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_runs_custom_status7_count]') AND type = 'D')
BEGIN
ALTER TABLE [runs] DROP CONSTRAINT [DF_runs_custom_status7_count]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[runs]') AND type in (N'U'))
DROP TABLE [runs]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_sections_suite_id]') AND type = 'D')
BEGIN
ALTER TABLE [sections] DROP CONSTRAINT [DF_sections_suite_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_sections_copyof_id]') AND type = 'D')
BEGIN
ALTER TABLE [sections] DROP CONSTRAINT [DF_sections_copyof_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_sections_parent_id]') AND type = 'D')
BEGIN
ALTER TABLE [sections] DROP CONSTRAINT [DF_sections_parent_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_sections_depth]') AND type = 'D')
BEGIN
ALTER TABLE [sections] DROP CONSTRAINT [DF_sections_depth]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sections]') AND type in (N'U'))
DROP TABLE [sections]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_sessions_user_data]') AND type = 'D')
BEGIN
ALTER TABLE [sessions] DROP CONSTRAINT [DF_sessions_user_data]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sessions]') AND type in (N'U'))
DROP TABLE [sessions]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_settings_value]') AND type = 'D')
BEGIN
ALTER TABLE [settings] DROP CONSTRAINT [DF_settings_value]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[settings]') AND type in (N'U'))
DROP TABLE [settings]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[subscriptions]') AND type in (N'U'))
DROP TABLE [subscriptions]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_suites_description]') AND type = 'D')
BEGIN
ALTER TABLE [suites] DROP CONSTRAINT [DF_suites_description]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_suites_copyof_id]') AND type = 'D')
BEGIN
ALTER TABLE [suites] DROP CONSTRAINT [DF_suites_copyof_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_suites_is_master]') AND type = 'D')
BEGIN
ALTER TABLE [suites] DROP CONSTRAINT [DF_suites_is_master]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_suites_is_baseline]') AND type = 'D')
BEGIN
ALTER TABLE [suites] DROP CONSTRAINT [DF_suites_is_baseline]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_suites_is_completed]') AND type = 'D')
BEGIN
ALTER TABLE [suites] DROP CONSTRAINT [DF_suites_is_completed]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[suites]') AND type in (N'U'))
DROP TABLE [suites]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[statuses]') AND type in (N'U'))
DROP TABLE [statuses]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_task_heartbeat]') AND type = 'D')
BEGIN
ALTER TABLE [task] DROP CONSTRAINT [DF_task_heartbeat]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[task]') AND type in (N'U'))
DROP TABLE [task]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_assocs]') AND type in (N'U'))
DROP TABLE [test_assocs]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_activities]') AND type in (N'U'))
DROP TABLE [test_activities]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_status_id]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_status_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_comment]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_comment]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_version]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_version]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_elapsed]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_elapsed]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_defects]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_defects]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_assignedto_id]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_assignedto_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_is_selected]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_is_selected]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_test_changes_caching]') AND type = 'D')
BEGIN
ALTER TABLE [test_changes] DROP CONSTRAINT [DF_test_changes_caching]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_changes]') AND type in (N'U'))
DROP TABLE [test_changes]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_progress]') AND type in (N'U'))
DROP TABLE [test_progress]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_timers]') AND type in (N'U'))
DROP TABLE [test_timers]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_tests_assignedto_id]') AND type = 'D')
BEGIN
ALTER TABLE [tests] DROP CONSTRAINT [DF_tests_assignedto_id]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_tests_in_progress]') AND type = 'D')
BEGIN
ALTER TABLE [tests] DROP CONSTRAINT [DF_tests_in_progress]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_tests_in_progress_by]') AND type = 'D')
BEGIN
ALTER TABLE [tests] DROP CONSTRAINT [DF_tests_in_progress_by]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_tests_tested_by]') AND type = 'D')
BEGIN
ALTER TABLE [tests] DROP CONSTRAINT [DF_tests_tested_by]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_tests_tested_on]') AND type = 'D')
BEGIN
ALTER TABLE [tests] DROP CONSTRAINT [DF_tests_tested_on]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_tests_last_status_change_id]') AND type = 'D')
BEGIN
ALTER TABLE [tests] DROP CONSTRAINT [DF_tests_last_status_change_id]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[tests]') AND type in (N'U'))
DROP TABLE [tests]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[templates]') AND type in (N'U'))
DROP TABLE [templates]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[template_projects]') AND type in (N'U'))
DROP TABLE [template_projects]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[uiscripts]') AND type in (N'U'))
DROP TABLE [uiscripts]

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_users_locale]') AND type = 'D')
BEGIN
ALTER TABLE [users] DROP CONSTRAINT [DF_users_locale]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_users_language]') AND type = 'D')
BEGIN
ALTER TABLE [users] DROP CONSTRAINT [DF_users_language]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_users_login_token]') AND type = 'D')
BEGIN
ALTER TABLE [users] DROP CONSTRAINT [DF_users_login_token]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_users_login_token_until]') AND type = 'D')
BEGIN
ALTER TABLE [users] DROP CONSTRAINT [DF_users_login_token_until]
END

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_users_timezone]') AND type = 'D')
BEGIN
ALTER TABLE [users] DROP CONSTRAINT [DF_users_timezone]
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[users]') AND type in (N'U'))
DROP TABLE [users]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_columns]') AND type in (N'U'))
DROP TABLE [user_columns]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_exports]') AND type in (N'U'))
DROP TABLE [user_exports]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_fields]') AND type in (N'U'))
DROP TABLE [user_fields]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_filters]') AND type in (N'U'))
DROP TABLE [user_filters]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_logins]') AND type in (N'U'))
DROP TABLE [user_logins]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_settings]') AND type in (N'U'))
DROP TABLE [user_settings]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_tokens]') AND type in (N'U'))
DROP TABLE [user_tokens]

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[phinxlog]') AND type in (N'U'))
DROP TABLE [phinxlog]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[users]') AND type in (N'U'))
BEGIN
CREATE TABLE [users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[email] [nvarchar](250) NOT NULL,
	[is_admin] [bit] NOT NULL,
	[salt] [nvarchar](250) NOT NULL,
	[hash] [nvarchar](250) NOT NULL,
	[is_active] [bit] NOT NULL,
	[rememberme] [nvarchar](250) NOT NULL,
	[locale] [nvarchar](250) NULL CONSTRAINT [DF_users_locale]  DEFAULT (NULL),
	[language] [nvarchar](250) NULL CONSTRAINT [DF_users_language]  DEFAULT (NULL),
	[notifications] [bit] NOT NULL,
	[csrf] [nvarchar](250) NOT NULL,
	[role_id] [int] NOT NULL,
	[login_token] [nvarchar](250) NULL CONSTRAINT [DF_users_login_token]  DEFAULT (NULL),
	[timezone] [nvarchar](250) NULL CONSTRAINT [DF_users_timezone]  DEFAULT (NULL),
	[login_token_until] [int] NULL CONSTRAINT [DF_users_login_token_until]  DEFAULT (NULL),
	[last_activity] [int] NULL DEFAULT (NULL),
	[is_reset_password_forced] [bit] NOT NULL CONSTRAINT [DF_users_is_reset_password_forsed] DEFAULT (0),
	[data_processing_agreement] [nvarchar](max) NULL CONSTRAINT [DF_users_data_processing_agreement] DEFAULT (NULL),
	[theme] [int] NOT NULL DEFAULT (0),
 CONSTRAINT [PK_users] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END


SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[otp]') AND type in (N'U'))
BEGIN
CREATE TABLE [otp](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[code] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[used] [int] NOT NULL,
	[valid_upto] [int] NOT NULL,
	[created_date] [int] NOT NULL
 CONSTRAINT [PK_otp] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[users]') AND name = N'ux_users_email')
CREATE UNIQUE NONCLUSTERED INDEX [ux_users_email] ON [users]
(
	[email] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_columns]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_columns](
	[user_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
	[area_id] [int] NOT NULL,
	[columns] [nvarchar](max) NOT NULL,
	[group_by] [nvarchar](250) NOT NULL,
	[group_order] [nvarchar](250) NOT NULL,
 CONSTRAINT [PK_user_columns] PRIMARY KEY CLUSTERED
(
	[user_id] ASC,
	[project_id] ASC,
	[area_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_exports]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_exports](
	[user_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
	[area_id] [int] NOT NULL,
	[format] [nvarchar](250) NOT NULL,
	[options] [nvarchar](max) NOT NULL,
 CONSTRAINT [PK_user_exports] PRIMARY KEY CLUSTERED
(
	[user_id] ASC,
	[project_id] ASC,
	[area_id] ASC,
	[format] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_fields]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_fields](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[system_name] [nvarchar](250) NOT NULL,
	[label] [nvarchar](250) NOT NULL,
	[description] [nvarchar](max) NULL,
	[type_id] [int] NOT NULL,
	[fallback] [nvarchar](250) NULL,
 CONSTRAINT [PK_user_fields] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[user_fields]') AND name = N'ux_user_fields_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_user_fields_name] ON [user_fields]
(
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_filters]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_filters](
	[user_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
	[area_id] [int] NOT NULL,
	[filters] [nvarchar](max) NOT NULL,
 CONSTRAINT [PK_user_filters] PRIMARY KEY CLUSTERED
(
	[user_id] ASC,
	[project_id] ASC,
	[area_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_logins]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_logins](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[created_on] [int] NOT NULL,
	[updated_on] [int] NOT NULL,
	[attempts] [int] NOT NULL,
 CONSTRAINT [PK_user_logins] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[user_logins]') AND name = N'ux_user_logins_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_user_logins_name] ON [user_logins]
(
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_settings]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_settings](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[value] [nvarchar](max) NULL,
 CONSTRAINT [PK_user_settings] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[user_settings]') AND name = N'ux_user_settings_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_user_settings_name] ON [user_settings]
(
	[user_id] ASC,
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[user_tokens]') AND type in (N'U'))
BEGIN
CREATE TABLE [user_tokens](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[type_id] [int] NOT NULL,
	[name] [nvarchar](250) NULL,
	[series] [nvarchar](250) NULL,
	[hash] [nvarchar](250) NOT NULL,
	[created_on] [int] NOT NULL,
	[expires_on] [int] NULL,
 CONSTRAINT [PK_user_tokens] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[user_tokens]') AND name = N'ix_user_tokens_user_id')
CREATE NONCLUSTERED INDEX [ix_user_tokens_user_id] ON [user_tokens]
(
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[uiscripts]') AND type in (N'U'))
BEGIN
CREATE TABLE [uiscripts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[is_active] [bit] NOT NULL,
	[includes] [nvarchar](250) NULL,
	[excludes] [nvarchar](250) NULL,
	[meta] [nvarchar](max) NULL,
	[js] [nvarchar](max) NULL,
	[css] [nvarchar](max) NULL
 CONSTRAINT [PK_uiscripts] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[tests]') AND type in (N'U'))
BEGIN
CREATE TABLE [tests](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[run_id] [int] NOT NULL,
	[case_id] [int] NULL,
	[status_id] [int] NOT NULL,
	[assignedto_id] [int] NULL CONSTRAINT [DF_tests_assignedto_id] DEFAULT (NULL),
	[is_selected] [bit] NOT NULL,
	[last_status_change_id] [int] NULL CONSTRAINT [DF_tests_last_status_change_id]  DEFAULT (NULL),
	[is_completed] [bit] NOT NULL,
	[in_progress] [int] NOT NULL,
	[in_progress_by] [int] NULL CONSTRAINT [DF_tests_in_progress_by] DEFAULT (NULL),
	[content_id] [int] NULL,
	[tested_by] [int] NULL CONSTRAINT [DF_tests_tested_by] DEFAULT (NULL),
	[tested_on] [int] NULL CONSTRAINT [DF_tests_tested_on] DEFAULT (NULL),
	[added_dynamic] [bit] DEFAULT (0),
 CONSTRAINT [PK_tests] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[tests]') AND name = N'ix_tests_run_id')
CREATE NONCLUSTERED INDEX [ix_tests_run_id] ON [tests]
(
	[run_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[tests]') AND name = N'ix_tests_case_id')
CREATE NONCLUSTERED INDEX [ix_tests_case_id] ON [tests]
(
	[case_id] ASC,
	[is_selected] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[tests]') AND name = N'ix_tests_content_id')
CREATE NONCLUSTERED INDEX [ix_tests_content_id] ON [tests]
(
	[content_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_timers]') AND type in (N'U'))
BEGIN
CREATE TABLE [test_timers](
	[test_id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[started_on] [int] NOT NULL,
	[elapsed] [int] NOT NULL,
	[is_paused] [bit] NOT NULL,
 CONSTRAINT [PK_test_timers] PRIMARY KEY CLUSTERED
(
	[test_id] ASC,
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_timers]') AND name = N'ix_test_timers_user_id')
CREATE NONCLUSTERED INDEX [ix_test_timers_user_id] ON [test_timers]
(
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_progress]') AND type in (N'U'))
BEGIN
CREATE TABLE [test_progress](
	[date] int NOT NULL,
	[project_id] int NOT NULL,
	[run_id] int NOT NULL,
	[tests] int NOT NULL,
	[forecasts] int NOT NULL,
 CONSTRAINT [PK_test_progress] PRIMARY KEY CLUSTERED
(
	[date] ASC,
	[project_id] ASC,
	[run_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_progress]') AND name = N'ix_test_progress_run_id')
CREATE NONCLUSTERED INDEX [ix_test_progress_run_id] ON [test_progress]
(
	[run_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_changes]') AND type in (N'U'))
BEGIN
CREATE TABLE [test_changes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[test_id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[status_id] [int] NULL CONSTRAINT [DF_test_changes_status_id]  DEFAULT (NULL),
	[comment] [nvarchar](max) NULL CONSTRAINT [DF_test_changes_comment]  DEFAULT (NULL),
	[version] [nvarchar](250) NULL CONSTRAINT [DF_test_changes_version]  DEFAULT (NULL),
	[elapsed] [nvarchar](20) NULL CONSTRAINT [DF_test_changes_elapsed]  DEFAULT (NULL),
	[defects] [nvarchar](250) NULL CONSTRAINT [DF_test_changes_defects]  DEFAULT (NULL),
	[created_on] [int] NOT NULL,
	[assignedto_id] [int] NULL CONSTRAINT [DF_test_changes_assignedto_id]  DEFAULT (NULL),
	[unassigned] [bit] NOT NULL,
	[project_id] [int] NOT NULL,
	[run_id] [int] NOT NULL,
	[is_selected] [bit] NOT NULL,
	[caching] [int] NOT NULL,
	[custom_step_results] [nvarchar](max) NULL,
 CONSTRAINT [PK_test_changes] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_changes]') AND name = N'ix_test_changes_test_id')
CREATE NONCLUSTERED INDEX [ix_test_changes_test_id] ON [test_changes]
(
	[test_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_changes]') AND name = N'ix_test_changes_project_order')
CREATE NONCLUSTERED INDEX [ix_test_changes_project_order] ON [test_changes]
(
	[project_id] ASC,
	[is_selected] ASC,
	[created_on] DESC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_changes]') AND name = N'ix_test_changes_run_order')
CREATE NONCLUSTERED INDEX [ix_test_changes_run_order] ON [test_changes]
(
	[run_id] ASC,
	[is_selected] ASC,
	[created_on] DESC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_assocs]') AND type in (N'U'))
BEGIN
CREATE TABLE [test_assocs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[test_change_id] [int] NOT NULL,
	[test_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[value] [int] NOT NULL,
 CONSTRAINT [PK_test_assocs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_assocs]') AND name = N'ix_test_assocs_test_change_id')
CREATE NONCLUSTERED INDEX [ix_test_assocs_test_change_id] ON [test_assocs]
(
	[test_change_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_assocs]') AND name = N'ix_test_assocs_test_id')
CREATE NONCLUSTERED INDEX [ix_test_assocs_test_id] ON [test_assocs]
(
	[test_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[test_activities]') AND type in (N'U'))
BEGIN
CREATE TABLE [test_activities](
	[date] [int] NOT NULL,
	[project_id] [int] NOT NULL,
	[run_id] [int] NOT NULL,
	[passed_count] [int] NOT NULL,
	[retest_count] [int] NOT NULL,
	[failed_count] [int] NOT NULL,
	[untested_count] [int] NOT NULL,
	[blocked_count] [int] NOT NULL,
	[custom_status1_count] [int] NOT NULL,
	[custom_status2_count] [int] NOT NULL,
	[custom_status3_count] [int] NOT NULL,
	[custom_status4_count] [int] NOT NULL,
	[custom_status5_count] [int] NOT NULL,
	[custom_status6_count] [int] NOT NULL,
	[custom_status7_count] [int] NOT NULL,
 CONSTRAINT [PK_test_activities] PRIMARY KEY CLUSTERED
(
	[date] ASC,
	[project_id] ASC,
	[run_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[test_activities]') AND name = N'ix_test_activities_run_id')
CREATE NONCLUSTERED INDEX [ix_test_activities_run_id] ON [test_activities]
(
	[run_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[template_projects]') AND type in (N'U'))
BEGIN
CREATE TABLE [template_projects](
	[template_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
 CONSTRAINT [PK_template_projects] PRIMARY KEY CLUSTERED
(
	[template_id] ASC,
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[templates]') AND type in (N'U'))
BEGIN
CREATE TABLE [templates](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[is_default] [bit] NOT NULL,
	[is_deleted] [bit] NOT NULL,
	[include_all] [bit] NOT NULL,
 CONSTRAINT [PK_templates] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[task]') AND type in (N'U'))
BEGIN
CREATE TABLE [task](
	[id] [int] NOT NULL,
	[is_locked] [bit] NOT NULL,
	[heartbeat] [int] NULL CONSTRAINT [DF_task_heartbeat]  DEFAULT (NULL),
 CONSTRAINT [PK_task] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[statuses]') AND type in (N'U'))
BEGIN
CREATE TABLE [statuses](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[system_name] [nvarchar](250) NOT NULL,
	[label] [nvarchar](250) NOT NULL,
	[color_dark] [int] NOT NULL,
	[color_medium] [int] NOT NULL,
	[color_bright] [int] NOT NULL,
	[display_order] [int] NOT NULL,
	[is_system] [bit] NOT NULL,
	[is_active] [bit] NOT NULL,
	[is_untested] [bit] NOT NULL,
	[is_final] [bit] NOT NULL,
 CONSTRAINT [PK_statuses] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[statuses]') AND name = N'ux_statuses_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_statuses_name] ON [statuses]
(
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[suites]') AND type in (N'U'))
BEGIN
CREATE TABLE [suites](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[project_id] [int] NOT NULL,
	[description] [nvarchar](max) NULL CONSTRAINT [DF_suites_description]  DEFAULT (NULL),
	[created_on] [int] NOT NULL,
	[created_by] [int] NOT NULL,
	[is_copy] [bit] NOT NULL,
	[copyof_id] [int] NULL CONSTRAINT [DF_suites_copyof_id]  DEFAULT (NULL),
	[is_master] [bit] NOT NULL,
	[is_baseline] [bit] NOT NULL,
	[parent_id] [int] NULL,
	[is_completed] [bit] NOT NULL,
	[completed_on] [int] NULL,
 CONSTRAINT [PK_suites] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[suites]') AND name = N'ix_suites_project_id')
CREATE NONCLUSTERED INDEX [ix_suites_project_id] ON [suites]
(
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[suites]') AND name = N'ix_suites_copyof_id')
CREATE NONCLUSTERED INDEX [ix_suites_copyof_id] ON [suites]
(
	[copyof_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[subscriptions]') AND type in (N'U'))
BEGIN
CREATE TABLE [subscriptions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[is_subscribed] [bit] NOT NULL,
	[test_id] [int] NOT NULL,
	[run_id] [int] NOT NULL,
 CONSTRAINT [PK_subscriptions] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[subscriptions]') AND name = N'ux_subscriptions_run_test')
CREATE UNIQUE NONCLUSTERED INDEX [ux_subscriptions_run_test] ON [subscriptions]
(
	[run_id] ASC,
	[test_id] ASC,
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[settings]') AND type in (N'U'))
BEGIN
CREATE TABLE [settings](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[value] [nvarchar](max) NULL CONSTRAINT [DF_settings_value]  DEFAULT (NULL),
 CONSTRAINT [PK_settings] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[settings]') AND name = N'ux_settings_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_settings_name] ON [settings]
(
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sessions]') AND type in (N'U'))
BEGIN
CREATE TABLE [sessions](
	[session_id] [nvarchar](40) NOT NULL,
	[ip_address] [nvarchar](16) NOT NULL,
	[user_agent] [nvarchar](250) NOT NULL,
	[last_activity] [int] NOT NULL,
	[user_data] [nvarchar](max) NULL CONSTRAINT [DF_sessions_user_data]  DEFAULT (NULL),
	[id] [int] IDENTITY(1,1) NOT NULL,
 CONSTRAINT [PK_sessions] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[sessions]') AND name = N'ux_sessions_session_id')
CREATE UNIQUE NONCLUSTERED INDEX [ux_sessions_session_id] ON [sessions]
(
	[session_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sections]') AND type in (N'U'))
BEGIN
CREATE TABLE [sections](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[suite_id] [int] NULL CONSTRAINT [DF_sections_suite_id]  DEFAULT (NULL),
	[name] [nvarchar](250) NOT NULL,
	[display_order] [int] NOT NULL,
	[is_copy] [bit] NOT NULL,
	[copyof_id] [int] NULL CONSTRAINT [DF_sections_copyof_id]  DEFAULT (NULL),
	[parent_id] [int] NULL CONSTRAINT [DF_sections_parent_id]  DEFAULT (NULL),
	[depth] [int] NOT NULL CONSTRAINT [DF_sections_depth]  DEFAULT ((0)),
	[description] [nvarchar](max) NULL,
 CONSTRAINT [PK_sections] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[sections]') AND name = N'ix_sections_suite_id')
CREATE NONCLUSTERED INDEX [ix_sections_suite_id] ON [sections]
(
	[suite_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[sections]') AND name = N'ix_sections_copyof_id')
CREATE NONCLUSTERED INDEX [ix_sections_copyof_id] ON [sections]
(
	[copyof_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[sections]') AND name = N'ix_sections_parent_id')
CREATE NONCLUSTERED INDEX [ix_sections_parent_id] ON [sections]
(
	[parent_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[runs]') AND type in (N'U'))
BEGIN
CREATE TABLE [runs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[suite_id] [int] NULL CONSTRAINT [DF_runs_suite_id]  DEFAULT (NULL),
	[milestone_id] [int] NULL CONSTRAINT [DF_runs_milestone_id]  DEFAULT (NULL),
	[created_on] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
	[is_completed] [bit] NOT NULL,
	[completed_on] [int] NULL CONSTRAINT [DF_runs_completed_on]  DEFAULT (NULL),
	[include_all] [bit] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[description] [nvarchar](max) NULL CONSTRAINT [DF_runs_description]  DEFAULT (NULL),
	[passed_count] [int] NOT NULL CONSTRAINT [DF_runs_passed_count]  DEFAULT ((0)),
	[retest_count] [int] NOT NULL CONSTRAINT [DF_runs_retest_count]  DEFAULT ((0)),
	[failed_count] [int] NOT NULL CONSTRAINT [DF_runs_failed_count]  DEFAULT ((0)),
	[untested_count] [int] NOT NULL CONSTRAINT [DF_runs_untested_count]  DEFAULT ((0)),
	[assignedto_id] [int] NULL CONSTRAINT [DF_runs_assignedto_id]  DEFAULT (NULL),
	[is_plan] [bit] NOT NULL CONSTRAINT [DF_runs_is_plan]  DEFAULT ((0)),
	[plan_id] [int] NULL CONSTRAINT [DF_runs_plan_id]  DEFAULT (NULL),
	[entry_id] [nvarchar](250) NULL CONSTRAINT [DF_runs_entry_id]  DEFAULT (NULL),
	[entries] [nvarchar](max) NULL CONSTRAINT [DF_runs_entries]  DEFAULT (NULL),
	[config] [nvarchar](250) NULL CONSTRAINT [DF_runs_config]  DEFAULT (NULL),
	[config_ids] [nvarchar](250) NULL CONSTRAINT [DF_runs_config_ids]  DEFAULT (NULL),
	[entry_index] [int] NULL CONSTRAINT [DF_runs_entry_index]  DEFAULT (NULL),
	[blocked_count] [int] NOT NULL CONSTRAINT [DF_runs_blocked_count]  DEFAULT ((0)),
	[is_editable] [bit] NOT NULL,
	[content_id] [int] NULL CONSTRAINT [DF_runs_content_id]  DEFAULT (NULL),
	[custom_status1_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status1_count]  DEFAULT ((0)),
	[custom_status2_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status2_count]  DEFAULT ((0)),
	[custom_status3_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status3_count]  DEFAULT ((0)),
	[custom_status4_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status4_count]  DEFAULT ((0)),
	[custom_status5_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status5_count]  DEFAULT ((0)),
	[custom_status6_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status6_count]  DEFAULT ((0)),
	[custom_status7_count] [int] NOT NULL CONSTRAINT [DF_runs_custom_status7_count]  DEFAULT ((0)),
	[updated_by] [int] NOT NULL,
	[updated_on] [int] NOT NULL,
	[refs] [nvarchar](max) NULL DEFAULT (NULL) ,
 CONSTRAINT [PK_runs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[runs]') AND name = N'ix_runs_project_id')
CREATE NONCLUSTERED INDEX [ix_runs_project_id] ON [runs]
(
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[runs]') AND name = N'ix_runs_plan_id')
CREATE NONCLUSTERED INDEX [ix_runs_plan_id] ON [runs]
(
	[plan_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[runs]') AND name = N'ix_runs_milestone_id')
CREATE NONCLUSTERED INDEX [ix_runs_milestone_id] ON [runs]
(
	[milestone_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[runs]') AND name = N'ix_runs_suite_id')
CREATE NONCLUSTERED INDEX [ix_runs_suite_id] ON [runs]
(
	[suite_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[roles]') AND type in (N'U'))
BEGIN
CREATE TABLE [roles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[permissions] [int] NOT NULL,
	[is_default] [int] NOT NULL,
	[display_order] [int] NOT NULL,
 CONSTRAINT [PK_roles] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

ALTER TABLE [roles] ADD [is_project_admin] INT NOT NULL DEFAULT 0;

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'project_assignment')
BEGIN
CREATE TABLE project_assignment (
  [user_id] int NOT NULL,
  [project_id] int NOT NULL,
   PRIMARY KEY (user_id, project_id)
)
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[reports]') AND type in (N'U'))
BEGIN
CREATE TABLE [reports](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[plugin] [nvarchar](250) NOT NULL,
	[project_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[description] [nvarchar](max) NULL,
	[access] [int] NOT NULL,
	[created_by] [int] NOT NULL,
	[created_on] [int] NOT NULL,
	[executed_on] [int] NULL,
	[execution_time] [int] NULL,
	[dir] [nvarchar](250) NULL,
	[formats] [nvarchar](max) NULL,
	[system_options] [nvarchar](max) NULL,
	[custom_options] [nvarchar](max) NULL,
	[status] [int] NOT NULL,
	[status_message] [nvarchar](max) NULL,
	[status_trace] [nvarchar](max) NULL,
	[is_locked] [bit] NOT NULL,
	[heartbeat] [int] NOT NULL,
CONSTRAINT [PK_reports] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[reports]') AND name = N'ix_reports_project_id')
CREATE NONCLUSTERED INDEX [ix_reports_project_id] ON [reports]
(
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[report_jobs]') AND type in (N'U'))
BEGIN
CREATE TABLE [report_jobs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[plugin] [nvarchar](250) NOT NULL,
	[project_id] [int] NOT NULL,
	[created_by] [int] NOT NULL,
	[created_on] [int] NOT NULL,
	[executed_on] [int] NULL,
	[system_options] [nvarchar](max) NULL,
	[custom_options] [nvarchar](max) NULL,
CONSTRAINT [PK_report_jobs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[report_jobs]') AND name = N'ix_report_jobs_project_id')
CREATE NONCLUSTERED INDEX [ix_report_jobs_project_id] ON [report_jobs]
(
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[refs]') AND type in (N'U'))
BEGIN
CREATE TABLE [refs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[reference_id] [nvarchar](250) NOT NULL,
	[case_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
 CONSTRAINT [PK_refs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[runs_refs]') AND type in (N'U'))
BEGIN
CREATE TABLE [runs_refs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[reference_id] [nvarchar](250) NOT NULL,
	[run_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
 CONSTRAINT [PK_runs_refs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[refs]') AND name = N'ix_refs_reference_id')
CREATE NONCLUSTERED INDEX [ix_refs_reference_id] ON [refs]
(
	[reference_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[refs]') AND name = N'ix_refs_case_id')
CREATE NONCLUSTERED INDEX [ix_refs_case_id] ON [refs]
(
	[case_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[projects]') AND type in (N'U'))
BEGIN
CREATE TABLE [projects](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[announcement] [nvarchar](max) NULL CONSTRAINT [DF_projects_announcement]  DEFAULT (NULL),
	[show_announcement] [bit] NOT NULL,
	[defect_id_url] [nvarchar](250) NULL CONSTRAINT [DF_projects_defect_id_url]  DEFAULT (NULL),
	[defect_add_url] [nvarchar](250) NULL CONSTRAINT [DF_projects_defect_add_url]  DEFAULT (NULL),
	[default_access] [int] NOT NULL,
	[default_role_id] [int] NULL CONSTRAINT [DF_projects_default_role_id]  DEFAULT (NULL),
	[reference_id_url] [nvarchar](250) NULL CONSTRAINT [DF_projects_reference_id_url]  DEFAULT (NULL),
	[reference_add_url] [nvarchar](250) NULL CONSTRAINT [DF_projects_reference_add_url]  DEFAULT (NULL),
	[defect_plugin] [nvarchar](250) NULL CONSTRAINT [DF_projects_defect_plugin]  DEFAULT (NULL),
	[defect_config] [nvarchar](max) NULL CONSTRAINT [DF_projects_defect_config]  DEFAULT (NULL),
	[is_completed] [bit] NOT NULL,
	[completed_on] [int] NULL CONSTRAINT [DF_projects_completed_on]  DEFAULT (NULL),
	[defect_template] [nvarchar](max) NULL CONSTRAINT [DF_projects_defect_template]  DEFAULT (NULL),
	[suite_mode] [int] NOT NULL,
	[master_id] [int] NULL,
	[reference_plugin] [nvarchar](250) NULL CONSTRAINT [DF_projects_reference_plugin]  DEFAULT (NULL),
	[reference_config] [nvarchar](max) NULL CONSTRAINT [DF_projects_reference_config]  DEFAULT (NULL),
	[case_statuses_enabled] [bit] NOT NULL,
	[is_test_case_approval_enabled] [bit] NOT NULL DEFAULT (0),
 CONSTRAINT [PK_projects] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_favs]') AND type in (N'U'))
BEGIN
CREATE TABLE [project_favs](
	[user_id] [int] NOT NULL,
	[project_id] [int] NOT NULL,
	[created_on] [int] NOT NULL,
 CONSTRAINT [PK_project_favs] PRIMARY KEY CLUSTERED
(
	[user_id] ASC,
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_history]') AND type in (N'U'))
BEGIN
CREATE TABLE [project_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[project_id] [int] NOT NULL,
	[action] [int] NOT NULL,
	[created_on] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[suite_id] [int] NULL CONSTRAINT [DF_project_history_suite_id]  DEFAULT (NULL),
	[milestone_id] [int] NULL CONSTRAINT [DF_project_history_milestone_id]  DEFAULT (NULL),
	[run_id] [int] NULL CONSTRAINT [DF_project_history_run_id]  DEFAULT (NULL),
	[name] [nvarchar](250) NULL CONSTRAINT [DF_project_history_name]  DEFAULT (NULL),
	[is_deleted] [bit] NOT NULL,
	[plan_id] [int] NULL,
 CONSTRAINT [PK_project_history] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[project_history]') AND name = N'ix_project_history_project_order')
CREATE NONCLUSTERED INDEX [ix_project_history_project_order] ON [project_history]
(
	[project_id] ASC,
	[created_on] DESC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_access]') AND type in (N'U'))
BEGIN
CREATE TABLE [project_access](
	[project_id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[access] [int] NOT NULL,
	[role_id] [int] NULL CONSTRAINT [DF_project_access_role_id]  DEFAULT (NULL),
 CONSTRAINT [PK_project_access] PRIMARY KEY CLUSTERED
(
	[project_id] ASC,
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[project_groups]') AND type in (N'U'))
BEGIN
CREATE TABLE [project_groups](
	[project_id] [int] NOT NULL,
	[group_id] [int] NOT NULL,
	[access] [int] NOT NULL,
	[role_id] [int] NULL CONSTRAINT [DF_project_groups_role_id]  DEFAULT (NULL),
 CONSTRAINT [PK_project_groups] PRIMARY KEY CLUSTERED
(
	[project_id] ASC,
	[group_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[priorities]') AND type in (N'U'))
BEGIN
CREATE TABLE [priorities](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[priority] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[short_name] [nvarchar](250) NOT NULL,
	[is_default] [bit] NOT NULL,
	[is_deleted] [bit] NOT NULL,
 CONSTRAINT [PK_priorities] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[preferences]') AND type in (N'U'))
BEGIN
CREATE TABLE [preferences](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[value] [nvarchar](max) NULL CONSTRAINT [DF_preferences_value]  DEFAULT (NULL),
 CONSTRAINT [PK_preferences] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[preferences]') AND name = N'ix_preferences_user_id')
CREATE NONCLUSTERED INDEX [ix_preferences_user_id] ON [preferences]
(
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[preferences]') AND name = N'ux_preferences_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_preferences_name] ON [preferences]
(
	[user_id] ASC,
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[milestones]') AND type in (N'U'))
BEGIN
CREATE TABLE [milestones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[project_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[due_on] [int] NULL CONSTRAINT [DF_milestones_due_on]  DEFAULT (NULL),
	[completed_on] [int] NULL CONSTRAINT [DF_milestones_completed_on]  DEFAULT (NULL),
	[is_completed] [bit] NOT NULL,
	[description] [nvarchar](max) NULL CONSTRAINT [DF_milestones_description]  DEFAULT (NULL),
	[start_on] [int] NULL CONSTRAINT [DF_milestones_start_on]  DEFAULT (NULL),
	[started_on] [int] NULL CONSTRAINT [DF_milestones_started_on]  DEFAULT (NULL),
	[is_started] [bit] NOT NULL,
	[parent_id] int NULL CONSTRAINT [DF_milestones_parent_id]  DEFAULT (NULL),
 CONSTRAINT [PK_milestones] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[milestones]') AND name = N'ix_milestones_project_id')
CREATE NONCLUSTERED INDEX [ix_milestones_project_id] ON [milestones]
(
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[milestones]') AND name = N'ix_milestones_parent_id')
CREATE NONCLUSTERED INDEX [ix_milestones_parent_id] ON [milestones]
(
	[parent_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[messages]') AND type in (N'U'))
BEGIN
CREATE TABLE [messages](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[subject] [nvarchar](250) NOT NULL,
	[body] [nvarchar](max) NOT NULL,
	[created_on] [int] NOT NULL,
 CONSTRAINT [PK_messages] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[message_recps]') AND type in (N'U'))
BEGIN
CREATE TABLE [message_recps](
	[user_id] [int] NOT NULL,
	[message_id] [int] NOT NULL,
 CONSTRAINT [PK_message_recps] PRIMARY KEY CLUSTERED
(
	[message_id] ASC,
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[jobs]') AND type in (N'U'))
BEGIN
CREATE TABLE [jobs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[created_on] [int] NOT NULL,
	[is_locked] [bit] NOT NULL,
	[heartbeat] [int] NOT NULL,
	[is_done] [bit] NOT NULL,
 CONSTRAINT [PK_jobs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[jobs]') AND name = N'ux_jobs_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_jobs_name] ON [jobs]
(
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[groups]') AND type in (N'U'))
BEGIN
CREATE TABLE [groups](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
 CONSTRAINT [PK_groups] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[group_users]') AND type in (N'U'))
BEGIN
CREATE TABLE [group_users](
	[group_id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
 CONSTRAINT [PK_group_users] PRIMARY KEY CLUSTERED
(
	[group_id] ASC,
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[group_users]') AND name = N'ix_group_users_user_id')
CREATE NONCLUSTERED INDEX [ix_group_users_user_id] ON [group_users]
(
	[user_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[field_templates]') AND type in (N'U'))
BEGIN
CREATE TABLE [field_templates](
	[field_id] [int] NOT NULL,
	[template_id] [int] NOT NULL,
 CONSTRAINT [PK_field_templates] PRIMARY KEY CLUSTERED
(
	[field_id] ASC,
	[template_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[fields]') AND type in (N'U'))
BEGIN
CREATE TABLE [fields](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[system_name] [nvarchar](250) NOT NULL,
	[entity_id] [int] NOT NULL,
	[label] [nvarchar](250) NOT NULL,
	[description] [nvarchar](max) NULL CONSTRAINT [DF_fields_description]  DEFAULT (NULL),
	[type_id] [int] NOT NULL,
	[location_id] [int] NOT NULL,
	[display_order] [int] NOT NULL,
	[configs] [nvarchar](max) NOT NULL,
	[is_multi] [bit] NOT NULL,
	[is_active] [bit] NOT NULL,
	[status_id] [int] NOT NULL,
	[is_system] [bit] NOT NULL,
	[include_all] [bit] NOT NULL,
 CONSTRAINT [PK_fields] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[fields]') AND name = N'ux_fields_name')
CREATE UNIQUE NONCLUSTERED INDEX [ux_fields_name] ON [fields]
(
	[entity_id] ASC,
	[name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[exports]') AND type in (N'U'))
BEGIN
CREATE TABLE [exports](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[filename] [nvarchar](250) NOT NULL,
	[size] [bigint] NOT NULL,
	[created_on] [int] NOT NULL,
 CONSTRAINT [PK_exports] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[exports]') AND name = N'ix_exports_created_on')
CREATE NONCLUSTERED INDEX [ix_exports_created_on] ON [exports]
(
	[created_on] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[defects]') AND type in (N'U'))
BEGIN
CREATE TABLE [defects](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[defect_id] [nvarchar](250) NOT NULL,
	[test_change_id] [int] NOT NULL,
	[case_id] [int] NULL,
	[project_id] [int] NOT NULL,
 CONSTRAINT [PK_defects] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[defects]') AND name = N'ix_defects_defect_id')
CREATE NONCLUSTERED INDEX [ix_defects_defect_id] ON [defects]
(
	[defect_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[defects]') AND name = N'ix_defects_test_change_id')
CREATE NONCLUSTERED INDEX [ix_defects_test_change_id] ON [defects]
(
	[test_change_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[defects]') AND name = N'ix_defects_case_id')
CREATE NONCLUSTERED INDEX [ix_defects_case_id] ON [defects]
(
	[case_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[configs]') AND type in (N'U'))
BEGIN
CREATE TABLE [configs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[group_id] [int] NOT NULL,
 CONSTRAINT [PK_configs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[configs]') AND name = N'ix_configs_group_id')
CREATE NONCLUSTERED INDEX [ix_configs_group_id] ON [configs]
(
	[group_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[config_groups]') AND type in (N'U'))
BEGIN
CREATE TABLE [config_groups](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[project_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
 CONSTRAINT [PK_config_groups] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[config_groups]') AND name = N'ix_config_groups_project_id')
CREATE NONCLUSTERED INDEX [ix_config_groups_project_id] ON [config_groups]
(
	[project_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[cases]') AND type in (N'U'))
BEGIN
CREATE TABLE [cases](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[section_id] [int] NOT NULL,
	[title] [nvarchar](250) NOT NULL,
	[display_order] [int] NOT NULL,
	[priority_id] [int] NOT NULL,
	[estimate] [int] NULL CONSTRAINT [DF_cases_estimate]  DEFAULT (NULL),
	[milestone_id] [int] NULL CONSTRAINT [DF_cases_milestone_id]  DEFAULT (NULL),
	[custom_preconds] [nvarchar](max) NULL,
	[custom_steps] [nvarchar](max) NULL,
	[custom_expected] [nvarchar](max) NULL,
	[custom_steps_separated] [nvarchar](max) NULL,
	[custom_mission] [nvarchar](max) NULL,
	[custom_goals] [nvarchar](max) NULL,
	[custom_automation_type] [int] NULL,
	[type_id] [int] NOT NULL,
	[is_copy] [bit] NOT NULL,
	[copyof_id] [int] NULL CONSTRAINT [DF_cases_copyof_id]  DEFAULT (NULL),
	[created_on] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[estimate_forecast] [int] NULL CONSTRAINT [DF_cases_estimate_forecast]  DEFAULT (NULL),
	[refs] [nvarchar](250) NULL CONSTRAINT [DF_cases_refs]  DEFAULT (NULL),
	[suite_id] [int] NOT NULL,
	[updated_on] [int] NOT NULL,
	[updated_by] [int] NOT NULL,
	[template_id] [int] NOT NULL,
	[is_deleted] [bit] NOT NULL CONSTRAINT DF_cases_is_deleted DEFAULT 0,
	[status_id] [int] NOT NULL DEFAULT 1,
  	[assigned_to_id] [int] DEFAULT NULL,
 CONSTRAINT [PK_cases] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[cases]') AND name = N'ix_cases_section_id')
CREATE NONCLUSTERED INDEX [ix_cases_section_id] ON [cases]
(
	[section_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[cases]') AND name = N'ix_cases_suite_id')
CREATE NONCLUSTERED INDEX [ix_cases_suite_id] ON [cases]
(
	[suite_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[cases]') AND name = N'ix_cases_copyof_id')
CREATE NONCLUSTERED INDEX [ix_cases_copyof_id] ON [cases]
(
	[copyof_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[case_assocs]') AND type in (N'U'))
BEGIN
CREATE TABLE [case_assocs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[case_id] [int] NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[value] [int] NOT NULL,
 CONSTRAINT [PK_case_assocs] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[case_assocs]') AND name = N'ix_case_assocs_case_id')
CREATE NONCLUSTERED INDEX [ix_case_assocs_case_id] ON [case_assocs]
(
	[case_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[case_changes]') AND type in (N'U'))
BEGIN
CREATE TABLE [case_changes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[case_id] [int] NOT NULL,
	[type_id] [int] NOT NULL,
	[created_on] [int] NOT NULL,
	[user_id] [int] NOT NULL,
	[changes] [nvarchar](max) NULL CONSTRAINT [DF_case_changes_changes]  DEFAULT (NULL),
 CONSTRAINT [PK_case_changes] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[case_changes]') AND name = N'ix_case_changes_case_id')
CREATE NONCLUSTERED INDEX [ix_case_changes_case_id] ON [case_changes]
(
	[case_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[case_changes]') AND name = N'ix_case_changes_type_id')
CREATE NONCLUSTERED INDEX [ix_case_changes_type_id] ON [case_changes]
(
	[type_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[case_types]') AND type in (N'U'))
BEGIN
CREATE TABLE [case_types](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[is_default] [bit] NOT NULL,
	[is_deleted] [bit] NOT NULL,
 CONSTRAINT [PK_case_types] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[attachments]') AND type in (N'U'))
BEGIN
CREATE TABLE [attachments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](250) NOT NULL,
	[filename] [nvarchar](250) NOT NULL,
	[size] [int] NOT NULL,
	[created_on] [int] NOT NULL,
	[project_id] [int] NULL,
	[case_id] [int] NULL CONSTRAINT [DF_attachments_case_id]  DEFAULT (NULL),
	[test_change_id] [int] NULL CONSTRAINT [DF_attachments_test_change_id]  DEFAULT (NULL),
	[user_id] [int] NULL CONSTRAINT [DF_attachments_user_id]  DEFAULT (NULL),
 CONSTRAINT [PK_attachments] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[attachments]') AND name = N'ix_attachments_case_id')
CREATE NONCLUSTERED INDEX [ix_attachments_case_id] ON [attachments]
(
	[case_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[attachments]') AND name = N'ix_attachments_test_change_id')
CREATE NONCLUSTERED INDEX [ix_attachments_test_change_id] ON [attachments]
(
	[test_change_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[announcements]') AND type in (N'U'))
BEGIN
CREATE TABLE [announcements](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[title] [nvarchar](250) NOT NULL,
	[start_date] [int] NULL,
	[end_date] [int] NULL,
	[height] int NULL,
	[width] int NULL,
	[view] [nvarchar](250) NOT NULL,
 CONSTRAINT [PK_announcements] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sso_settings]') AND type in (N'U'))
BEGIN
CREATE TABLE [sso_settings](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sso_integration_name] [nvarchar](250) NULL,
	[testrail_entity_id] [nvarchar](250) NULL,
	[sso_url] [nvarchar](250) NULL,
	[idp_sso_url] [nvarchar](250) NULL,
	[idp_issuer_url] [nvarchar](250) NULL,
	[ssl_certificate] [nvarchar](max) NULL,
	[saml_encryption_private_key] [nvarchar](max) NULL,
 CONSTRAINT [PK_sso_settings] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[report_api_templates]') AND type in (N'U'))
BEGIN
CREATE TABLE [report_api_templates] (
  [id] int NOT NULL IDENTITY,
  [plugin] varchar(250) NOT NULL,
  [project_id] int NOT NULL,
  [access] int NOT NULL,
  [created_by] int NOT NULL,
  [created_on] int NOT NULL,
  [system_options] varchar(max),
  [custom_options] varchar(max),
 CONSTRAINT [PK_report_api_templates] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[audit_log]') AND type in (N'U'))
BEGIN
CREATE TABLE [audit_log]
(
	[id] BIGINT PRIMARY KEY NOT NULL IDENTITY,
	[entity_id] BIGINT NOT NULL,
	[entity_type] TINYINT NOT NULL,
	[action_type] TINYINT NOT NULL,
	[user_id] INT NOT NULL,
	[created_at] DATETIME2(6),
	[mode] TINYINT,
	[entity_name] VARCHAR(256),
	[project_name] VARCHAR(256),
	[uuid_entity_id] VARCHAR(50)
);
CREATE INDEX [audit_log_entity_type_action_type_mode_index] ON [audit_log] ([entity_type], [action_type], [mode]);
CREATE INDEX [audit_logs_id_entity_type_action_type_mode_index] ON [audit_log] ([id], [entity_type], [action_type], [mode]);
END

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[run_dynamic_filters]') AND type in (N'U'))
BEGIN
CREATE TABLE [run_dynamic_filters]
(
	[run_id] BIGINT PRIMARY KEY NOT NULL,
	[filters] VARCHAR(max)
);
END
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[audit_log_exports]') AND type in (N'U'))
BEGIN
CREATE TABLE [audit_log_exports]
(
	[id] BIGINT PRIMARY KEY NOT NULL IDENTITY,
	[status] TINYINT NULL,
	[filename] VARCHAR(256),
	[created_on] [bigint],
	[size] [bigint] NULL
);
END

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[banners]') AND type in (N'U'))
BEGIN
    CREATE TABLE [banners](
      [id] [int] IDENTITY(1, 1) NOT NULL,
      [banner_id] [int] NOT NULL,
      [content] text,
      [start_date] [int],
      [end_date] [int],
      [last_reset_cookie_date] [int],
      [force_reset_cookie] TINYINT NOT NULL DEFAULT 0,
      [active] TINYINT NOT NULL DEFAULT 0,
      PRIMARY KEY ([id])
    )
END;

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[saml_assertions]') AND type in (N'U'))
BEGIN
    CREATE TABLE [saml_assertions](
      [id] [int] IDENTITY(1, 1) NOT NULL,
      [assertion_id] [nvarchar](100) NOT NULL,
      [expires_at] DATETIME2(6) NOT NULL,
      PRIMARY KEY ([id])
    );
    CREATE INDEX [ix_saml_assertions_assertion_id] ON [saml_assertions] ([assertion_id]);
END;
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[entity_attachments]') AND type in (N'U'))
DROP TABLE [entity_attachments];

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[entity_attachments]') AND type in (N'U'))
BEGIN
CREATE TABLE [entity_attachments]
(
    [id]             [int] IDENTITY(1,1) NOT NULL,
    [entity_id]      [nvarchar](250) NULL,
    [attachment_id]  [int] NOT NULL,
    [entity_type_id] [int] NOT NULL
    CONSTRAINT [PK_entity_attachments] PRIMARY KEY CLUSTERED
(
[id] ASC
) WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
    ) ON [PRIMARY]
    END;

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[entity_types]') AND type in (N'U'))
DROP TABLE [entity_types];

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[entity_types]') AND type in (N'U'))
BEGIN
CREATE TABLE [entity_types]
(
    [id]   [int] IDENTITY(1,1) NOT NULL,
    [name] [nvarchar](50) NOT NULL
    CONSTRAINT [PK_entity_types] PRIMARY KEY CLUSTERED
(
[id] ASC
) WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
    ) ON [PRIMARY]
    END;

ALTER TABLE [dbo].[entity_attachments] ALTER COLUMN entity_id NVARCHAR(250) COLLATE latin1_general_bin NULL;

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[oauth_clients]') AND type in (N'U'))
DROP TABLE [oauth_clients];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'oauth_clients')
BEGIN
CREATE TABLE oauth_clients (
  [id] int NOT NULL identity,
  [client_id] varchar(80) NOT NULL,
  [client_secret] varchar(80) DEFAULT NULL,
  [redirect_uri] varchar(2000) DEFAULT NULL,
  [grant_types] varchar(80) DEFAULT NULL,
  [scope] varchar(40) DEFAULT NULL,
  [user_id] int NOT NULL,
   PRIMARY KEY (id)
)
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[oauth_access_tokens]') AND type in (N'U'))
DROP TABLE [oauth_access_tokens];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'oauth_access_tokens')
BEGIN
CREATE TABLE oauth_access_tokens (
  [id] int NOT NULL identity,
  [access_token] varchar(4000) NOT NULL,
  [client_id] varchar(80) NOT NULL,
  [user_id] int NOT NULL,
  [expires] datetime2(0) NOT NULL,
  [scope] varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
)
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[oauth_authorization_codes]') AND type in (N'U'))
DROP TABLE [oauth_authorization_codes];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'oauth_authorization_codes')
BEGIN
CREATE TABLE oauth_authorization_codes (
  [id] int NOT NULL identity,
  [authorization_code] varchar(4000) NOT NULL,
  [client_id] varchar(80) NOT NULL,
  [user_id] int NOT NULL,
  [redirect_uri] varchar(2000) DEFAULT NULL,
  [expires] datetime2(0) NOT NULL,
  [scope] varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
)
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[oauth_refresh_tokens]') AND type in (N'U'))
DROP TABLE [oauth_refresh_tokens];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'oauth_refresh_tokens')
BEGIN
CREATE TABLE oauth_refresh_tokens (
  [id] int NOT NULL identity,
  [refresh_token] varchar(4000) NOT NULL,
  [client_id] varchar(80) NOT NULL,
  [user_id] int NOT NULL,
  [expires] datetime2(0) NOT NULL,
  [scope] varchar(40) DEFAULT NULL,
   PRIMARY KEY (id)
)
END

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[milestones_refs]') AND type in (N'U'))
DROP TABLE [milestones_refs];

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[milestones_refs]') AND type in (N'U'))
BEGIN
CREATE TABLE [milestones_refs](
  [id] [int] IDENTITY(1, 1) NOT NULL,
  [reference_id] [nvarchar](500) NOT NULL,
  [milestone_id] [int] NOT NULL,
  [project_id] [int] NOT NULL,
  PRIMARY KEY ([id])
)
END

ALTER TABLE [milestones] ADD [refs] [nvarchar](500) NULL;

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[oauth_connection_tokens]') AND type in (N'U'))
DROP TABLE [oauth_connection_tokens];

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[oauth_connection_tokens]')
                AND type in (N'U'))
    BEGIN
        CREATE TABLE [oauth_connection_tokens]
        (
            [id]                      int          NOT NULL identity,
            [user_id]                 int          NOT NULL,
            [access_token]            varchar(100) NOT NULL,
            [refresh_token]           varchar(100) NOT NULL,
            [token_type]              varchar(50)  NOT NULL,
            [oauth_connection_server] varchar(50)  NOT NULL,
            [expires_in]              int          NOT NULL,
            [created_date]            int          NOT NULL,
            [modified_date]           int          NOT NULL,
            [oauth_server_region]     varchar(20)  NOT NULL,
            PRIMARY KEY (id)
        );
    END;

ALTER TABLE [oauth_access_tokens] ADD [created_on] DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE [oauth_refresh_tokens] ADD [created_on] DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ;

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[oauth_scopes]') AND type in (N'U'))
DROP TABLE [oauth_scopes];

CREATE TABLE oauth_scopes (
  [scope] varchar(max),
  [is_default] smallint DEFAULT NULL
)

ALTER TABLE [oauth_access_tokens] ALTER COLUMN expires DATETIME;

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[saml_assertions]') AND type in (N'U'))
BEGIN
    CREATE TABLE [saml_assertions](
      [id] [int] IDENTITY(1, 1) NOT NULL,
      [assertion_id] [nvarchar](100) NOT NULL,
      [expires_at] DATETIME2(6) NOT NULL,
      PRIMARY KEY ([id])
    );
    CREATE INDEX [ix_saml_assertions_assertion_id] ON [saml_assertions] ([assertion_id]);
END;

-- TR-1917 --
ALTER TABLE oauth_clients ALTER COLUMN redirect_uri VARCHAR (500) NULL;

CREATE INDEX [oauth_clients_client_id_client_secret_redirect_uri_index] ON [oauth_clients] ([client_id], [client_secret], [redirect_uri]);

ALTER TABLE oauth_access_tokens ALTER COLUMN access_token VARCHAR (400) NOT NULL;

CREATE INDEX [oauth_access_tokens_access_token_expires_index] ON [oauth_access_tokens] ([access_token], [expires]);

CREATE INDEX [oauth_connection_tokens_user_id_access_token_oauth_server_region_refresh_token_index] ON [oauth_connection_tokens] ([user_id], [access_token], [oauth_server_region], [refresh_token]);

ALTER TABLE oauth_authorization_codes ALTER COLUMN authorization_code VARCHAR (400) NOT NULL;

ALTER TABLE oauth_authorization_codes ALTER COLUMN redirect_uri VARCHAR (500) NULL;

CREATE INDEX [oauth_authorization_codes_authorization_code_user_id_index] ON [oauth_authorization_codes] ([authorization_code], [user_id]);

ALTER TABLE oauth_refresh_tokens ALTER COLUMN refresh_token VARCHAR (400) NOT NULL;

CREATE INDEX [oauth_refresh_tokens_refresh_token_created_on_user_id_index] ON [oauth_refresh_tokens] ([refresh_token], [created_on], [user_id]);

-- TR-1922 --
CREATE INDEX [entity_attachments_attachment_id_entity_id_index] ON [entity_attachments] ([attachment_id], [entity_id]);

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[email_notification_template]') AND type in (N'U'))
DROP TABLE [email_notification_template];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'email_notification_template')
BEGIN
CREATE TABLE email_notification_template (
    [id] INT NOT NULL IDENTITY,
    [email_template] VARCHAR(255) NOT NULL,
    [email_template_subject] VARCHAR(255) NOT NULL,
    [email_template_body] VARCHAR(max) NOT NULL,
    PRIMARY KEY (id)
)
END

ALTER TABLE [email_notification_template] ALTER COLUMN [email_template_subject] TEXT;

-- PLA-142 --
CREATE INDEX [email_notification_template_index] ON [email_notification_template] ([email_template]);

-- PEN-1 --
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[pendo_data]') AND type in (N'U'))
DROP TABLE [pendo_data];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'pendo_data')
CREATE TABLE [pendo_data] (
  [id] [int] IDENTITY(1, 1) NOT NULL,
  [data] [varchar](max),
  [processed] [smallint] DEFAULT 0,
  PRIMARY KEY ([id])
);

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[pendo_auth]') AND type in (N'U'))
DROP TABLE [pendo_auth];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'pendo_auth')
CREATE TABLE [pendo_auth] (
  [name] [varchar](80),
  [value] [varchar](2048),
);

CREATE UNIQUE NONCLUSTERED INDEX [ux_pendo_auth_name] ON [pendo_auth]
(
 [name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY];

-- TR-2269 --
CREATE INDEX [ix_entity_id_and_entity_type_id] ON [entity_attachments] ([entity_id], [entity_type_id]);

ALTER TABLE users ADD is_sso_enabled INT DEFAULT(0);

ALTER TABLE user_logins ADD current_auth VARCHAR (10) NOT NULL DEFAULT 'local';

ALTER TABLE users ADD is_fallback_password_set INT DEFAULT (1);

CREATE TABLE [phinxlog]
(
	[version]                 bigint        PRIMARY KEY NOT NULL IDENTITY,
	[migration_name]          nvarchar(100) NOT NULL,
	[start_time]              datetime,
	[end_time]                datetime,
	[breakpoint]              smallint      DEFAULT 0
);

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[shared_steps]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [shared_steps]
    (
        [id]                      int           IDENTITY(1, 1) NOT NULL,
        [project_id]              int           NOT NULL,
        [title]                   nvarchar(250) NOT NULL,
        [created_on]              int           NOT NULL,
        [updated_on]              int           NOT NULL,
        [created_by]              int           NOT NULL,
        [updated_by]              int           NOT NULL
    );
    CREATE INDEX [shared_steps_project_id_index] ON [shared_steps] ([project_id]);
END;

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[shared_step_elements]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [shared_step_elements]
    (
        [id]                      int           IDENTITY(1, 1) NOT NULL,
        [shared_step_id]          int           NOT NULL,
        [display_order]           int           NOT NULL,
        [content]                 nvarchar(max),
        [additional_info]         nvarchar(max),
        [expected]                nvarchar(max),
        [refs]                    nvarchar(250),
        [created_on]              int           NOT NULL,
        [updated_on]              int           NOT NULL
    );
    CREATE INDEX [shared_step_elements_shared_step_id_index] ON [shared_step_elements] ([shared_step_id]);
END;

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[cases_shared_steps]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [cases_shared_steps]
    (
        [id]                      int           IDENTITY(1, 1) NOT NULL,
        [case_id]                 int           NOT NULL,
        [shared_step_id]          int           NOT NULL,
        [created_on]              int           NOT NULL,
        [updated_on]              int           NOT NULL
    );
    CREATE INDEX [cases_shared_steps_case_id_index] ON [cases_shared_steps] ([case_id]);
    CREATE INDEX [cases_shared_steps_shared_step_id_index] ON [cases_shared_steps] ([shared_step_id]);
END;

-- WP1-3 --
IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[case_statuses]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [case_statuses]
    (
        [id]                      int           IDENTITY(1, 1) NOT NULL,
        [name]                    nvarchar(250) NOT NULL,
        [short_name]              nvarchar(100),
        [display_order]           [int]         NOT NULL,
        [is_system]               [int]         NOT NULL,
        [is_approved]             [bit]         NOT NULL,
        [is_default]              [bit]         NOT NULL
    );
END;

-- TR-2545 --
CREATE INDEX [ix_milestone_id] ON [cases] ([milestone_id]);

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[case_comments]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [case_comments]
    (
        [id]                      int           IDENTITY(1, 1) NOT NULL,
		[case_id]                 int           NOT NULL,
		[change_id]               int           NOT NULL,
		[user_id]                 int           NOT NULL,
		[created_on]              int           NOT NULL,
        [comment]                 nvarchar(max)
    );
END;

CREATE INDEX [ix_case_id_and_change_id] ON [case_comments] ([case_id], [change_id]);

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[shared_step_changes]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [shared_step_changes]
    (
        [id]                      int           IDENTITY(1, 1) NOT NULL,
        [shared_step_id]          int           NOT NULL,
        [version]                 int           NOT NULL,
        [type_id]                 int           NOT NULL,
        [created_on]              int           NOT NULL,
        [updated_by]              int           NOT NULL,
        [changes]                 nvarchar(max)
    );
END;

CREATE INDEX [ix_shared_step_changes_shared_step_id] ON [shared_step_changes] ([shared_step_id]);

IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[message_queue]') AND type in (N'U'))
DROP TABLE [message_queue];

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=N'message_queue')
CREATE TABLE [message_queue] (
  [id] [int] IDENTITY(1, 1) NOT NULL,
  [message_id] [varchar](250),
  [data] [nvarchar](max),
  [processed] [smallint] DEFAULT 0,
  PRIMARY KEY ([id])
);

CREATE INDEX [ix_message_queue_message_id] ON [message_queue] ([message_id]);

--- Oauth & Open ID---

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sso_settings_oauth]') AND type in (N'U'))
BEGIN
CREATE TABLE [sso_settings_oauth](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sso_configuration] varchar(250) NOT NULL,
	[oauth_client_id] varchar(250),
	[oauth_client_secret] varchar(250),
	[oauth_issuer_uri] varchar(250),
	[oauth_user_auth_uri] varchar(250),
	[oauth_user_info_uri] varchar(250),
	[oauth_create_account_on_first_login] int DEFAULT 1,
	[oauth_whitelist_domains] TEXT,
	[oauth_sso_url] varchar(250),
 CONSTRAINT [PK_sso_settings_oauth] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[sso_settings_oauth]') AND name = N'ux_sso_configuration_oauth')
CREATE UNIQUE NONCLUSTERED INDEX [ux_sso_configuration_oauth] ON [sso_settings_oauth]
(
	[sso_configuration] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

SET ANSI_NULLS ON

SET QUOTED_IDENTIFIER ON

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[sso_settings_openid]') AND type in (N'U'))
BEGIN
CREATE TABLE [sso_settings_openid](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sso_configuration] varchar(250) NOT NULL,
	[client_id] varchar(250),
	[client_secret] varchar(250),
	[issuer_uri] varchar(250),
	[openid_create_account_on_first_login] int DEFAULT 1,
	[whitelist_domains] TEXT,
	[sso_url] varchar(250),
 CONSTRAINT [PK_sso_settings_openid] PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
END

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[sso_settings_openid]') AND name = N'ux_sso_configuration_openid')
CREATE UNIQUE NONCLUSTERED INDEX [ux_sso_configuration_openid] ON [sso_settings_openid]
(
	[sso_configuration] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]

ALTER TABLE [user_logins] ADD [mfa_attempts] INT DEFAULT 0;

ALTER TABLE [user_logins] ADD [mfa_updated_on] INT DEFAULT 0;

ALTER TABLE [users] ADD [is_mfa_enabled] INT DEFAULT 0;
ALTER TABLE [users] ADD [auth_app_connected] INT DEFAULT 0;
ALTER TABLE [users] ADD [mfa_secret] VARCHAR(255);

-- WP1-3 --
IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[webhooks]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [webhooks]
    (
        [id]               INT          NOT NULL IDENTITY(1,1) PRIMARY KEY,
        [hook_id]          VARCHAR(max) NOT NULL,
        [webhook_name]     VARCHAR(max) NOT NULL,
        [payload_url]      VARCHAR(max) NOT NULL,
        [method]           VARCHAR(6)   NOT NULL,
        [content_type]     VARCHAR(50)  NOT NULL,
        [request_headers]  VARCHAR(max) NULL,
        [request_payload]  VARCHAR(max) NULL,
        [response_headers] VARCHAR(max) NULL,
        [response_payload] VARCHAR(max) NULL,
        [secret]           VARCHAR(50)  NULL,
        [events]           VARCHAR(max) NOT NULL,
        [projects]         TINYINT NOT  NULL,
        [active]           TINYINT NOT  NULL,
        [user_id]          INT          NOT NULL,
        [created_at]       DATETIME2    NOT NULL  DEFAULT CURRENT_TIMESTAMP,
        [updated_at]       DATETIME2    NOT NULL  DEFAULT CURRENT_TIMESTAMP,
        [attempt]          INT          NOT NULL  DEFAULT 0,
        [retry_at]         INT          NOT NULL  DEFAULT 0
    );
END;

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[webhook_deliveries]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [webhook_deliveries]
    (
        [id]               INT          NOT NULL IDENTITY(1,1) PRIMARY KEY,
        [delivery_id]      VARCHAR(50)  NOT NULL,
        [hook_id]          VARCHAR(50)  NOT NULL,
        [user_id]          INT          NOT NULL,
        [request_headers]  VARCHAR(max) NOT NULL,
        [request_payload]  VARCHAR(max) NOT NULL,
        [response_headers] VARCHAR(max) NOT NULL,
        [response_payload] VARCHAR(max) NOT NULL,
        [state]            VARCHAR(3)   NOT NULL,
        [created_at]       DATETIME2    NOT NULL  DEFAULT CURRENT_TIMESTAMP ,
        [updated_at]       DATETIME2    NOT NULL  DEFAULT CURRENT_TIMESTAMP
    );
END;

IF NOT EXISTS(SELECT *
              FROM sys.objects
              WHERE object_id = OBJECT_ID(N'[webhook_projects]')
                AND type in (N'U'))
BEGIN
    CREATE TABLE [webhook_projects]
    (
        [id]         INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
        [hook_id]    INT NOT NULL,
        [project_id] INT NOT NULL
    );
END;
