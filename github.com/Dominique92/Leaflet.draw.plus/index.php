<?php // File to be executed in a PHP / MySql environment

/* Reqs : MySql 5.7.6+ / Create this database on your server:
CREATE DATABASE drawdb;
USE drawdb;
CREATE TABLE drawtable (
  geom geometrycollection NOT NULL,
  id int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id)
);
INSERT INTO drawtable (geom) VALUES (GeometryCollection(POINT(5,45)));
*/

// Connect to the database
$mysqli = @new mysqli ('localhost', 'root', '', 'drawdb'); // Replace SQL parameters by yours
if ($mysqli->connect_errno) {
	echo $mysqli->connect_error;
	exit;
}

// Upload edition changes to the database
echo ('$_POST = '); var_dump ($_POST);
if ($pgeom = @$_POST['geom'])
	$mysqli->query("UPDATE drawtable SET geom = ST_GeomFromGeoJSON ('$pgeom') where id = 1");

// Get existing data from the database
$result = $mysqli->query("SELECT ST_AsGeoJSON (geom) AS geom FROM drawtable where id = 1");
echo ('$json_sql = '); var_dump ($json_sql = $result->fetch_object()->geom);
?>

<!-- Enable save to PHP -->
<style>
	#save {
		display: block !important;
	}
	.save-comment {
		display: none !important;
	}
</style>

<?php
include ('index.html');
?>

<!-- debug -->
<a href="v1"
   style="position:absolute;top:150px;right:0;text-decoration:none;font-size:large"
   title="Test draw.plus on Leaflet V1.0">
	&#10144;
</a>
