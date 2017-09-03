CREATE TABLE Account(
	id SERIAL PRIMARY KEY,
	username varchar(80),
    email varchar(255) NOT NULL,
	password varchar(50) NOT NULL,
	firstname varchar(255),
    lastname varchar(255)
);