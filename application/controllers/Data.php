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
        $checkIfJSONContentType = false,
        $setTimeout = null
    ) {
        $timeoutReached = false;
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

        if (!is_null($setTimeout)){
            curl_setopt($handle, CURLOPT_TIMEOUT, $setTimeout);
        }

        $output = curl_exec($handle);
        $responseTime =  curl_getinfo($handle, CURLINFO_STARTTRANSFER_TIME);

        if ($returnHTTPCode === true) {
            if (!curl_errno($handle)) {
                $output = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            } else {
                $output = curl_errno($handle);
                if (curl_errno($handle) === 28) {
                    $timeoutReached = true;
                }
            }
        }

        if ($checkIfJSONContentType === true) {
            if (!curl_errno($handle)) {
                $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if (in_array($responseCode, ['200', '301', '302', '401', '403'], false)) {
                    $contentType = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
                    if (strpos($contentType, 'json') === false) {
                        $output = false;
                    }
                } else {
                    $output = false;
                }
            } else {
                if (curl_errno($handle) === 28) {
                    $timeoutReached = true;
                }
                $output = false;
            }
        }

        curl_close($handle);

        return array('output'=>$output, 'responseTime'=>$responseTime, 'timeoutReached'=>$timeoutReached);
    }

    private function isItAssociativeTable($arr)
    {
        foreach (array_keys($arr) as $k => $v) {
            if ($k !== $v) {
                return true;
            }
        }

        return false;
    }

    protected function checkTargets($listOfTargets)
    {
        foreach ($listOfTargets as $target) {
            $responseTime = null;
            $timeoutReached = false;

            switch ($target['type']) {
                case 'json':
                    //check if the URL serves proper JSON
                    $output = $this->callURL($target['url'], false, true, $target['timeout']);

                    if ($output['output']!== false && json_decode($output['output'], true)
                        && json_last_error() === JSON_ERROR_NONE
                    ) {
                        $this->insertData($target['id'], 1, $output['responseTime'], 0);
                    } elseif ($output['timeoutReached'] === true) {
                        $this->insertData($target['id'], 0, $output['responseTime'], 1);
                    } else {
                        $this->insertData($target['id'], 0, $output['responseTime'], 0);
                    }

                    break;
                default:
                    //check if the URL is alive
                    $HTTPCode = $this->callURL($target['url'], true, false, $target['timeout']);

                    if (is_numeric($HTTPCode['output']) && in_array($HTTPCode['output'], ['200', '301', '302', '401', '403'], false)) {
                        $this->insertData($target['id'], 1, $HTTPCode['responseTime'], 0);
                    } elseif ($HTTPCode['timeoutReached'] === true) {
                        $this->insertData($target['id'], 0, $HTTPCode['responseTime'], 1);
                    } else {
                        $this->insertData($target['id'], 0, $HTTPCode['responseTime'], 0);
                    }

                    break;
            }
        }

        return true;
    }

    protected function insertData($targetId, $status, $responseTime, $timeoutReached)
    {
        return $this->data_model->insert_check_data(
            $targetId,
            $status,
            date('U'),
            $responseTime,
            $timeoutReached
        );
    }

    public function purgeOldData()
    {
        return $this->data_model->purge_old_data();
    }


}