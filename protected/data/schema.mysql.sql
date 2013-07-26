DROP DATABASE IF EXISTS fastvps_whmcs_testing;
CREATE DATABASE fastvps_whmcs_testing CHARACTER SET utf8 COLLATE utf8_general_ci;

USE fastvps_whmcs_testing;

CREATE TABLE tbl_rates (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	remote_id VARCHAR(254) NOT NULL,
	num_code VARCHAR(3) NOT NULL,
	char_code VARCHAR(3) NOT NULL,
	nominal INTEGER NOT NULL DEFAULT 1,
	name VARCHAR(254) NOT NULL,
	value FLOAT NOT NULL
);

CREATE TABLE tbl_selected_rates (
	char_code VARCHAR(3) PRIMARY KEY
);

INSERT INTO tbl_selected_rates (char_code) VALUES ('EUR'), ('USD'), ('UAH'), ('BYR');
