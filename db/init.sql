-- Foods Table --
CREATE TABLE foods (
  id            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  food          TEXT NOT NULL,
  food_type     TEXT NOT NULL,
  description   TEXT,
  price         TEXT NOT NULL
);

-- Foods table seed data --
INSERT INTO foods (id, food, food_type, description, price) VALUES (1, 'Oyako Don', 'Rice', 'Chicken, egg, and onions on top of rice', '9.5');
INSERT INTO foods (id, food, food_type, description, price) VALUES (2, 'Katsu Don', 'Rice', 'Fried breaded pork, onion, green onion, egg on top rice', '9.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (3, 'Fried Tofu Veggie Bowl', 'Rice', 'Rice bowl topped with fried tofu, avocado, carrots, broccoli, cauliflowers, mushroom, cabbage, and garlic.', '8.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (4, 'Buta Don', 'Rice', 'Rice bowl topped with pork and onion.', '9.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (5, 'Miso Ramen', 'Noodle',  'Ramen noodle in miso based soup, corn, egg, pork, bamboo shoot, and vegetables', '8.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (6, 'Tan Tan Men', 'Noodle', 'Ramen noodle, ground pork, Chinese mustard, green onion, chili oil, spicy spices.', '8.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (7, 'Karaage', 'Appetizer',  '4-5 pieces of fried chicken.', '3.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (8, 'Gyoza', 'Appetizer', 'Fried Pork Dumplings', '3.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (9, 'Green Tea Latte', 'Drink', NULL, '2.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (10, 'Coke', 'Drink', NULL, '1.85');
INSERT INTO foods (id, food, food_type, description, price) VALUES (11, 'Mango Cheese Cake', 'Dessert', NULL, '2.99');
INSERT INTO foods (id, food, food_type, description, price) VALUES (12, 'Tonkatsu Sauce', 'Sauce', '2oz cup size.', '0.75');



-- Entries Table --
CREATE TABLE entries (
  id            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  food          TEXT NOT NULL,
  description   TEXT NOT NULL,
  price         TEXT NOT NULL,
  file_ext      TEXT NOT NULL,
  citation      TEXT
);

-- Entries table seed data --
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (1, 'Oyako Don', 'Chicken, egg, and onions on top of rice', '9.5', 'jpeg', 'http://kitchenmisadventures.com/wp-content/uploads/2018/10/oyakodon-1.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (2, 'Katsu Don', 'Fried breaded pork, onion, green onion, egg on top rice', '9.99', 'jpeg', 'https://asianfoodnetwork.com/content/dam/afn/global/en/recipes/chicken-katsudon/AFN_chicken_katsudon_main_image1.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (3, 'Buta Don', 'Rice bowl topped with pork and onion.', '9.99', 'jpeg', 'https://www.bearnakedfood.com/wp-content/uploads/2014/09/DSC03168.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (4, 'Fried Tofu Veggie Bowl', 'Rice bowl topped with fried tofu, carrots, broccoli, cauliflowers, mushroom, bokchoy cabbage, and garlic.', '8.99', 'jpeg', 'https://colavitarecipes.com/wp-content/uploads/2019/03/SpringClean_Rice_01.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (5, 'Miso Ramen', 'Ramen noodle in miso based soup, corn, egg, pork, bamboo shoot, and vegetables', '8.99', 'png', 'https://gastroplant.com/wp-content/uploads/2019/06/1403_Vegan-Miso-Ramen_003.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (6, 'Tan Tan Men', 'Ramen noodle, ground pork, Chinese mustard, green onion, chili oil, spicy spices.', '8.99', 'jpeg', 'https://thewoksoflife.com/wp-content/uploads/2021/01/tan-tan-ramen-15.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (7, 'Karaage', '4-5 pieces of crispy fried chicken.', '3.99', 'jpeg', 'https://www.oyakata.com.pl/media/przepisy/karaage/kurczak-karaage.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (8, 'Gyoza', 'Fried Pork Dumplings', '3.99', 'jpeg', 'https://www.sunrise-soya.com/media/recipe_photos/SUNRISE_8249_HERO_Gyoza_HORIZ_1.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (9, 'Matcha Green Tea Latte', 'Smooth and creamy matcha sweetened just right and served with milk over ice.', '2.99', 'jpeg', 'https://www.organicauthority.com/.image/t_share/MTU5NDk1NTU4MDQwMzMxODY0/shutterstock_431091712.jpg');
INSERT INTO entries (id, food, description, price, file_ext, citation) VALUES (10, 'Mango Cheese Cake', 'Creamy cheese cake made with organic freshly diced mango.', '2.99', 'jpeg', 'https://www.thespruceeats.com/thmb/mlHrTVOS1gRrZ5j9f1zzpJoDt-c=/4494x2528/smart/filters:no_upscale()/mango-swirl-cheesecake-recipe-3217332-hero-01-ff3cfeeb66a84c8688bfc0009367e4af.jpg');




-- Tags Table --
CREATE TABLE tags (
  id      INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag     TEXT NOT NULL UNIQUE
);

-- Tags table seed data --
INSERT INTO tags (id, tag) VALUES (1, 'Rice');
INSERT INTO tags (id, tag) VALUES (2, 'Noodle');
INSERT INTO tags (id, tag) VALUES (3, 'Appetizer');
INSERT INTO tags (id, tag) VALUES (4, 'Drink');
INSERT INTO tags (id, tag) VALUES (5, 'Dessert');
INSERT INTO tags (id, tag) VALUES (6, 'Sauce');
INSERT INTO tags (id, tag) VALUES (7, 'Vegetarian');
INSERT INTO tags (id, tag) VALUES (8, 'Spicy');
INSERT INTO tags (id, tag) VALUES (9, 'Contains soup');




-- Entry_tags Table --
CREATE TABLE entry_tags (
  id       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  entry_id  INTEGER NOT NULL,
  tag_id   INTEGER NOT NULL,
  FOREIGN KEY (entry_id) REFERENCES foods(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);

-- Entry_tags table seed data --
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (1, 1, 1);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (2, 2, 1);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (3, 3, 1);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (4, 4, 1);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (5, 5, 2);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (6, 6, 2);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (7, 7, 3);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (8, 8, 3);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (9, 9, 4);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (10, 10, 5);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (11, 4, 7);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (12, 6, 8);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (13, 5, 9);
INSERT INTO entry_tags (id, entry_id, tag_id) VALUES (14, 6, 9);




-- Users Table --
CREATE TABLE users (
  id        INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name      TEXT NOT NULL,
  username  TEXT NOT NULL UNIQUE,
	password  TEXT NOT NULL
);

-- Users table seed data --
INSERT INTO users (id, name, username, password) VALUES (1, 'Andreas', 'andreas', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.');
-- password: monkey




-- Sessions Table --
CREATE TABLE sessions (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE,
  last_login   TEXT NOT NULL,

  FOREIGN KEY(user_id) REFERENCES users(id)
);




-- Groups --

CREATE TABLE groups (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL UNIQUE
);

INSERT INTO groups (id, name) VALUES (1, 'admin');




-- Group Membership --

CREATE TABLE memberships (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  group_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,

  FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO memberships (group_id, user_id) VALUES (1, 1); -- User 'andreas' is a member of the 'admin' group.
