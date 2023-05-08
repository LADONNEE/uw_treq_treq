CREATE OR REPLACE VIEW __DBSHARED__.budgets_biennium_setting AS

SELECT `b`.`name` AS `name`,`b`.`value` AS `value`
from __DBBUDGETS__.`settings` `b` where `b`.`name` = 'current-biennium'