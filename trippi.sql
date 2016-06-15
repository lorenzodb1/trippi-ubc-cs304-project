use DB_trippi;
-- use testing_DB;
-- SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS user CASCADE;
DROP TABLE IF EXISTS admin CASCADE;
DROP TABLE IF EXISTS trip CASCADE;
DROP TABLE IF EXISTS trip_duration CASCADE;
DROP TABLE IF EXISTS plan CASCADE;
DROP TABLE IF EXISTS travelling_transportation CASCADE;
DROP TABLE IF EXISTS travelling_duration CASCADE;
DROP TABLE IF EXISTS joins CASCADE;
DROP TABLE IF EXISTS location CASCADE;
DROP TABLE IF EXISTS activity CASCADE;
DROP TABLE IF EXISTS accommodation CASCADE;

-- DROP TABLE user;
-- DROP TABLE admin;
-- DROP TABLE trip;
-- DROP TABLE trip_duration;
-- DROP TABLE plan;
-- DROP TABLE travelling_transportation;
-- DROP TABLE travelling_duration;
-- DROP TABLE joins;
-- DROP TABLE location;
-- DROP TABLE activity;
-- DROP TABLE accommodation;



create table user
	(email varchar(40) not null,
		username varchar(30) not null,
		password varchar(150) not null,
		name varchar(40) null,
		hometown varchar(40) null,
		country varchar(40) null,
		dateOfBirth date null,
		aboutMe varchar(140) null,
		rating int(1) null,
		primary key (email));

create table admin
	(email varchar(40) not null,
		primary key(email),
		foreign key (email) references user(email));


create table trip_duration
	(startDate date not null,
		endDate date not null,
		duration varchar(20) not null,
		primary key(startDate, endDate));

create table trip
	(tripId char(8) not null,
		startDate date not null,
		endDate date not null,
		status varchar(20) not null,
		tripName varchar(30) not null,
		startLocation varchar(30) null,
		primary key(tripId),
		foreign key(startDate, endDate) references trip_duration(startDate, endDate) on delete CASCADE );

create table plan
	(tripId char(8) not null,
		email varchar(40) not null,
		primary key(tripId, email),
		foreign key(tripId) references trip(tripId) on delete CASCADE ,
		foreign key(email) references admin(email) on delete CASCADE);

create table location
	(locationID char(8) not null,
		city varchar(40) null,
		country varchar(40) null,
		primary key(locationID));

create table travelling_duration
	(startDate date not null,
		endDate date not null,
		duration varchar(20) not null,
		primary key(startDate, endDate));



create table travelling_transportation
	(transportationID char(8) not null,
		from_locationID char(8) not null,
		to_locationID char(8) not null,
		tripID char(8) not null,
		startDate date not null,
		endDate date not null,
		cost int null,
		type varchar(40) not null,
		primary key(transportationID),
		foreign key(from_locationID) references location(locationID),
		foreign key(to_locationID) references location(locationID),
		foreign key(tripID) references trip(tripId),
		foreign key(startDate, endDate) references travelling_duration(startDate, endDate));

create table joins
	(tripId char(8) not null,
		email varchar(40) not null,
		primary key(tripId, email),
		foreign key(tripId) references trip(tripId),
		foreign key(email) references user(email));



create table activity
	(name varchar(40) not null,
		place varchar(40) null,
		adate date null,
		cost int null,
		locationID char(8) not null,
		primary key(name, place, locationID),
		foreign key(locationID) references location(locationID));

create table accomodation
	(name varchar(40) not null,
		type varchar(40) null,
		cost int null,
		rating int null,
		startDate date not null,
		endDate date not null,
		locationID char(8) not null,
		primary key (name, type, locationID),
		foreign key(locationID) references location(locationID));

CREATE TABLE userRating
  (emailRater varchar(40) not null,
    emailRated varchar(40) not null,
    rating int null,
    comment varchar(40),
    PRIMARY KEY (emailRater, emailRated),
    FOREIGN KEY (emailRater) REFERENCES user(email),
    FOREIGN KEY (emailRated) REFERENCES user(email));

CREATE TABLE tripRating
  (tripID char(8) not null,
    email varchar(40) not null,
    rating int null,
    comment varchar(40),
    PRIMARY KEY (tripID, email),
    FOREIGN KEY (tripID) REFERENCES trip(tripId),
    FOREIGN KEY (email) REFERENCES user(email));


insert into user
	values('bob@gmail.com', 'bobsmith', '$6$rounds=5000$bob@gmail.com$ajkpRTIRKd711I9aMbApgl8APZCnwgNRIWbVLj0aItHSjGv6NNY7FOl0aJP5c7hNAnFCFRyPBmdOSO5Wk1Ikj1', 'Bob Smith', 'Vancouver', 'Canada', '1995-09-12', 'I am cool', 4);

insert into user
	values('mary123@gmail.com', 'mary123', '$6$rounds=5000$mary123@gmail.co$iP07x/j8u1mxH1RvZGEgurFcR5OJ3NCaatWiDr/NH8ifVtFZ3LhvSLRaT219qaMLpjLjU4W04r75slzmqaUl41', 'Mary Jackson', 'Kelowna', 'Canada', '1990-04-09', 'I am cool', 3);

