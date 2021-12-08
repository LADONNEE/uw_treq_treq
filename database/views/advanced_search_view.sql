CREATE OR REPLACE VIEW advanced_search_view AS
SELECT
  o.id AS order_id
  ,o.submitted_at
  ,p.title
  ,t.traveler
  ,t.depart_at
  ,t.return_at
  ,a.ref
  ,i.name AS item_name
  ,b.budgetno
  ,b.name AS budget_name
  ,b.pca_code
  ,CONCAT(
    project_owner.firstname, ' ',
    project_owner.lastname, ' ',
    project_owner.uwnetid
  ) AS project_owner
  ,CONCAT(
    order_submitter.firstname, ' ',
    order_submitter.lastname, ' ',
    order_submitter.uwnetid
  ) AS order_submitter
FROM orders o
INNER JOIN projects p
  ON o.project_id = p.id
INNER JOIN shared.uw_persons order_submitter
  ON o.submitted_by = order_submitter.person_id
LEFT OUTER JOIN trips t
  ON p.id = t.project_id
LEFT OUTER JOIN ariba a
  ON o.id = a.order_id
LEFT OUTER JOIN items i
  ON o.id = i.order_id
LEFT OUTER JOIN budgets b
  ON o.id = b.order_id
LEFT OUTER JOIN shared.uw_persons project_owner
  ON p.person_id = project_owner.person_id
WHERE o.submitted_at IS NOT NULL
  AND o.stage <> 'Canceled'
