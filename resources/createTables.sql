CREATE TABLE threads(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(150),
	timeAdded DATETIME,
	username VARCHAR(20),
	topic_id INT NOT NULL
);
CREATE TABLE posts(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	thread_id INT NOT NULL,
	post TEXT,
	timeAdded DATETIME,
	username VARCHAR(20)
);
CREATE TABLE topics(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(35),
	description TEXT
);
CREATE TABLE users(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL,
	password VARCHAR(255) NOT NULL,
	email VARCHAR(60) NOT NULL,
	timeAdded DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE shop_categories(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(40) UNIQUE,
	image VARCHAR(50)
);

CREATE TABLE shop_items(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	cat_id INT NOT NULL,
	title VARCHAR(40),
	price FLOAT(6,2),
	detail TEXT,
	image VARCHAR(50),
	quantity SMALLINT
);

CREATE TABLE shoppingcart(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	session_id VARCHAR(32),
	item_id INT,
	item_qty SMALLINT,
	timeAdded DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id INT,
	timeAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
	bfirstname VARCHAR(20),
	blastname VARCHAR(30),
	bstreet VARCHAR(40),
	bsuburb VARCHAR(40),
	baus_state VARCHAR(30),
	bpostcode VARCHAR(4),
	email VARCHAR(60),
	bphone VARCHAR(20),
	total FLOAT(6,2),
	creditcard VARCHAR(255) NOT NULL,
	expiry CHAR(4),
	cvv CHAR(3),
	status ENUM('pending', 'complete'),
	firstname VARCHAR(20),
	lastname VARCHAR(30),
	street VARCHAR(40),
	suburb VARCHAR(40),
	aus_state VARCHAR(30),
	postcode VARCHAR(4),	
	phone VARCHAR(20),
	invoiceno VARCHAR(15)
);

CREATE TABLE orderItems(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	order_id INT NOT NULL,
	item_id INT NOT NULL,
	item_qty SMALLINT,
	item_price FLOAT(6,2)
);	

INSERT INTO shop_categories VALUES(1, "RPG books", "books.jpg");
INSERT INTO shop_categories VALUES(2, "Dice", "dice.jpg");
INSERT INTO shop_categories VALUES(3, "Miniatures", "miniatures.jpg");
INSERT INTO shop_categories VALUES(4, "Comics", "comics.jpg");
INSERT INTO shop_categories VALUES(5, "Board games", "boardgames.jpg");
INSERT INTO shop_categories VALUES(6, "Card games", "cardgames.jpg");

INSERT INTO shop_items VALUES(1, 1, "Vampire The Masquerade 1998",  30.00, "(Revised Edition). This is the 3rd edition 
									of Vampire: The Masquerade by White Wolf Publishing. It is the core rule book and 
									all you need to begin playing. Hard Cover with 294 pages. 2nd-hand, good condition.", "vampire_revised.jpg", 1);
INSERT INTO shop_items VALUES(2, 1, "Call of Cthulhu 6th Edition 2005",  30.00, "(Revised Edition). This is the 6th edition
									of Call of Cthulhu by Chaosium Inc. Paperback with 320 pages. It is the core rule book and 
									all you need to begin playing. 2nd-hand, good condition.", "cthulhu_6thedition.jpg", 1);
INSERT INTO shop_items VALUES(3, 1, "The Sassoon Files 2019", 30.00, "A sourcebook for the Call of Cthulhu and Gumshoe Role-playing games. 
									Published by the Sons of Singularity. 2 new copies generously donated from our friends overseas.", "sassoon.jpg", 2);
INSERT INTO shop_items VALUES(4, 3, "6 Rifts adventurers", 10.00, "2nd-hand unpainted miniatures for the Rifts RPG by Palladium.
									2 psi-stalkers, 2 ley-line walkers, 1 techno-wizard and 1 scout.", "miniatures.jpg", 1);
INSERT INTO shop_items VALUES(5, 3, "4 Rifts skelebots", 5.00, "2nd-hand unpainted miniatures for the Rifts RPG by Palladium. 4 skelebots with arms detached",  "skelebots.jpg", 2);	
INSERT INTO shop_items VALUES(6, 4, "Stray Bullets(S&R) 37", 7.00, "New condition. Stray Bullets (Sunshine & Roses) Number 37. August 2018. By El Capitan Books",  "sunshine37.jpg", 4);	
INSERT INTO shop_items VALUES(7, 4, "Lodger 4", 7.00, "New condition. Lodger Number 4. By Black Crown Publishing (another work by David Lapham). January 2019.",  "lodger4.jpg", 3);	
INSERT INTO shop_items VALUES(8, 4, "Lodger 5", 7.00, "New condition. Lodger Number 5. By Black Crown Publishing (another work by David Lapham). January 2019.",  "lodger5.jpg", 4);									
INSERT INTO shop_items VALUES(9, 5, "Wooden chess Set", 15.00, "2nd-hand wooden chess set. The board is hand made. All pieces there.",  "chessset.jpg", 1);	
INSERT INTO shop_items VALUES(10, 5, "Jenga", 15.00, "2nd-hand with original box. Jenga (1988 by Milton Bradley). All pieces there.",  "jenga.jpg", 1);	
INSERT INTO shop_items VALUES(11, 6, "Scrabble cards", 10.00, "Scrabble Cards. 1999 by Spears and Sons Ltd. 2nd-hand with rules. 
									A portable version of the classic Scrabble game. 92 Letter cards and 18 Letter cards. All cards there.",  "scrabblecards.jpg", 1);
INSERT INTO shop_items VALUES(12, 6, "Regular playing cards", 5.00, "Regular deck of playing cards (2nd-hand). Cards are made of clear plastic and have a hard plastic protective case. All cards there.",  "clearcards.jpg", 1);
INSERT INTO shop_items VALUES(13, 6, "Regular playing cards", 5.00, "Regular deck of playing cards (2nd-hand). Each card features a different dog on the face-side. All cards there.",  "dogcards.jpg", 1);
									
INSERT INTO topics VALUES (1, 	"General Discussion",
								"This section is for community discussions. Say hello, see who's online,
								ask questions and offer gaming advice. Please don't post here if you're 
								asking about events or the game-mechanics of a particular RPG.");
INSERT INTO topics VALUES (2, 	"RPGCentral Events",
								"This section is reserved for discussion about all events (upcoming and past)
								at our warehouse. To view times for all upcoming events, please go to our 
								<a href='events.html'>events</a> page");								
INSERT INTO topics VALUES (3, 	"Other Events in NSW",
								"This section is usually reserved for upcoming rpg conventions in NSW,
								including but not limited to:  Sydcon & Eyecon in Glebe, Ettincon in Blackheath,
								and Macquariecon at Macquarie University. Other NSW RPGs that are open to the public
								should also be discussed here.");
INSERT INTO topics VALUES (4, 	"Private NSW Games",
								"This section is reserved for anyone looking to host their own role-playing games
								or anyone looking to join a group (outside of RPG Central and inside NSW). Please
								don't share personal details like home addresses or phone numbers in the forum, you
								can pass these details out by private messaging.");
INSERT INTO topics VALUES (5, 	"Story Ideas",
								"We encourage RPGCentral users to share story ideas, campaign tips and character 
								ideas here. If they are for a specific role-playing game please use that particular
								forum topic. Also try not to leak spoilers for upcoming games.");
INSERT INTO topics VALUES (6, 	"Palladium RPGs",
								"This section is reserved for discussion about all Palladium games such as
								Rifts, TMNT & Other Strangeness, Heroes Unlimited and Nightspawn.");
INSERT INTO topics VALUES (7, 	"D&D / Pathfinder",
								"This section is reserved for discussion about D&D and Pathfinder games. For example
								disucssions could be about game-mechanics, new rule ideas, story ideas, or new races or classes.");
INSERT INTO topics VALUES (8, 	"Call of Cthulhu",
								"This section is reserved for discussion about the Call of Cthulhu RPG. For example
								disucssions could be about game-mechanics, new rule ideas, story ideas, or a new insanity table.");
INSERT INTO topics VALUES (9, 	"Vampire / Werewolf",
								"This section is reserved for discussion about Vampire, Werewolf, or other RPGs by Whitewolf. For example
								disucssions could be about game-mechanics, new rule ideas, story ideas, or character creation.");
INSERT INTO topics VALUES (10, 	"Star Wars",
								"This section is reserved for discussion about the Star Wars RPG. For example
								disucssions could be about game-mechanics, star-systems, story ideas, or new races");
INSERT INTO topics VALUES (11, 	"Other RPGs",
								"This section is reserved for discussion about any other RPGs not included in the other 
								forum topics. For example Cyberpunk, TOON, Nephilim, Fighting Fantasy, or any other RPGs.
								You are also welcome to post here about boardgames.");

	
	