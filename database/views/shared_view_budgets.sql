CREATE OR REPLACE VIEW __DBSHARED__.budgets AS

SELECT `b`.`id` AS `budget_id`,`b`.`biennium` AS `biennium`,`b`.`budgetno` AS `budgetno`,`b`.`BudgetNbr` AS `edw_budgetno`,`b`.`name` AS `name`,
if(`b`.`business_person_id`,concat(`b`.`name`,' (',`p`.`lastname`,')'),`b`.`name`) AS `name_pi`,`b`.`business_person_id` AS `business_person_id`,`b`.`pi_person_id` AS `pi_person_id`,`b`.`fiscal_person_id` AS `fiscal_person_id`,`b`.`OrgCode` AS `org_code`,`b`.`purpose_brief` AS `purpose_brief`
from (__DBBUDGETS__.`budget_biennium_view` `b` left join __DBSHARED__.`uw_persons` `p` on(`b`.`business_person_id` = `p`.`person_id`))