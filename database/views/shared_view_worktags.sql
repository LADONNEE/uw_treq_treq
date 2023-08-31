CREATE OR REPLACE VIEW __DBSHARED__.worktags AS

SELECT `w`.`id` AS `worktag_id`,`w`.`workday_code` AS `workday_code`,`w`.`name` AS `name`,`w`.`fiscal_person_id` AS `fiscal_person_id`
from __DBBUDGETS__.`worktags` `w`;