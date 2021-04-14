# Project 3: Design Journey

Be clear and concise in your writing. Bullets points are encouraged.

**Everything, including images, must be visible in Markdown Preview.** If it's not visible in Markdown Preview, then we won't grade it. We won't give you partial credit either. This is your warning.


## Design Plan

### Project 1 or 2
> Do you plan to reuse your Project 1 or 2 site?
> Which project?

Yes, Project 2.

> If yes, please include sketches of the site's current design (you may copy the "final" sections from those assignments.)

![table 3](menu.jpeg)
This is a sketch of my menu page.

![insert form 3](employee.jpeg)
This is a sketch my employees page.

### Describe your Media Catalog (Milestone 1)
> What will your collection be about?
> What type of media will your site display? (images, videos, audio)

My collection will be food items provided at the restaurant Oishii Bowl, where each entry associates the name of the dish with an image of it. The type of media will be images.

### Audiences (Milestone 1)
> Briefly explain your site's audiences. Be specific and justify why each audience is appropriate for your site.
> You are required to have **two** audiences: "information consumers" and "site administrators"

Information Consumer: My consumers are customers to Oishii Bowl. They could be living near Collegetown or are just local residents around the Ithaca area who love and want to explore Japanese and Chinese cuisines. The consumers are able to view the collections of food provided at Oishii Bowl along with images of them, which make them more appetizing.

The audience is appropriate because my site aims to publicize delicious food at Oishii Bowl to more people, and the local residents in Ithaca would be interested in a menu that specifies the information of the food that are offered at this restaurant, as well as pictures of them, so that they can find the items they want to eat or try out.

Site Administrator: My site administrators are the employees at Oishii Bowl. They are able to login on the website and make changes to the menu items by adding, deleting, or editing the current food catalog.

The audience is appropriate because the workers at Oishii Bowl would wish to have access to the dataset so that they can maintain the menu to be up to date. Through my site, they will be able to modify the records at anytime in order to provide their customer the newest recipes.

### Personas (Milestone 1)
> Your personas must have a name and a "depiction". This can be a photo of a face or a drawing, etc.
> There is no required format for the persona.
> You may type out the persona below with bullet points or include an image of the persona. Just make sure it's easy to read the persona when previewing markdown.
> Your personas should focus on the goals, obstacles, and factors that influence behavior of each audience.

> Persona for your "consumer" audience:

![viewer audience](viewer.jpeg)

Avene is a first year PhD student at Cornell, coming from Florida, who lives in Collegetown and likes to visit the Starbucks store across the street from Oishii Bowl every Wednesday and Thursday to study. Before she heads home, she often goes to Oishii Bowl to buy food for dinner after studying. She sometimes also buys lunch there during the day after her classes ends. Avene loves Asian cuisine, especially any kinds of Japanese rice dons. Her favorite is a rice don covered by chicken and egg with caramelized onions, but she could not remember the name of the dish. She also likes to buy some appetizers from Oishii to bring home and share with her roommates. She has a limited budget for food every week, and she does not want to spend her money on overpriced items.


> Persona for your "administrator" audience:

![inserts new records audience](worker.jpeg)

Andreas is a 30-year-old worker at Oishii Bowl who graduated from Ithaca College years ago and now lives in Ithaca permanently. He goes to work every Monday, Wednesday, and Friday. He mainly takes in orders at the front desk but also help the store to insert new menu items into their database sometimes. He has very good memories and can recite all the current food items in the store with their prices. He, however, is not a native speaker of Japanese and sometimes spells the Japanese food names incorrectly. He loves his job, and he loves seeing his customers feeling fulfilled after enjoying the food they provide. This motivates him to come up with new ideas for the menu.


### Site Design (Milestone 1)
> Document your _entire_ design process. **We want to see iteration!**
> Show us the evolution of your design from your first idea (sketch) to the final design you plan to implement (sketch).
> Show us the process you used to organize content and plan the navigation, if applicable (card sorting).
> Plan your URLs for the site.
> Provide a brief explanation _underneath_ each design artifact. Explain what the artifact is, how it meets the goals of your personas (**refer to your personas by name**).
> Clearly label the final design.

