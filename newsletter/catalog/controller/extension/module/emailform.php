<?php

class ControllerExtensionModuleEmailform extends Controller
{
    public function index($setting)
    {
        $data = $this->load->language('extension/module/emailform');

        $this->document->addScript('catalog/view/theme/theme_es/js/core/controllers/emailformController.js',
            'emailform');
        $data['scripts'] = $this->document->getScripts('emailform');

        $data['title'] = $this->language->get('title');
        $data['text_not_spam'] = $this->language->get('text_not_spam');
        $data['text_subscribe'] = $this->language->get('text_subscribe');
        $data['heading_title'] = $this->language->get('heading_title');

        $data['hide_module'] = isset($this->request->cookie['hide_newsletter']) ? true : false;
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = array();
        }
        $this->load->model('extension/module');
        $setting = $setting['newsletter'];
        $data['setting'] = array();
        if (isset($setting)) {

            $data['title'] = html_entity_decode($setting[$this->config->get('config_language_id')]['title']);
            $data['text'] = html_entity_decode($setting[$this->config->get('config_language_id')]['text']);

        }

        return $this->load->view('extension/module/emailform', $data);
    }


    public function email()
    {

        $this->load->model('extension/module/emailform');
        $this->load->language('extension/module/emailform');
        if (isset($this->request->post['email']) && !empty($this->request->post['email'])) {
            $email = trim($this->request->post['email']);
            $json = array();
            if (!$this->model_extension_module_emailform->check($email)) {
                $bCreate = $this->model_extension_module_emailform->insert($email);
                if ($bCreate) {
                    $json['success'] = $this->language->get('success');
                    setcookie('hide_newsletter', true, time() + 31536000, '/'); // year

                }


            } else {
                $json['error'] = $this->language->get('email_exist');

            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));


        }

    }
}
