/*
 * Provide configuration values for `stages` table
 * This has been added to the `stages` migration for future installs
 */

INSERT INTO stages (name, task_type, created_at, updated_at) VALUES
('Budget Approval', 'budget', now(), now()),
('Canceled', null, now(), now()),
('Creating', null, now(), now()),
('Department Approval', 'department', now(), now()),
('Enter in Ariba', 'ariba', now(), now()),
('Assign Fiscal Contact', null, now(), now()),
('Needs Approval', 'approval', now(), now()),
('Pending Task', 'task', now(), now()),
('Place Order', 'order', now(), now()),
('Re-Submitted', 'resubmit', now(), now()),
('Sent Back', null, now(), now()),
('Unassigned', null, now(), now());
