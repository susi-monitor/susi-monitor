<?php

class Data extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('target_model');
        $this->load->model('data_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {

    }

    public function update_data()
    {
        $targets = $this->getListOfTargets();
        $result = $this->checkTargets($targets);

        if ($result) {
            $data['status'] = 'OK';
        } else {
            $data['status'] = 'ERROR';
        }

        $this->load->view('data/update', $data);
    }

    protected function getListOfTargets()
    {
        return $this->target_model->get_targets();
    }

    protected function callURL(
        $url,
        $returnHTTPCode = false,
        $checkIfJSONContentType = false
    ) {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, VERIFYHOST);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, VERIFYPEER);
        curl_setopt($handle, CURLOPT_USERAGENT, UA_STRING);

        if (PROXY_ENABLED == 1) {
            curl_setopt($handle, CURLOPT_HTTPPROXYTUNNEL, PROXY_ENABLED);
            curl_setopt($handle, CURLOPT_PROXY, PROXY_HOST);
            curl_setopt($handle, CURLOPT_PROXYPORT, PROXY_PORT);
            curl_setopt($handle, CURLOPT_PROXYUSERPWD, PROXY_CREDENTIALS);
        }

        $output = curl_exec($handle);

        if ($returnHTTPCode === true) {
            if (!curl_errno($handle)) {
                $output = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            } else {
                $output = curl_errno($handle);
            }
        }

        if ($checkIfJSONContentType === true) {
            if (!curl_errno($handle)) {
                $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if (in_array($responseCode, ['200', '301', '302'], false)) {
                    $contentType = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
                    if (strpos($contentType, 'json') === false) {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        curl_close($handle);

        return $output;
    }

    protected function checkTargets($listOfTargets)
    {
        foreach ($listOfTargets as $target) {
            switch ($target['type']) {
                case 'json':
                    //check if the URL serves proper JSON
                    $output = $this->callURL($target['url'], false, true);

                    if (json_decode($output, true)
                        && json_last_error() === JSON_ERROR_NONE
                    ) {
                        $this->insertData($target['id'], 1);
                    } else {
                        $this->insertData($target['id'], 0);
                    }
                    break;
                default:
                    //check if the URL is alive
                    $HTTPCode = $this->callURL($target['url'], true);
                    if (in_array($HTTPCode, ['200', '301', '302'], false)) {
                        $this->insertData($target['id'], 1);
                    } else {
                        $this->insertData($target['id'], 0);
                    }
                    break;
            }
        }

        return true;
    }

    protected function insertData($targetId, $status)
    {
        /* $sql = 'INSERT INTO data (target_id, status, datetime) VALUES (?,?,?)';
         $stmt = $dbh->prepare($sql);
         $stmt->execute([$targetId, $status, date('U')]);*/
        return $this->data_model->insert_check_data(
            $targetId,
            $status,
            date('U')
        );
    }


}