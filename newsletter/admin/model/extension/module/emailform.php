<?php


class ModelExtensionModuleEmailform extends Model
{


    public function install()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "emailform (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

        return true;

    }


    public function uninstall()
    {


        $this->db->query("DROP TABLE " . DB_PREFIX . "emailform ");
        return true;
    }


    public function getAllEmails()
    {

        $dbResult = $this->db->query("SELECT * FROM " . DB_PREFIX . "emailform ");
        return $dbResult->rows;

    }


}



