create table departments(
	id serial not null unique,
	department_name varchar(255) unique
);

create table accounts(
	id serial not null unique,
	name varchar(255) not null,
	password varchar(255) not null,
	email varchar(255) not null unique,
	address varchar(255),
	telephone int,
	status int not null,
	grad_year int not null,
	is_staff int not null,
	ts int not null
);

create table dept_level(
	id serial not null unique,
	user_id int not null references accounts(id),
	department int not null references departments(id),
	level int not null,
	ts int not null
);

insert into departments (department_name) values ('None');
insert into departments (department_name) values ('Web');
insert into departments (department_name) values ('Managing Editor');
insert into departments (department_name) values ('Editor-in-Chief');
insert into departments (department_name) values ('Art');
insert into departments (department_name) values ('Sports' );
insert into departments (department_name) values ('A&E');
insert into departments (department_name) values ('Photos');
insert into departments (department_name) values ('Features');
insert into departments (department_name) values ('Opinions');
insert into departments (department_name) values ('Copy');
insert into departments (department_name) values ('News');
insert into departments (department_name) values ('Layout');
insert into departments (department_name) values ('Business');
insert into departments (department_name) values ('Faculty Advisor');
	
create table spec_sessions (
	session_id varchar(40) default '0' not null,
	ip_address varchar(16) default '0' not null,
	user_agent varchar(50) not null,
	last_activity int default 0 not null,
	primary key (session_id)
);

create table volumes (
	id serial not null unique,
	volume varchar(255) unique not null,
	comment varchar(255)
);


create table issues (
	id serial not null unique,
	issue_num int unique not null,
	volume int not null references volumes(id),
	comment varchar(255)
);

create table articles (
	id serial not null unique,
	title varchar(255) not null,
	photo int,
	art int,
	lead int,
	word_count int,
	department int not null,
	comments varchar(255),
	issue int not null references issues(issue_num),
	status int not null,
	type varchar(255),
	ts int not null
);

create table article_text (
	id serial not null,
	article_id int not null references articles(id),
	author int references accounts(id),
	author_name text,
	text text not null,
	text_styled text not null,
	status int not null,
	ts int not null
);

create table assignments (
	id serial not null unique,
	issue_num int not null references issues(issue_num),
	article_id int not null references articles(id),
	assigned_to int references accounts(id),
	title varchar(255) not null,
	department int not null references departments(id),
	details varchar(255) not null,
	status int not null
);

create table images (
	id serial not null,
	article_id int references articles(id),
	issue_id int references issues(issue_num),
	name varchar(255) not null,
	file_name varchar(255) not null,
	file_path varchar(255) not null,
	creator_id int not null,
	caption varchar(255),
	comment varchar(255),
	ts int not null
);

create table blogs (
	id serial not null unique,
	name varchar(255) not null,
	authors varchar(255) not null,
	ts int not null
);

create table blog_posts (
	id serial not null unique,
	blog_id int not null references blogs(id),
	title varchar(255) not null,
	author int not null references accounts(id),
	post text not null,
	post_styled text not null,
	status int not null,
	ts int not null
);