<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<root>
<?php
$db = mysql_connect('localhost', 'krteppma', '43Vza7cwUBuw29QV');
mysql_select_db('krteppma', $db);
mysql_set_charset('utf8');

//get all poi with the given categories
$sql = 'SELECT DISTINCT `p`.`id_poi`, `lat`, `lon`, `name`, `description` FROM `poi` AS `p`
    LEFT OUTER JOIN `poi2document` AS `p2d` ON `p`.`id_poi` = `p2d`.`id_poi`
    LEFT OUTER JOIN `document` AS `d` ON `p2d`.`id_document` = `d`.`id_document`
    WHERE 1 = 2';

//set the category variables
/*
 * mapping:
 * 1 pirates
 * 2 spd
 * 4 cdu
 * 8 b90
 * 16 wfh
 * 32 admin
 */
if (!isset($_GET['pirates']) || $_GET['pirates'] == 1)
    $sql .= ' OR `d`.`categories` & 1 = 1';
if (!isset($_GET['spd']) || $_GET['spd'] == 1)
    $sql .= ' OR `d`.`categories` & 2 = 2';
if (!isset($_GET['cdu']) || $_GET['cdu'] == 1)
    $sql .= ' OR `d`.`categories` & 4 = 4';
if (!isset($_GET['b90']) || $_GET['b90'] == 1)
    $sql .= ' OR `d`.`categories` & 8 = 8';
if (!isset($_GET['wfh']) || $_GET['wfh'] == 1)
    $sql .= ' OR `d`.`categories` & 16 = 16';
if (!isset($_GET['admin']) || $_GET['admin'] == 1)
    $sql .= ' OR `d`.`categories` & 32 = 32';

$res = mysql_query($sql);
while ($rec = mysql_fetch_assoc($res)) {
?>
<poi>
    <lat><?php echo $rec['lat']; ?></lat>
    <lon><?php echo $rec['lon']; ?></lon>
    <name><?php echo htmlspecialchars($rec['name']); ?></name>
    <description><?php echo htmlspecialchars($rec['description']); ?></description>
    <documents>
<?php
    $sql = 'SELECT `title`, `link` FROM `poi2document` AS `p2d`
        LEFT OUTER JOIN `document` AS `d` ON `p2d`.`id_document` = `d`.`id_document`
        WHERE `p2d`.`id_poi` = ' . $rec['id_poi'] . ' AND (1 = 2';
    
    //set the category variables
    if (!isset($_GET['pirates']) || $_GET['pirates'] == 1)
        $sql .= ' OR `d`.`categories` & 1 = 1';
    if (!isset($_GET['spd']) || $_GET['spd'] == 1)
        $sql .= ' OR `d`.`categories` & 2 = 2';
    if (!isset($_GET['cdu']) || $_GET['cdu'] == 1)
        $sql .= ' OR `d`.`categories` & 4 = 4';
    if (!isset($_GET['b90']) || $_GET['b90'] == 1)
        $sql .= ' OR `d`.`categories` & 8 = 8';
    if (!isset($_GET['wfh']) || $_GET['wfh'] == 1)
        $sql .= ' OR `d`.`categories` & 16 = 16';
    if (!isset($_GET['admin']) || $_GET['admin'] == 1)
        $sql .= ' OR `d`.`categories` & 32 = 32';
    
    $sql .= ')';
    
    $res2 = mysql_query($sql);
    while ($rec2 = mysql_fetch_assoc($res2)) {
?>
        <document>
            <title><?php echo htmlspecialchars($rec2['title']); ?></title>
            <link><?php echo htmlspecialchars($rec2['link']); ?></link>
        </document>
<?php
    }
?>
    </documents>
</poi>
<?php
}
?>
</root>