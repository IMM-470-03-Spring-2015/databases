/* incidents.sql */

/* drop the table if it already exists*/
DROP TABLE IF EXISTS incidents;

/* and create a new one */
CREATE TABLE incidents(id SERIAL PRIMARY KEY, name TEXT, latitude DOUBLE PRECISION, longitude DOUBLE PRECISION);

/* insert a starter record into the incidents table */
INSERT INTO incidents (name,latitude,longitude) VALUES('TCNJ',40.268835,-74.78091);

/* query our database to return all our data to confirm it went in */
SELECT * FROM incidents;