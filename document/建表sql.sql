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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_group_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '����',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_dept_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '��������', 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_dept_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `dept_id` int COMMENT '����id',
  `group_id` int COMMENT '���id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_role_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `name` varchar(100) COMMENT '��ɫ����',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

##################
CREATE TABLE `c_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `user_id` int COMMENT '�û�id',
  `role_id` int COMMENT '��ɫid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_menu_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `name` varchar(100) COMMENT '��Դ����',
  `url` varchar(100) COMMENT '��Դurl',
  `parent_id` int COMMENT '�ϼ���Դid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `menu_id` int COMMENT '��Դid',
  `role_id` int COMMENT '��ɫid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_cust_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `type_no` varchar(5) COMMENT '���ͱ��',
  `type_name` varchar(100) COMMENT '��������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_customer_Info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `cust_no` varchar(10) COMMENT '�ͻ����',
  `cust_name` varchar(100) COMMENT '�ͻ�����',
  `shop_name` varchar(100) COMMENT '��������',
  `corp_name` varchar(100) COMMENT '��˾����',
  `shop_url` varchar(100) COMMENT '������ַ',
  `shop_addr` varchar(100) COMMENT '���̵س�',
  `phone` varchar(20) COMMENT '�绰',
  `qq` varchar(20) COMMENT 'QQ',
  `mail` varchar(50) COMMENT '����',
  `datafrom` varchar(100) COMMENT '������Դ',
  `category` int COMMENT '������Ŀ',
  `cust_type` int COMMENT '�ͻ�����',
  `eno` varchar(10) COMMENT '��������',
  `assign_eno` varchar(10) COMMENT '������',
  `assign_time` DATETIME COMMENT '����ʱ��',
  `next_time` DATETIME COMMENT '�´���ϵʱ��',
  `memo` varchar(100) COMMENT '��ע',
  `create_time` datetime COMMENT '����ʱ��',
  `creator` int COMMENT '������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_cust_convt_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `lib_type` int COMMENT '������',
  `cust_id` int COMMENT '�ͻ�id',
  `cust_type_1` int COMMENT 'ԭʼ���',
  `cust_type_2` int COMMENT 'ת�����',
  `convt_time` datetime COMMENT 'ת��ʱ��',
  `user_id`  int COMMENT '������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_note_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����', 
  `cust_id` int COMMENT '�ͻ�id',
  `cust_info` varchar(200) COMMENT '�ͻ����',
  `requirement` varchar(200) COMMENT '������',
  `service` varchar(200) COMMENT '���ܷ���',
  `dissent` varchar(200) COMMENT '���鴦��',
  `next_followup` varchar(200) COMMENT '�´θ�������',
  `memo` varchar(200) COMMENT '��ע',
  `isvalid` boolean COMMENT '�Ƿ���Ч',
  `iskey` boolean COMMENT '�Ƿ��ص�',
  `next_contact` datetime COMMENT '�´���ϵʱ��',
  `record_path` varchar(200) COMMENT '¼��·��',
  `eno` int COMMENT '����',
  `create_time` datetime COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_dial_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `eno` varchar(10) COMMENT '����',
  `dial_time` datetime COMMENT '�δ�ʱ��',
  `dial_long` float COMMENT '�δ�ʱ��',
  `dial_num` int COMMENT '�δ����',
  `order` int COMMENT 'ת��ʱ��', 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_dic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `code` varchar(10) COMMENT '���',
  `name` varchar(100) COMMENT '����',
  `ctype` varchar(20) COMMENT '����', 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `c_finance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����',
  `cust_id` int COMMENT '�ͻ�id',
  `sale_user` int COMMENT '������Ա',
  `trans_user` int COMMENT '̸��ʦ',
  `acct_number` int COMMENT '���˵���',
  `acct_amount` float COMMENT '���˽��',
  `acct_time` datetime COMMENT '����ʱ��',
  `creator` int COMMENT '������',
  `create_time` datetime COMMENT '����ʱ��',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;