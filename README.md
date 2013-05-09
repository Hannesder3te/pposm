pposm
=====

Show documents from a city council in OpenStreetMap

=====
sql dump
-----
CREATE TABLE IF NOT EXISTS `document` (
  `id_document` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `categories` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_document`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `poi` (
  `id_poi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lat` decimal(8,6) NOT NULL,
  `lon` decimal(9,6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_poi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `poi2document` (
  `id_poi` int(10) unsigned NOT NULL,
  `id_document` int(10) unsigned NOT NULL,
  UNIQUE KEY `id_poi` (`id_poi`,`id_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
