--Create users table

CREATE TABLE IF NOT EXISTS users (
	user_id int(8) NOT NULL AUTO_INCREMENT,
	name varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	phone int(16),
	age int(3),
	PRIMARY KEY (user_id)
);

--Create roles table

CREATE TABLE IF NOT EXISTS roles (
	role_id int(8) NOT NULL AUTO_INCREMENT,
	role varchar(40) NOT NULL,
	create boolean NOT NULL default 0,
	read boolean NOT NULL default 0,
	update boolean NOT NULL default 0,
	delete boolean NOT NULL default 0,
	PRIMARY KEY (role_id)
);

--Create user_role table

CREATE TABLE IF NOT EXISTS user_role (
	user_id int(8) NOT NULL,
	role_id int(8) NOT NULL,
	PRIMARY KEY (user_id, role_id),
);