![consumer page](not-logged-in.jpeg)
This is the menu page for consumers when not logged in. Customers like Avene will be able to browse different items provided at Oishii Bowl by looking at multiple images and names in one single screen, which is convenient for comparison. Avene will also be able to filter out categories of foods on the side bar to only look at her favorite rice dons. With the sort buttons on top of the catalog, Avene can sort the items according to their prices.

![admin page](logged-in.jpeg)
This is the menu page for administrators when logged in. Employees like Andreas will be able to look at all entries in the catalog holistically on this page, and he will be able to add new items using the side bar form on the left. He is also able to perform actions like consumers do, such as filtering out categories. After logged in, Andreas can see his name on the top right corner with a logout button to end his session. This name message tells him that he is logged in right now.

![detailed entry page](details.jpeg)
This is an example entry page with details. The image of the item is position on the left, much more enlarged from when presented in the catalog. The name, price, description, and tags/categories are listed on the right hand side. Avene can look at dishes more closely using this page: the enlarged image will look appetizing, and she can read more about the food description and its tags. Andreas, when logged in, can also edit or delete the item on this page using the buttons listed.

### Design Patterns (Milestone 1)
> Write a one paragraph reflection explaining how you used the design patterns in your site's design.

I designed my page to have good usability and accessibility by properly guiding the user's eyes. The side bar containing the tags and new item entry form (for Andreas/employee) is on the left hand side, which is its conventional position and reflects user's habit to read from left to right. Enough blank spaces are reserved between blocks of texts, forms, and images for better usability. The site adopts a clear hierarchy by bolding and enlarging menu and form titles as headings, as well as greying out descriptions/ minor details for entry information. The forms are usable by properly aligning the text boxes at the center, and the submit buttons (which are only used when necessary) are centered right below the form inputs. On the details page for every entry, the image is enlarged and placed on the left, and the name, description, price, as well as tags are placed on the right side of the image. Avene and Andreas can therefore browse both the item picture and its information on the same screen. They can make actions on the right hand side while looking at the appealing image on the left. The admin login button is positioned on the top right corner of the site according to convention. Andreas will be able to see "Hi, Andreas!" after he logs in on the site, which is informative and personalized. The query string parameters are designed to be clear and concise for short and memorable URLs. A 404 page is also designed for Andreas and Avene to not get lost when navigating off the site.



## Implementation Plan

### Requests (Milestone 1. Revise in Milestone 2)
> Identify and plan each request you will support in your design.
> List each request that you will need (e.g. view image details, view gallery, edit book, tag product, etc.)
> For each request, specify the request type (GET or POST), how you will initiate the request: (form or query string URL), and the HTTP parameters necessary for the request.

- Request: view item details
  - Type: GET
  - URL: /details?id=X
  - Params: id _or_ item_id (item.id in DB)

- Request: filter tags (categories)
  - Type: GET
  - URL: /X?=1
  - Params: tag

- Request: sort based on price
  - Type: GET
  - URL: /?sort=X
  - Params: sort

- Request: add tag
  - Type: POST
  - Params: add_tag

- Request: delete tag
  - Type: POST
  - Params: delete_tag

- Request: add image
  - Type: POST
  - Params: add_img

- Request: employee login
  - Type: POST
  - Params: username, password


### Database Schema (Milestone 1. Revise in Milestone 2)
> Describe the structure of your database. You may use words or a picture. A bulleted list is probably the simplest way to do this. Make sure you include constraints for each field.

> Hint: You probably need a table for "entries", `tags`, `"entry"_tags` (stores relationship between entries and tags), and a `users` tables.

> Hint: For foreign keys, use the singular name of the table + _id. For example: `image_id` and `tag_id` for the `image_tags` (tags for each image) table.

