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
	class VARCHAR(128),
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
	record_id MEDIUMINT UNSIGNED NOT NULL,
	minder_id MEDIUMINT UNSIGNED NOT NULL,
	content VARCHAR(128),
 	PRIMARY KEY(id),
	FOREIGN KEY (recode_id) REFERENCES records(id),
	FOREIGN KEY (minder_id) REFERENCES childminders(id)
	);


insert into children values (1, 'いとう あいか', 'ひまわり');
insert into children values (2, 'いとう はると', 'ばら');
insert into children values (3, 'いのうえ みさと', 'たんぽぽ');
insert into children values (4, 'かとう ゆうま', 'ひまわり');
insert into children values (5, 'きむら こうき', 'ばら');
insert into children values (6, 'ささき そうた', 'たんぽぽ');
insert into children values (7, 'さとう たろう', 'ひまわり');
insert into children values (8, 'すずき さくら', 'ばら');
insert into children values (9, 'たかはし ゆうな', 'たんぽぽ');
insert into children values (10, 'たなか けんじ', 'ひまわり');
insert into children values (11, 'たむら さくら', 'ばら');
insert into children values (12, 'なかがわ りえ', 'たんぽぽ');
insert into children values (13, 'なかむら なおみ', 'ひまわり');
insert into children values (14, 'まつもと たけし', 'ばら');
insert into children values (15, 'みやざき さわこ', 'たんぽぽ');
insert into children values (16, 'やまぐち しんじ', 'ひまわり');
insert into children values (17, 'やまだ みなこ', 'ばら');
insert into children values (18, 'よしだ ゆうた', 'たんぽぽ');
insert into children values (19, 'わたなべ ゆきこ', 'ひまわり');
insert into children values (20, 'わたべ はるか', 'ばら');
insert into children values (21, 'さとう ゆうた', 'たんぽぽ');
insert into children values (22, 'きのした りょう', 'ひまわり');
insert into children values (23, 'よしだ ゆうた', 'ばら');

insert into childminders values (1, '鈴木 たけし');
insert into childminders values (2, '田村 えりこ');
insert into childminders values (3, '中野 ゆかり');
insert into childminders values (4, '山田 みさき');

insert into records values (1, 1, now(), 2, '発熱（38度５分）のためお休みします。');
insert into records values (2, 11, now(), 2, '体調不良のためお休みします。');
insert into records values (3, 15, now(), 1,'');
insert into records values (4, 5, now(), 1,'');
insert into records values (5, 1, '2023-08-22', 1,'');
insert into records values (6, 1, '2023-08-23', 2,'昨晩からの熱で今日は休ませます。');
insert into records values (7, 1, '2023-08-24', 2,'今日もお休みさせていただきます。');
insert into records values (8, 1, '2023-08-25', 1,'');
insert into records values (9, 1, '2023-08-26', 2,'咳が出るので休ませます。');
insert into records values (10, 1, '2023-06-26', 1,'');
insert into records values (11, 1, '2023-06-27', 1,'');
insert into records values (12, 1, '2023-06-28', 1,'');
insert into records values (13, 1, '2023-06-29', 1,'');
insert into records values (14, 1, '2023-06-30', 1,'');
insert into records values (15, 1, '2023-07-03', 2,'風邪なのでお休みさせます。');
insert into records values (16, 1, '2023-07-04', 2,'昨日からの風邪で今日も休みです。');
insert into records values (17, 1, '2023-07-05', 1,'');
insert into records values (18, 1, '2023-07-06', 1,'');
insert into records values (19, 1, '2023-07-07', 1,'');
insert into records values (20, 1, '2023-07-10', 1,'');
insert into records values (21, 1, '2023-07-11', 2,'今日はお休みです。');
insert into records values (22, 1, '2023-07-12', 1,'');
insert into records values (23, 1, '2023-07-13', 2,'今日はお休みです。');
insert into records values (24, 1, '2023-07-14', 1,'');
insert into records values (25, 1, '2023-07-17', 1,'');
insert into records values (26, 1, '2023-07-18', 2,'熱があるので病院に連れて行くので、休みます。');
insert into records values (27, 1, '2023-07-19', 1,'');
insert into records values (28, 1, '2023-07-20', 1,'');
insert into records values (29, 1, '2023-07-21', 2,'体調不良で休ませます。');
insert into records values (30, 1, '2023-07-24', 1,'');
insert into records values (31, 1, '2023-07-25', 1,'');
insert into records values (32, 1, '2023-07-26', 1,'');
insert into records values (33, 1, '2023-07-27', 2,'熱があるので休ませます。');
insert into records values (34, 1, '2023-07-28', 1,'');
insert into records values (35, 1, '2023-07-31', 2,'風邪でお休みします。');
insert into records values (36, 1, '2023-08-01', 1,'');