insert into user
	values('lalla@hotmail.com', 'lallala', '$6$rounds=5000$lalla@hotmail.co$6J6ryyboDg0QVrfgqWUNTBewnb9s5kcr8741nEG.GaSWwdAbYRDDvV7Rsn3EnyFIFHbRYa8SJhdjXYwzwvfVt/', 'Lalla Peterson', 'Rome', 'Italy', '1987-04-11', 'I am cool', 2);

insert into user
	values('johndavies@gmail.com', 'johnnyd', '$6$rounds=5000$johndavies@gmail$.9GdUdBFZtm3JZtU1XD5ZC1ngz9nDS1F/OnsgP3rvkpB4.Sr8hFFhdy4tl08DjHJwFys5L1HSiGTKEGNrhBpx1', 'John Davies', 'Paris', 'France', '1956-02-20', 'I am cool', 1);

insert into user
	values('garylee@gmail.com', 'glee', '$6$rounds=5000$garylee@gmail.co$zhjDgXC3fFPjN.G.GRIVrbCZKMW1R0Z6LyUzCKK4ITIuHjUs2acBUIsSaWMd0QmNiXaSREiFMC1r2NDkOrHS/0', 'Gary Lee', 'Victoria', 'Canada', '1971-07-13', 'I am cool', 5);

insert into user
	values('hsimpson@gmail.com', 'howardsimpson', '$6$rounds=5000$hsimpson@gmail.c$FjwMTVRxWnWkewYsP4YX7ftTH7qiZU5l0a/O836QKf7/S4BoodfOtU3TDUT6GnB7N8e9FtKR8/UljpOleYu2W0', 'Howard Simpson', 'Burnaby', 'Canada', '1978-06-21', 'I am cool', null);

insert into user
	values('cool.dude@gmail.com', 'cool786pson', '$6$rounds=5000$cool.dude@gmail.$sAexhZ.eAwYBfqxElvirL3ZypY96BnG6H2.uQilFagImfytYFukh9GNBZ271/.2HMf68S9w.P7EqSRj6KJN/l1', 'Cool dude', 'Winnipeg', 'Canada', '1980-06-22', 'I am cool', 4);

insert into user
	values('jeco@gmail.com', 'jecoIo', '$6$rounds=5000$jeco@gmail.com$qWaUQTNLlwPq6T6NpG0TSFiuxgTa0VucqbsxtTYa3xdYLfFiwAtOEUY3XanPjGSzACl13gXNUCdhDQfOk8S.Z.', 'Jeco Simpson', 'Whistler', 'Canada', '1972-08-21', 'I am cool', null);

insert into user
	values('pilo@gmail.com', 'piloCY', '$6$rounds=5000$pilo@gmail.com$Bvzj.8p9JXwhcK8qTr5e7yP7BL/BDzWJ5TPrZ6NHEsQvfLwuMfZs8RfeV9K0PWf85xSJhNpTxw/v4kUU4jf3Y0', 'Pilo Zes', 'Calgary', 'Canada', '1985-06-21', 'I am cool', null);

insert into user
	values('tuso@gmail.com', 'tuso82', '$6$rounds=5000$tuso@gmail.com$vN.PUOVGZsPTqJRwSdzb/QnkD7Rl6w1MhgBGcc9RauU.XguTCaXDb6.dqkvSVKWXe11i3npxPbAavhBv5tE/I0', 'Tuso Jelo', 'Edmonton', 'Canada', '1982-06-21', 'I am not cool', 1);

insert into admin
	values('bob@gmail.com');

insert into admin
	values('mary123@gmail.com');

insert into admin
	values('lalla@hotmail.com');

insert into admin
	values('johndavies@gmail.com');

insert into admin
	values('garylee@gmail.com');

insert into trip_duration
	values('2016-07-01', '2016-07-25', '24 days');

insert into trip_duration
	values('2013-03-02', '2016-03-09', '7 days');

insert into trip_duration
	values('2011-04-10', '2016-04-20', '10 days');

insert into trip_duration
	values('2016-12-08', '2016-12-28', '20 days');

insert into trip_duration
	values('2016-09-13', '2016-09-26', '13 days');

insert into trip_duration
	values('2015-01-09', '2016-01-29', '20 days');

insert into trip_duration
	values('2014-06-12', '2016-06-22', '10 days');

insert into trip_duration
	values('2016-10-11', '2016-10-19', '8 days');

insert into trip
	values('10000000', '2016-07-01', '2016-07-25', 'incomplete', 'Sweet Trip 1!', 'Washington D.C.');

insert into trip
	values('10000001', '2013-03-02', '2016-03-09', 'complete', 'Sweet Trip 2!', 'Toronto');

insert into trip
	values('10000002', '2011-04-10', '2016-04-20', 'complete', 'Sweet Trip 3!', 'Seattle');

