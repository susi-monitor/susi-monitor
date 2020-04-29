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

            if (NOTIFICATIONS_ENABLED === true && $target['notifications_enabled'] == 1){
                $this->checkIfNotificationNeeded($target['id']);
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

    public function checkIfNotificationNeeded($targetId = null)
    {
        if ($targetId === null) {
            return false;
        }

        $data['targetId'] = $targetId;

        $data['target'] = $this->target_model->get_target_by_id($targetId)[0];
        $data['target_data'] = $this->data_model->get_data_by_target_id($targetId);

        if (($data['target_data'][$targetId][0]['status'] == 0) && ($data['target_data'][$targetId][1]['status'] == 1)) {
            // SERVICE IS DOWN
            $this->sendTeamsNotification($data['target']['name'], $data['target']['url'], $targetId, 'SERVICE_DOWN');

        } elseif (($data['target_data'][$targetId][0]['status'] == 1) && ($data['target_data'][$targetId][1]['status'] == 0)) {
            // SERVICE IS BACK UP
            $lastSeen = $this->data_model->last_seen($targetId);
            if ($lastSeen === 0) {
                $lastSeenText = 'Over 48 hours ago';
            } else {
                $lastSeenText = date('H:i d/m/y T', $lastSeen);
            }
            $this->sendTeamsNotification($data['target']['name'], $data['target']['url'], $targetId, 'BACK_UP', $lastSeenText);
        }

        return true;
    }

    public function sendTeamsNotification($targetName, $targetURL, $targetId, $type = 'BACK_UP', $howLongDown = null)
    {
        if ($type === 'SERVICE_DOWN') {
            $summary = $targetName . ' is down!';
            $title = 'A service is down';
            $themeColor = 'd41919';

            $factsSection = array(
                array(
                    "name" => "Name",
                    "value" => $targetName
                ),
                array("name" => "URL",
                    "value" => $targetURL)
            );

        } elseif ($type === 'BACK_UP') {
            $summary = $targetName . ' is back up!';
            $title = 'A service is back up';
            $themeColor = '29cf23';

            $factsSection = array(
                array(
                    "name" => "Name",
                    "value" => $targetName
                ),
                array("name" => "URL",
                    "value" => $targetURL),
                array("name" => "Has been down from",
                    "value" => $howLongDown)
            );
        }

        $data = array(
            "@type" => "MessageCard",
            "@context" => "http://schema.org/extensions",
            "themeColor" => $themeColor,
            "summary" => $summary,
            "sections" => array(
                "activityTitle" => $title,
                "activityImage" => "https://raw.githubusercontent.com/susi-monitor/susi-monitor/master/img/android-chrome-192x192.png",
                "facts" => $factsSection,
                "markdown" => true
            ),
            "potentialAction" => array(
                "@type" => "ActionCard",
                "name" => "See last 24 hours of this service",
                "actions" => array(
                    "@type" => "OpenUri",
                    "name" => "See last 24 hours of this service",
                    "target" => site_url('/').'details/'.$targetId
                )
            ));

        $handle = curl_init(TEAMS_WEBHOOK_URL);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)))
        );

        $result = curl_exec($handle);
        curl_close($handle);

        return $result;
    }

}