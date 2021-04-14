-- Foods Table
CREATE TABLE foods (
  id            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  food          TEXT NOT NULL,
  description   TEXT,
  price         TEXT NOT NULL,
  file_ext      TEXT NOT NULL,
  citation      TEXT
);

-- Foods table seed data
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (1, 'Oyako Don',  'Chicken, egg, and onions on top of rice', '9.5', 'jpeg', 'www.justonecookbook.com/wp-content/uploads/2011/02/Oyakodon-w600-500x375.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (2, 'Katsu Don',  'Fried breaded pork, onion, green onion, egg on top rice', '9.99', 'jpeg', 'https://asianfoodnetwork.com/content/dam/afn/global/en/recipes/chicken-katsudon/AFN_chicken_katsudon_main_image1.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (3, 'Fried Tofu Veggie Bowl',  'Rice bowl topped with fried tofu, avocado, carrots, broccoli, cauliflowers, mushroom, cabbage, and garlic.', '8.99', 'jpeg', 'https://i1.wp.com/fullofplants.com/wp-content/uploads/2017/12/sweet-chili-tofu-bowls-with-avocado-and-rice-thumb-5.jpg?fit=1351%2C1351&ssl=1');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (4, 'Buta Don',  'Rice bowl topped with pork and onion.', '9.99', 'jpeg', 'https://www.bearnakedfood.com/wp-content/uploads/2014/09/DSC03168.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (5, 'Miso Ramen',  'Ramen noodle in miso based soup, corn, egg, pork, bamboo shoot, and vegetables', '8.99', 'png', 'https://gastroplant.com/wp-content/uploads/2019/06/1403_Vegan-Miso-Ramen_003.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (6, 'Tan Tan Men',  'Ramen noodle, ground pork, Chinese mustard, green onion, chili oil, spicy spices.', '8.99', 'jpeg', 'https://thewoksoflife.com/wp-content/uploads/2021/01/tan-tan-ramen-15.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (7, 'Karaage',  '4-5 pieces of fried chicken.', '3.99', 'jpeg', 'https://www.oyakata.com.pl/media/przepisy/karaage/kurczak-karaage.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (8, 'Gyoza',  'Fried Pork Dumplings', '3.99', 'jpeg', 'https://www.sunrise-soya.com/media/recipe_photos/SUNRISE_8249_HERO_Gyoza_HORIZ_1.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (9, 'Green Tea Latte',  NULL, '2.99', 'jpeg', 'https://www.organicauthority.com/.image/t_share/MTU5NDk1NTU4MDQwMzMxODY0/shutterstock_431091712.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (10, 'Coke',  NULL, '1.85', 'jpeg', 'https://imgix.lifehacker.com.au/content/uploads/sites/4/2014/08/shutterstock_196241660.jpg?ar=16%3A9&auto=format&fit=crop&q=80&w=1280&nr=20');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (11, 'Mango Cheese Cake',  NULL, '2.99', 'jpeg', 'https://www.thespruceeats.com/thmb/mlHrTVOS1gRrZ5j9f1zzpJoDt-c=/4494x2528/smart/filters:no_upscale()/mango-swirl-cheesecake-recipe-3217332-hero-01-ff3cfeeb66a84c8688bfc0009367e4af.jpg');
INSERT INTO foods (id, food, description, price, file_ext, citation) VALUES (12, 'Tonkatsu Sauce',  '2oz cup size.', '0.75', 'jpeg', 'https://www.lowcarbingasian.com/wp-content/uploads/2021/02/Keto-Tonkatsu-Sauce-LowCarbingAsian-Cover.jpg');




-- Tags Table
CREATE TABLE tags (
  id      INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag     TEXT NOT NULL UNIQUE
);

-- Tags table seed data
INSERT INTO tags (id, tag) VALUES (1, 'Rice');
INSERT INTO tags (id, tag) VALUES (2, 'Noodle');
INSERT INTO tags (id, tag) VALUES (3, 'Appetizer');
INSERT INTO tags (id, tag) VALUES (4, 'Drink');
INSERT INTO tags (id, tag) VALUES (5, 'Dessert');
INSERT INTO tags (id, tag) VALUES (6, 'Sauce');
INSERT INTO tags (id, tag) VALUES (7, 'Vegetarian');
INSERT INTO tags (id, tag) VALUES (8, 'Spicy');
INSERT INTO tags (id, tag) VALUES (9, 'Contains soup');




-- Food_tags Table
CREATE TABLE food_tags (
  id       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  food_id  INTEGER NOT NULL,
  tag_id   INTEGER NOT NULL,
  FOREIGN KEY (food_id) REFERENCES foods(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);

-- Food_tags table seed data
INSERT INTO food_tags (id, food_id, tag_id) VALUES (1, 1, 1);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (2, 2, 1);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (3, 3, 1);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (4, 4, 1);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (5, 5, 2);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (6, 6, 2);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (7, 7, 3);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (8, 8, 3);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (9, 9, 4);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (10, 10, 4);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (11, 11, 5);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (12, 12, 6);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (13, 3, 7);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (14, 6, 8);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (15, 5, 9);
INSERT INTO food_tags (id, food_id, tag_id) VALUES (16, 6, 9);
