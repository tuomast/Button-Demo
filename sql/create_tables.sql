CREATE TABLE Account(
	id SERIAL PRIMARY KEY,
    email varchar(255) NOT NULL,
	password varchar(50) NOT NULL,
	first_name varchar(255),
    last_name varchar(255),
	phone_number varchar(20)
);

CREATE TABLE Payment(
	id SERIAL PRIMARY KEY,
	account_id INTEGER REFERENCES Account(id),
	amount INTEGER,

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

	/* for achievements with multiple levels. Example: share 5
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