insert into trip
	values('10000003', '2016-12-08', '2016-12-28', 'incomplete', 'Sweet Trip 4!', 'London');

insert into trip
	values('10000004', '2016-09-13', '2016-09-26', 'incomplete', 'Sweet Trip 5!', 'Venice');

insert into trip
	values('10000005', '2015-01-09', '2016-01-29', 'complete', 'Sweet Trip 6!', 'Aruba');

insert into trip
	values('10000006', '2014-06-12', '2016-06-22', 'complete', 'Sweet Trip 7!', 'Sydney');

insert into trip
	values('10000007', '2016-10-11', '2016-10-19', 'incomplete', 'Sweet Trip 8!', 'Vancouver');

insert into plan
	values('10000000','bob@gmail.com');

insert into plan
	values('10000001','bob@gmail.com');

insert into plan
	values('10000002','mary123@gmail.com');

insert into plan
	values('10000003','mary123@gmail.com');

insert into plan
	values('10000004','mary123@gmail.com');

insert into plan
	values('10000005','lalla@hotmail.com');

insert into plan
	values('10000006','johndavies@gmail.com');

insert into plan
	values('10000007','garylee@gmail.com');

insert into location
	values('1', 'Vancouver', 'Canada');

insert into location
	values('2', 'Rome', 'Italy');

insert into location
	values('3', 'Saskatoon', 'Canada');

insert into location
	values('4', 'Singapore', 'Singapore');

insert into location
	values('5', 'Medellin', 'Colombia');

insert into travelling_duration
	values('2016-07-08', '2016-07-09', "1 day");

insert into travelling_duration
	values('2016-07-18', '2016-07-20', "2 days");

insert into travelling_duration
	values('2016-12-14', '2016-12-20', "6 days");

insert into travelling_duration
	values('2016-12-23', '2016-12-25', "2 days");

insert into travelling_duration
	values('2016-10-11', '2016-10-13', "2 days");

insert into travelling_transportation
	values('1', '1', '2', '10000000', '2016-07-08', '2016-07-09', 1299, 'Flight');

insert into travelling_transportation
	values('2', '2', '5', '10000001', '2016-07-18', '2016-07-20', 2000, 'Flight');

insert into travelling_transportation
	values('3', '4', '1', '10000002', '2016-12-14', '2016-12-20', 10000, 'Boat');

insert into travelling_transportation
	values('4', '1', '3', '10000003', '2016-12-23', '2016-12-25', 3000, 'Car');

insert into travelling_transportation
	values('5', '5', '2', '10000004', '2016-10-11', '2016-10-13', 2000, 'Flight');

insert into joins
	values('10000000', 'hsimpson@gmail.com');
        
insert into joins
	values('10000001', 'cool.dude@gmail.com');
        
insert into joins
	values('10000002', 'jeco@gmail.com');
        
insert into joins
	values('10000003', 'pilo@gmail.com');
        
insert into joins
	values('10000002', 'tuso@gmail.com');

insert into activity
	values('colosseum', 'roma', '2016-07-10', '20', '2');

insert into activity
	values('grouse_mountain', 'vancouver', '2016-07-07', '10', '1');
        
insert into activity
	values('hiking', 'Saskatoon', '2016-12-24', '60', '3');

insert into activity
	values('clubbing', 'medellin', '2016-07-21', '30', '5');

insert into activity
	values('eating_noodles', 'singapore', '2016-12-25', '15', '4');
        
insert into accomodation
	values('hotel_hilton', 'hotel', '750', '5', '2016-07-09', '2016-07-18', '2');

insert into accomodation
	values('hotel_sheraton', 'hotel', '630', '4', '2016-07-05', '2016-07-8', '1');

insert into accomodation
	values('casa_estrella', 'hostel', '30', '3', '2016-07-20', '2016-10-11', '5');
        
insert into accomodation
	values('hostel_chung', 'hostel', '20', '2', '2016-12-20', '2016-12-13', '4');
        
insert into accomodation
	values('goose_house', 'bnb', '50', '3', '2016-12-25', '2016-12-28', '3');

insert into tripRating
	values('10000000', 'hsimpson@gmail.com', 6, 'love the places');

insert into tripRating
	values('10000001', 'cool.dude@gmail.com', 10, 'best time');

insert into tripRating
	values('10000002', 'jeco@gmail.com', 8, 'highly recommended');

insert into tripRating
	values('10000003', 'pilo@gmail.com', 3, 'scary times');

insert into tripRating
	values('10000002', 'tuso@gmail.com', 10, 'the best');


insert into userRating
	values('cool.dude@gmail.com', 'hsimpson@gmail.com', 6, 'cool');

insert into userRating
	values('hsimpson@gmail.com', 'cool.dude@gmail.com', 10, 'best friends');

insert into userRating
	values('pilo@gmail.com', 'jeco@gmail.com', 8, 'cool');

insert into userRating
	values('tuso@gmail.com', 'pilo@gmail.com', 3, 'ok');

insert into userRating
	values('pilo@gmail.com', 'tuso@gmail.com', 10, 'awesome');
















