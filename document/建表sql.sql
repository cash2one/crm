 CREATE TABLE `c_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `eno` varchar(10) NOT NULL DEFAULT '' COMMENT '����',
  `pass` varchar(50) NOT NULL COMMENT '����',
  `name` varchar(20) DEFAULT '' COMMENT '����',
  `username` varchar(30) NOT NULL COMMENT '�û���',
  `birth` date DEFAULT NULL COMMENT '����',
  `sex` tinyint(2) NOT NULL DEFAULT '1' COMMENT '�Ա�',
  `tel` varchar(20) NOT NULL COMMENT '�绰����',
  `qq` varchar(15) DEFAULT NULL COMMENT 'qq',
  `dept` mediumint(4) NOT NULL COMMENT '����',
  `group` mediumint(5) DEFAULT NULL COMMENT '���',
  `ismaster` tinyint(1) DEFAULT NULL COMMENT '�Ƿ�Ӣ',
  `status` tinyint(2) DEFAULT NULL COMMENT '״̬',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8