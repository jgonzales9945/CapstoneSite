create table if not exists about (
    id int unsigned not null auto_increment primary key,
	name varchar(100),
    information mediumtext,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_modified datetime not null
);

create table if not exists indexpage (
    id int unsigned not null auto_increment primary key,
	name varchar(100),
    information mediumtext,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_modified datetime not null
);

create table if not exists schools (
	id int unsigned not null auto_increment primary key,
	name varchar(50) not null,
    information mediumtext default null,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_added datetime not null,
	date_modified datetime not null
);

create table if not exists scholarships (
	id int unsigned not null auto_increment primary key,
	name varchar(100) not null,
	end_date datetime not null,
    information mediumtext default null,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_added datetime not null,
	date_modified datetime not null
);

create table if not exists internships (
	id int unsigned not null auto_increment primary key,
	name varchar(100) not null,
    start_date datetime default null,
    end_date datetime default null,
    information mediumtext default null,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_added datetime not null,
	date_modified datetime not null
);
create table if not exists organizations (
	id int unsigned not null auto_increment primary key,
	name varchar(50) not null,
	location varchar(100) not null,
    contact_information text default null,
    information mediumtext default null,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_added datetime not null,
	date_modified datetime not null
);
create table if not exists journals (
	id int unsigned not null auto_increment primary key,
	name varchar(100) not null,
	author varchar(150) not null,
	publisher varchar(150) not null,
	date_published datetime not null,
    information mediumtext default null,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_added datetime not null,
	date_modified datetime not null
);
create table if not exists calender (
	id int unsigned not null auto_increment primary key,
	name varchar(100) not null unique,
    start_date datetime default null,
    due_date datetime default null,
	frequency tinytext default null,
    priority boolean default false,
    information mediumtext default null,
	file_directory varchar(150) default null,
	hyper_links text default null,
	date_added datetime not null,
	date_modified datetime not null
);
create table if not exists login (
	id int unsigned not null auto_increment primary key,
	user_name varchar(20) not null unique,
	passwd varchar(25) not null unique,
	email varchar(50) not null unique,
);

create table if not exists login_attempts (
    id int not null,
	ip_address varchar(15),
    time varchar(30) not null
);