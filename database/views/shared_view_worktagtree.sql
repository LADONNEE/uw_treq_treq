CREATE OR REPLACE VIEW __DBSHARED__.worktagtree AS

SELECT `w`.`id` AS `worktag_id`,`w`.`workday_code` AS `workday_code`,
`w`.`name` AS `name`, __DBSHARED__.getpath(`w`.`id`) AS `tree` from __DBBUDGETS__.`worktags` `w` ORDER BY `tree` ASC;