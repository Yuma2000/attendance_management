drop database attendance_managementdb; //ここはエラーでもOK
create database attendance_managementdb character set utf8 collate utf8_general_ci;
use attendance_managementdb;
drop user sample@localhost; //ここはエラーでもOK
CREATE USER 'sample'@'localhost' IDENTIFIED BY 'password';
grant all privileges ON attendancedb.* TO 'sample'@'localhost';
-- DROP TABLE kindergarteners;//ここはエラーでもOK
-- データベース作成後、ここ以降のSQL文を実行
CREATE TABLE children(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
 	PRIMARY KEY(id)
	);

CREATE TABLE records(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
 	child_id MEDIUMINT UNSIGNED NOT NULL,
 	date DATE,
	status TINYINT(4),
	absence_reason VARCHAR(128),
 	PRIMARY KEY(id),
	FOREIGN KEY (child_id) REFERENCES children(id)
	);

CREATE TABLE childminders(
	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
 	PRIMARY KEY(id)
	);

CREATE TABLE replies(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	recode_id MEDIUMINT UNSIGNED NOT NULL,
	minder_id MEDIUMINT UNSIGNED NOT NULL,
	content VARCHAR(128),
 	PRIMARY KEY(id),
	FOREIGN KEY (recode_id) REFERENCES records(id),
	FOREIGN KEY (minder_id) REFERENCES childminders(id)
	);


insert into children values (1, 'いとう あいか');
insert into children values (2, 'いとう はると');
insert into children values (3, 'いのうえ みさと');
insert into children values (4, 'かとう ゆうま');
insert into children values (5, 'きむら こうき');
insert into children values (6, 'ささき そうた');
insert into children values (7, 'さとう たろう');
insert into children values (8, 'すずき さくら');
insert into children values (9, 'たかはし ゆうな');
insert into children values (10, 'たなか けんじ');
insert into children values (11, 'たむら さくら');
insert into children values (12, 'なかがわ りえ');
insert into children values (13, 'なかむら なおみ');
insert into children values (14, 'まつもと たけし');
insert into children values (15, 'みやざき さわこ');
insert into children values (16, 'やまぐち しんじ');
insert into children values (17, 'やまだ みなこ');
insert into children values (18, 'よしだ ゆうた');
insert into children values (19, 'わたなべ ゆきこ');
insert into children values (20, 'わたべ はるか');

insert into childminders values (1, '鈴木 たけし');
insert into childminders values (2, '田村 えりこ');
insert into childminders values (3, '中野 ゆかり');
insert into childminders values (4, '山田 みさき');

insert into records values (1, 1, now(), 2, '発熱（38度５分）のためお休みします。');
insert into records values (2, 11, now(), 2, '体調不良のためお休みします。');
insert into records values (3, 15, now(), 1,'出席');