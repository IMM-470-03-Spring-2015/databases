/* phonebook.sql */

/* drop the table if it already exists*/
DROP TABLE IF EXISTS phonebook.address;

/* and create a new one */
CREATE TABLE phonebook.address(id SERIAL PRIMARY KEY, name TEXT, phone TEXT);

/* insert some records into the phonebook */
INSERT INTO phonebook.address (name,phone) VALUES('Me','+12152642459');
INSERT INTO phonebook.address (name,phone) VALUES('Julian','+12678841211');
INSERT INTO phonebook.address (name,phone) VALUES('Sharleen','+12678646825');

/* query our database to return all our data to confirm it went in */
SELECT * FROM phonebook.address;