Table: foods
- id: INTEGER {NOT NULL, PRIMARY KEY, AUTOINCREMENT, UNIQUE},
- food: TEXT {NOT NULL},
- description: TEXT {},
- price: REAL {NOT NULL},
- file_ext: TEXT {NOT NULL},
- citation: TEXT {}

Table: tags
- id: INTEGER {NOT NULL, PRIMARY KEY, AUTOINCREMENT, UNIQUE},
- tag: TEXT {NOT NULL}

Table: food_tags
- id: INTEGER {NOT NULL, PRIMARY KEY, AUTOINCREMENT, UNIQUE},
- food_id: INTEGER {NOT NULL, FOREIGN KEY},
- tag_id: INTEGER {NOT NULL, FOREIGN KEY}

Table: users
- id: INTEGER {NOT NULL, PRIMARY KEY, AUTOINCREMENT, UNIQUE},
- username: TEXT {NOT NULL, UNIQUE},
- password: HASHED {NOT NULL}

### Database Query Plan (Milestone 1. Revise in Milestone 2)
> Plan your database queries. You may use natural language, pseudocode, or SQL.

1. Show all entries with their tags:
```
Left join food_tags with tags and foods table to relate all items with their tags.
```

2. Show certain entries with selected tags:
```
Left join food_tags with tags and foods table to relate all items with their tags, where tags equal to the ones selected by user.
```


### Code Planning (Milestone 1. Revise in Milestone 2)
> Plan any PHP code you'll need here using pseudocode.
> Use this space to plan out your form validation and assembling the SQL queries, etc.
> Tip: Break this up by pages. It makes it easier to plan.

```
- if user logs in:
  - if user is admin (username & pw exist in DB):
    - show employee page with modification options
    - show each detailed entry with edit/delete options
    - change "login" to "logout"
    - if user enters new food item:
      - store information as sticky variables
      - if entering form is valid:
        - add new item to DB
      - if entering form not valid:
        - provide feedback messages
    - if user deletes item:
      - provide confirmation message
    - if user edits item:
      - if edits are valid:
        - store edits as new info for entry
      - if edits not valid:
        - provide feedback messages
  - else:
    - provide feedback messages about invalid login info
- else:
  - if user selects tags:
    - retrieve entries and images with those tags from DB
  - else:
    - retrieve all entries and images from DB
```


## Submission

### Audience (Final Submission)
> Tell us how your final site meets the needs of the audiences. Be specific here. Tell us how you tailored your design, content, etc. to make your website usable for your personas. Refer to the personas by name.

TODO


### Additional Design Justifications (Final Submission)
> If you feel like you haven’t fully explained your design choices in the final submission, or you want to explain some functions in your site (e.g., if you feel like you make a special design choice which might not meet the final requirement), you can use the additional design justifications to justify your design choices. Remember, this is place for you to justify your design choices which you haven’t covered in the design journey. You don’t need to fill out this section if you think all design choices have been well explained in the design journey.

TODO


### Self-Reflection (Final Submission)
> Reflect on what you learned during this assignment. How have you improved from Project 1? What things did you have trouble with?

TODO


### Grading: Mobile or Desktop (Final Submission)
> When we grade your final site, should we grade this with a mobile screen size or a desktop screen size?

TODO


### Grading: Step-by-Step Instructions (Final Submission)
> Write step-by-step instructions for the graders.
> The project if very hard to grade if we don't understand how your site works.
> For example, you must login before you can delete.
> For each set of instructions, assume the grader is starting from /

Viewing all entries:
1. TODO
2.

View all entries for a tag:
1. TODO
2.

View a single entry and all the tags for that entry:
1. TODO
2.

How to insert and upload a new entry:
1. TODO
2.

How to delete an entry:
1. TODO
2.

How to view all tags at once:
1. TODO
2.

How to add a tag to an existing entry:
1. TODO
2.

How to remove a tag from an existing entry:
1. TODO
2.
