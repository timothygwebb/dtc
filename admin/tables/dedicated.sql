CREATE TABLE IF NOT EXISTS `dedicated` (
  `id` int(11) NOT NULL auto_increment,
  `owner` varchar(64) NOT NULL default '',
  `server_hostname` varchar(255) NOT NULL default '',
  `start_date` date NOT NULL default '0000-00-00',
  `expire_date` date NOT NULL default '0000-00-00',
  `hddsize` int(9) NOT NULL default '1',
  `ramsize` int(9) NOT NULL default '48',
  `product_id` int(9) NOT NULL default '0',
  `operatingsystem` varchar(64) NOT NULL default 'debian',
  PRIMARY KEY  (id),
  UNIQUE KEY `server_hostname` (server_hostname)
) TYPE=MyISAM;