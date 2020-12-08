USE food_sc;


INSERT INTO foods VALUES (null,'PHP and MySQL Web Development',1,49.99,20,1,
'PHP & MySQL Web Development teaches the reader to develop dynamic, secure e-commerce web sites. You will learn to integrate and implement these technologies by following real-world examples and working sample projects.');
INSERT INTO foods VALUES (null,'Sams Teach Yourself PHP, MySQL and Apache All-in-One',1,34.99,30,1,
'Using a straightforward, step-by-step approach, each lesson in this food builds on the previous ones, enabling you to learn the essentials of PHP scripting, MySQL databases, and the Apache web server from the ground up.');
INSERT INTO foods VALUES (null,'PHP Developer\'s Cookfood',1,39.99,40,1,
'Provides a complete, solutions-oriented guide to the challenges most often faced by PHP developers\r\nWritten specifically for experienced Web developers, the food offers real-world solutions to real-world needs\r\n');

INSERT INTO merchants VALUES (null,'Internet','1823123123','兰州大学榆中校区A',1);
INSERT INTO merchants VALUES (null,'Self-help','18234234234','兰州大学榆中校区B',1);
INSERT INTO merchants VALUES (null,'Fiction','18232131231','兰州大学榆中校区C',1);
INSERT INTO merchants VALUES (null,'Gardening','1832423432','兰州大学榆中校区D',1);

INSERT INTO admin VALUES ('admin', sha1('admin'));
