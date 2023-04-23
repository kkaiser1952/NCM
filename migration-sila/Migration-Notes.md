Can't create or update target table:
CREATE TABLE ncm.events (
	dttm VARCHAR(50) NULL,
	id INTEGER NULL,
	title VARCHAR(128) NULL,
	description VARCHAR(16384) NULL,   <<<<=============
	location VARCHAR(64) NULL,
	contact VARCHAR(50) NULL,
	callsign VARCHAR(50) NULL,
	email VARCHAR(50) NULL,
	url VARCHAR(50) NULL,
	`start` VARCHAR(50) NULL,
	`end` VARCHAR(50) NULL,
	`domain` VARCHAR(50) NULL,
	docType VARCHAR(50) NULL,
	deletedBY VARCHAR(50) NULL,
	deletedON VARCHAR(50) NULL,
	netkind VARCHAR(50) NULL,
	eventDate VARCHAR(50) NULL,
	subdomain VARCHAR(50) NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

  SQL Error [1074] [42000]: Column length too big for column 'description' (max = 16383); use BLOB or TEXT instead
  SQL Error [1074] [42000]: Column length too big for column 'description' (max = 16383); use BLOB or TEXT instead
    Column length too big for column 'description' (max = 16383); use BLOB or TEXT instead
    Column length too big for column 'description' (max = 16383); use BLOB or TEXT instead




CREATE TABLE ncm.events (
	dttm VARCHAR(50) NULL,
	id INTEGER NULL,
	title VARCHAR(128) NULL,
	description VARCHAR(16383) NULL,
	location VARCHAR(64) NULL,
	contact VARCHAR(50) NULL,
	callsign VARCHAR(50) NULL,
	email VARCHAR(50) NULL,
	url VARCHAR(50) NULL,
	`start` VARCHAR(50) NULL,
	`end` VARCHAR(50) NULL,
	`domain` VARCHAR(50) NULL,
	docType VARCHAR(50) NULL,
	deletedBY VARCHAR(50) NULL,
	deletedON VARCHAR(50) NULL,
	netkind VARCHAR(50) NULL,
	eventDate VARCHAR(50) NULL,
	subdomain VARCHAR(50) NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

SQL Error [1406] [22001]: Data truncation: Data too long for column 'url' at row 269
  Data truncation: Data too long for column 'url' at row 269
  Data truncation: Data too long for column 'url' at row 269

value: https://sites.google.com/view/digitalnetemcommrum/emcomm-rum/red-de-trfico
changed "url" to 100


NetKind:
data in row1 too long...change width from 500 to 1000

-- ncm.NetKind definition

CREATE TABLE `NetKind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `org` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `orgType` varchar(20) NOT NULL,
  `dflt_kind` int(11) DEFAULT NULL,
  `kindofnet` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dflt_freq` int(11) DEFAULT NULL,
  `freq` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_call` varchar(12) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_email` varchar(50) NOT NULL,
  `org_web` varchar(100) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `row1` varchar(1000) NOT NULL,
  `row2` varchar(1000) NOT NULL,
  `row3` varchar(1000) NOT NULL,
  `row4` varchar(1000) NOT NULL,
  `row5` varchar(1000) NOT NULL,
  `row6` varchar(1000) NOT NULL,
  `box4` varchar(1000) NOT NULL,
  `box5` varchar(1000) NOT NULL,
  `columnViews` varchar(75) NOT NULL,
  `zipcode` varchar(10) NOT NULL COMMENT 'for wx report',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=latin1;

output:
Integer display width is deprecated and will be removed in a future release.
'utf8' is currently an alias for the character set UTF8MB3, but will be an alias for UTF8MB4 in a future release. Please consider using UTF8MB4 in order to be unambiguous.
'utf8mb3_unicode_ci' is a collation of the deprecated character set UTF8MB3. Please consider using UTF8MB4 with an appropriate collation instead.
'utf8' is currently an alias for the character set UTF8MB3, but will be an alias for UTF8MB4 in a future release. Please consider using UTF8MB4 in order to be unambiguous.
'utf8mb3_unicode_ci' is a collation of the deprecated character set UTF8MB3. Please consider using UTF8MB4 with an appropriate collation instead.
Integer display width is deprecated and will be removed in a future release.
'utf8' is currently an alias for the character set UTF8MB3, but will be an alias for UTF8MB4 in a future release. Please consider using UTF8MB4 in order to be unambiguous.
'utf8mb3_unicode_ci' is a collation of the deprecated character set UTF8MB3. Please consider using UTF8MB4 with an appropriate collation instead.
Integer display width is deprecated and will be removed in a future release.
'utf8' is currently an alias for the character set UTF8MB3, but will be an alias for UTF8MB4 in a future release. Please consider using UTF8MB4 in order to be unambiguous.
'utf8mb3_unicode_ci' is a collation of the deprecated character set UTF8MB3. Please consider using UTF8MB4 with an appropriate collation instead.
