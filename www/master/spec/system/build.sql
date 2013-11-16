create table accounts(
	id serial not null,
	first_name varchar(255) not null,
	last_name varchar(255) not null,
	password varchar(255) not null,
	email varchar(255) not null unique,
	address varchar(255),
	telephone int,
	level int not null,
	department int not null references departments(id),
	status int not null,
	comments varchar(255),
	ts int not null
);

create table departments(
	id serial not null,
	department varchar(255) unique
);

insert into departments (department) values ('None'),
									  		('Web'),
											('Managing Editor'),
											('Editor-in-Chief'),
											('Art'),
											('Sports'),
											('A&E'),
											('Photos'),
											('Features'),
											('Opinions'),
											('Copy'),
											('News'),
											('Layout'),
											('Business'),
											('Faculty Advisor');
	
create table spec_sessions (
	session_id varchar(40) default '0' not null,
	ip_address varchar(16) default '0' not null,
	user_agent varchar(50) not null,
	last_activity int default 0 not null,
	primary key (session_id)
);

create table articles(
	id serial not null,
	title varchar(255) not null,
	authors varchar(255) not null,
	photo int not null,
	photographers varchar(255),
	art int not null,
	artists varchar(255),
	lede int not null,
	word_count int not null,
	department int not null,
	comments varchar(255) not null,
	issue int not null references issue(num_issue),
	status int not null,
	ts int not null,
	modify_user_id int not null references accounts(id)
);
create table article_revisions (
	id serial not null,
	article_id int not null references pasteup(id),
	text text not null,
	ts int not null,
	modify_user_id int not null references accounts(id)
);
create table issue(
	id serial not null,
	num_issue int unique not null,
	comment varchar(255) not null,
	ts int not null);
create table photos(
	id serial not null,
	article_id int not null references articles(id),
	issue_id int not null references issue(num_issue),
	image varchar(255) not null,
	creator_id int not null,
	caption varchar(255) not null,
	comment varchar(255) not null,
	ts int not null);
