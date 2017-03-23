<?php


class ModelExtensionModulemassspecial extends Model
{

    private $error = array();


    private function getTable()
    {
        return DB_PREFIX . "promotions";
    }

    
    



    public function clearTable(){

        $sql = " DELETE FROM  " . $this->getTable() . "   ";
        $this->db->query($sql);
    }

    public function getPromotions()
    {

        $sql = " SELECT * FROM  " . $this->getTable() . "  ";
        $dbResult = $this->db->query($sql);
        $arrData = array();


        foreach ($dbResult->rows as $row) {


            $arrData[] = array(
                'data' => json_decode(json_fix_cyr($row['data']), true),
                'date_create' => $row['date_create'],
                'date_start' => $row['date_start'],
                'promotion_id' => $row['promotion_id']
            );


        }

        return $arrData;


    }


    public function getError()
    {

        return $this->error;
    }


    public function getPromotion($promotion_id)
    {


        $sql = " SELECT * FROM  " . $this->getTable() . "  WHERE promotion_id =" . abs(intval($promotion_id)) . " limit 1 ";
        $dbResult = $this->db->query($sql);
        $arrData = array();


        $arrData = array(
            'data' => json_decode(json_fix_cyr($dbResult->row['data']), true),
            'date_create' => $dbResult->row['date_create'],
            'date_start' => $dbResult->row['date_start'],
            'promotion_id' => $dbResult->row['promotion_id']
        );


        return $arrData;


    }


    private function setError($error)
    {
        $this->error[] = $error;
    }

    public function install()
    {


        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTable() . "` (
  `promotion_id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(32) NOT NULL,
  `date_create` date DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  PRIMARY KEY (`promotion_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
";

        $this->db->query($sql);


    }


    public function getProductsId($category_ids, $manufacture_ids)
    {


        $product_ids = array();

        if (!empty($category_ids)) {
            $sql = "SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id in (" . implode(',',
                    $category_ids) . ") GROUP BY product_id ";
            $dbCategory = $this->db->query($sql);

            foreach ($dbCategory->rows as $product) {
                $product_ids[] = $product['product_id'];
            }


        }


        if (!empty($manufacture_ids)) {
            $sql = "
      SELECT 
        product_id 
      FROM  " . DB_PREFIX . "product 
        WHERE manufacturer_id 
         in (" . implode(',', $manufacture_ids) . ")
          ";

            $dbManufacture = $this->db->query($sql);


            foreach ($dbManufacture->rows as $product) {
                $product_ids[] = $product['product_id'];
            }

        }


        return $product_ids;
    }


    public function addPromotion(array $arrData, $promotion_id = 0)
    {

        $this->load->model('catalog/product');


        $is_save = false;

        try {


            if (isset($arrData['is_start'])) { // start promotion
                // we need to add special to category product

                $arrCategoryIds = array();
                $arrManufactureIds = array();
                $arrCustomProducts = array();
                $allProductIds = array();

                $arrCategoryIds = isset($arrData['category_id']) ? array_unique($arrData['category_id']) : array();
                $arrManufactureIds = isset($arrData['manufacturer_id']) ? array_unique($arrData['manufacturer_id']) : array();
                $arrCustomProducts = isset($arrData['product_id']) ? array_unique($arrData['product_id']) : array();
                $is_deleteSpecial = isset($arrData['is_delete']) ? true : false;
                $special_type = isset($arrData['special_type']) ? intval($arrData['special_type']) : 1;
                $special_discountTable = ($arrData['special_discount'] == 1) ? 'product_special' : 'product_discount';

                $special_priority = isset($arrData['priority']) ? $arrData['priority'] : 1;

                $special_value = !empty($arrData['special']) ? $arrData['special'] : 0;

                $allProductIds = $this->getProductsId($arrCategoryIds, $arrManufactureIds);
                $allProductIds = array_unique($allProductIds);
                $allProductIds = array_merge($allProductIds, $arrCustomProducts);


                foreach ($allProductIds as $product_id) {

                    $product_price = $this->getProductPrice($product_id);
                    $product_special = $this->getRealSpecial($product_price, $special_value, $special_type);

                    if ($is_deleteSpecial) {
                        $this->deleteSpecial($product_id, $special_discountTable);
                    }

                    if ($product_special > 0) {


                        $this->setNewSpecial(array(
                            'special' => $product_special,
                            'date_start' => $arrData['date_start'],
                            'date_end' => $arrData['date_end'],
                            'special_discount_table' => $special_discountTable,
                            'priority' => $special_priority
                        ), $product_id);
                    } else {
                        $productData = $this->model_catalog_product->getProduct($product_id);
                        $this->setError(
                            array(
                                'name' => $productData['name'],
                                'link' => $this->url->link('catalog/product/edit',
                                    'token=' . $this->session->data['token'] . '&product_id=' . $product_id, true)
                            )
                        );
                    }


                }
            }

            $is_save = true;

        } catch (Exception $e) {
            $is_save = false;
            throw  $e;
        }

        if ($is_save) {


            if ($promotion_id > 0) {

                $this->deletePromotion($promotion_id);
            }


            $this->saveInHistory($arrData);
        }
        return (!$this->getError()) ? true : $this->getError();

    }

    private function saveInHistory($arrData)
    {
        $sql = " INSERT INTO   " . $this->getTable() . " 
        set 
        `data` ='" . json_encode($arrData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "' , 
        `date_create` = NOW()    ";
        if (isset($arrData['is_start'])) {
            $sql .= ", `date_start`=NOW() ";
        }

        $this->db->query($sql);

    }

    private function deletePromotion($promotion_id)
    {
        $sql = " DELETE FROM   " . $this->getTable() . " WHERE promotion_id =" . abs(intval($promotion_id)) . "   ";
        $this->db->query($sql);
    }


    private function setNewSpecial($arrData, $product_id)
    {

        $sql = " INSERT INTO   " . DB_PREFIX . $arrData['special_discount_table'] . " 
        set 
        price ='" . floatval($arrData['special']) . "' , 
        product_id =" . abs(intval($product_id)) . ",
        date_start ='" . $arrData['date_start'] . "', 
        date_end ='" . $arrData['date_end'] . "',
        priority ='" . intval($arrData['priority']) . "'
          ";
        $this->db->query($sql);
    }

    private function deleteSpecial($product_id, $table)
    {

        $sql = " DELETE FROM  " . DB_PREFIX . $table . " WHERE product_id =" . abs(intval($product_id)) . " ";
        $this->db->query($sql);
    }


    private function getRealSpecial($price, $specialValue, $special_type = 1)
    {

        switch ($special_type):

            case 1 :
                $newSpecial = ($price * $specialValue) / 100;
                $newSpecial = $price - $newSpecial;
                break;
            case 2 :
                ($price > $specialValue) ? $newSpecial = $price - $specialValue : $newSpecial = 0;
                break;
            default :
                $newSpecial = ($price * $specialValue) / 100;
                $newSpecial = $price - $newSpecial;
                break;
        endswitch;


        return $newSpecial;


    }


    private function getProductPrice($product_id)
    {

        $sql = "SELECT price FROM " . DB_PREFIX . "product WHERE product_id =" . abs(intval($product_id)) . " LIMIT 1 ";
        $dbProduct = $this->db->query($sql);

        return $dbProduct->row['price'];
    }


    public function uninstall()
    {
        $sql = "DROP TABLE IF EXISTS `" . $this->getTable() . "` ";
        $this->db->query($sql);
    }


}