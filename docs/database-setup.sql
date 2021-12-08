-- Create empty database ready for migrations
-- DESTRUCTIVE, run once for new environment setup

DROP DATABASE IF EXISTS treq;
CREATE DATABASE treq;

-- Generate a password and update the local .env file
CREATE USER 'treq'@'localhost' IDENTIFIED BY 'Generated_Environment_Password';
GRANT ALL PRIVILEGES ON treq.* to 'treq'@'localhost';
GRANT SELECT ON shared.* TO 'treq'@'localhost';

FLUSH PRIVILEGES;
QUIT;
