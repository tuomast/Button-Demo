CREATE TABLE Account(
	id SERIAL PRIMARY KEY,
    email varchar(255) NOT NULL,
	password varchar(50) NOT NULL,
	first_name varchar(255),
    last_name varchar(255),
	phone_number varchar(20),
	total_co2_tons_saved numeric(15, 4) DEFAULT 0,
	total_money_donated numeric(15, 2) DEFAULT 0
);

CREATE TABLE Payment(
	id SERIAL PRIMARY KEY,
	account_id INTEGER REFERENCES Account(id),
	amount numeric(15, 2),

	/* eg. 'monthly' for monthly payment*/
	recurring varchar(25) DEFAULT 'no',
	time_created timestamptz,
	time_last_paid timestamptz
);

CREATE TABLE Achievement(
	id SERIAL PRIMARY KEY,
	name varchar(200),
	description varchar(1000),
	logo_url varchar(500),

	/* for achievements with multiple levels. 5-level example: share 5
	times on social media to get this achievement*/
	levels INTEGER DEFAULT 1
);

CREATE TABLE Achievementaccount(
	account_id INTEGER REFERENCES Account(id),
	achievement_id INTEGER REFERENCES Achievement(id),
	current_level INTEGER,

	/* when achievement was fully unlocked*/
	timeachieved timestamptz
);

CREATE TABLE Globalstats(
	id SERIAL PRIMARY KEY,
	name varchar(200),
	value INTEGER DEFAULT 0
);