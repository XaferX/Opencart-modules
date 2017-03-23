<?php

class ControllerExtensionModulemassspecial extends Controller
{
    private $error = array();
    const CODE = 'massspecial';
    const SECRET_PASS='special_2017';




    public function clearTablePromotions(){


        $this->load->model('extension/module/massspecial');


        if($this->request->get['password'] == self::SECRET_PASS){
            $this->model_extension_module_massspecial->clearTable();
        }

        $this->response->redirect($this->url->link('extension/module/massspecial',
            'token=' . $this->session->data['token'] . '&type=module', true));

    }


    public function install()
    {

        $this->load->model('setting/setting');
        $this->load->model('extension/module/massspecial');
        $this->model_setting_setting->editSetting(self::CODE, [self::CODE => []]);
        $this->model_extension_module_massspecial->install();

    }


    public function index()
    {

        $this->load->language('extension/module/massspecial');


        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_no_results'] = $this->language->get('text_no_result');
        $data['text_extension'] = $this->language->get('text_extension');


        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');
        $this->load->model('extension/module/massspecial');

        $promotions = $this->model_extension_module_massspecial->getPromotions();


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module',
                true)
        );


        foreach ($promotions as $item) {
            $data['promotions'][] = array(
                'promotion_id' => $item['promotion_id'],
                'data' => $item['data'],
                'date_create' => $item['date_create'],
                'date_start' => $item['date_start'],
                'action' => $this->url->link('extension/module/massspecial/getForm',
                    '&promotion_id=' . $item['promotion_id'] . '&token=' . $this->session->data['token'], true)
            );
        }


        $data['header'] = $this->load->controller('common/header');
        $data['token'] = $this->session->data['token'];
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['action_create'] = $this->url->link('extension/module/massspecial/getForm&token=' . $this->session->data['token'],
            '', true);
        $data['action_delete'] = $this->url->link('extension/module/massspecial/clearTablePromotions&token=' . $this->session->data['token'],
            '', true);

        $this->response->setOutput($this->load->view('extension/module/massspecial_list', $data));


    }


    public function getForm()
    {
        $this->load->language('extension/module/massspecial');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');
        $this->load->model('extension/module/massspecial');
        $this->load->model('setting/setting');
        $this->load->model('catalog/product');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['promotion_id'])) {


                $m_result = $this->model_extension_module_massspecial->addPromotion($this->request->post);
                if (is_array($m_result)) {
                    $strSuccess = "";

                    foreach ($m_result as $link => $item) {
                        $strSuccess .= "<a href='{$link}'> {$item} </a>";
                    }


                    $this->session->data['success'] = $strSuccess;
                }

            } else {

                $this->model_extension_module_massspecial->addPromotion($this->request->post,
                    $this->request->get['promotion_id']);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module/massspecial',
                'token=' . $this->session->data['token'] . '&type=module', true));
        }
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_limit'] = $this->language->get('entry_limit');
        $data['entry_width'] = $this->language->get('entry_width');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['error_promotion_name'])) {
            $data['error_promotion_name'] = $this->error['error_promotion_name'];
        } else {
            $data['error_promotion_name'] = '';
        }

        if (isset($this->error['error_special'])) {
            $data['error_special'] = $this->error['error_special'];
        } else {
            $data['error_special'] = '';
        }




        if (isset($this->error['product_error'])) {
            $data['product_error'] = $this->error['product_error'];
        } else {
            $data['product_error'] = '';
        }


        if (isset($this->error['error_date_start'])) {
            $data['error_date_start'] = $this->error['error_date_start'];
        } else {
            $data['error_date_start'] = '';
        }

        if (isset($this->error['error_date_end'])) {
            $data['error_date_end'] = $this->error['error_date_end'];
        } else {
            $data['error_date_end'] = '';
        }


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module',
                true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/massspecial', 'token=' . $this->session->data['token'],
                    true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/massspecial',
                    'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }


        $data['action'] = $this->url->link('extension/module/massspecial/getForm',
            (isset($this->request->get['promotion_id']) ? '&promotion_id=' . $this->request->get['promotion_id'] : '') . '&token=' . $this->session->data['token'],
            true);


        if (isset($this->request->get['promotion_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module_massspecial->getPromotion($this->request->get['promotion_id']);
        }

        $data['cancel'] = $this->url->link('extension/extension',
            'token=' . $this->session->data['token'] . '&type=module', true);

        $module_info = isset($module_info) ? $module_info['data'] : array();
        $data['promotion_name'] = isset($module_info['promotion_name']) ? $module_info['promotion_name'] : '';
        $data['special_type'] = isset($module_info['special_type']) ? $module_info['special_type'] : '';
        $data['is_delete'] = isset($module_info['is_delete']) ? true : false;
        $data['special'] = isset($module_info['special']) ? $module_info['special'] : '';
        $data['date_from'] = isset($module_info['date_start']) ? $module_info['date_start'] : '';
        $data['date_to'] = isset($module_info['date_end']) ? $module_info['date_end'] : '';
        $data['priority'] = isset($module_info['priority']) ? $module_info['priority'] : '';




        if (isset($module_info['product_id'])) {
            $custom_products = isset($module_info['product_id']) ? $module_info['product_id'] : false;
            foreach ($custom_products as $product_id) {
                $related_info = $this->model_catalog_product->getProduct($product_id);

                if ($related_info) {
                    $data['custom_products'][] = array(
                        'product_id' => $related_info['product_id'],
                        'name' => $related_info['name']
                    );
                }
            }

        } else {
            $data['custom_products'] =array();
        }


        if (isset($module_info['category_id']) && !empty($module_info['category_id'])) {
            $this->load->model('catalog/category');

            $data['product_categories'] = array();

            foreach ($module_info['category_id'] as $category_id) {
                $category_info = $this->model_catalog_category->getCategory($category_id);

                if ($category_info) {
                    $data['category_promo'][] = array(
                        'category_id' => $category_info['category_id'],
                        'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
                    );
                }
            }
        } else {
            $data['category_promo'] = array();
        }


        if (isset($module_info['manufacturer_id']) && !empty($module_info['manufacturer_id'])) {
            $this->load->model('catalog/manufacturer');

            foreach ($module_info['manufacturer_id'] as $manufacturer_id) {
                $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

                if ($manufacturer_info) {
                    $data['manufacture_promo'][] = array(
                        'manufacturer_id' => $manufacturer_info['manufacturer_id'],
                        'name' => isset($manufacturer_info['path']) ? $manufacturer_info['path'] . ' &gt; ' . $manufacturer_info['name'] : $manufacturer_info['name']
                    );
                }


            }
        } else {
            $data['manufacture_promo'] = array();
        }


        $data['status'] = isset($setting['status']) ? $setting['status'] : 0;


        $this->load->model('catalog/category');
        $data['category'] = $this->model_catalog_category->getCategories();
        $this->load->model('catalog/manufacturer');
        $data['manufacturer'] = $this->model_catalog_manufacturer->getManufacturers();


        $data['entry_title2'] = $this->language->get('entry_title2');
        if (isset($this->request->post['username'])) {
            $data['username'] = $this->request->post['username'];
        } elseif (!empty($setting)) {
            $data['username'] = $setting['username'];
        } else {
            $data['username'] = '';
        }

        if (isset($this->request->post['username'])) {
            $data['username'] = $this->request->post['username'];
        } elseif (!empty($setting)) {
            $data['username'] = $setting['username'];
        } else {
            $data['username'] = '';
        }


        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($setting)) {
            $data['status'] = $setting['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['token'] = $this->session->data['token'];
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/massspecial', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/massspecial')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }


        if (empty($this->request->post['promotion_name']) || strlen($this->request->post['promotion_name']) < 5) {
            $this->error['error_promotion_name'] = $this->language->get('error_promotion_name');
        }
        if (empty($this->request->post['special']) || !is_numeric($this->request->post['special'])) {
            $this->error['error_special'] = $this->language->get('error_special');
        }

        if (empty($this->request->post['date_start']) || strlen($this->request->post['date_start']) < 5) {
            $this->error['error_date_start'] = $this->language->get('error_date_start');
        }

        if (empty($this->request->post['date_end']) || strlen($this->request->post['date_end']) < 5) {
            $this->error['error_date_end'] = $this->language->get('error_date_end');
        }
        if (empty($this->request->post['category_id']) && empty($this->request->post['manufacturer_id']) && empty($this->request->post['product_id'])) {
            $this->error['product_error'] = $this->language->get('product_error');
        }
//var_dump($this->error); die;
        return !$this->error;
    }


    public function uninstall()
    {


        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting(self::CODE);
        $this->load->model('extension/module/massspecial');
        $this->model_extension_module_massspecial->uninstall();
        $this->session->data['success'] = $this->language->get('text_success');

        $this->response->redirect($this->url->link('extension/extension',
            'token=' . $this->session->data['token'] . '&type=module', true));

    }


}
