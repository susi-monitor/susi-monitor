<?php

class Data_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_data()
    {
        $this->db->order_by('datetime', 'DESC');

        $dateLimitInThePast = date('U', strtotime('-1 hour'));
        //get a maximum 1 hour in the past condition here

        $query = $this->db->where('datetime >', $dateLimitInThePast)
            ->get('data');
        $result = $query->result_array();


        $resultSorted = array();

        foreach ($result as &$res) {
            if($res['response_time'] === null){
                $res['response_time'] = 0;
            }
            $resultSorted[$res['target_id']][] = $res;
        }

        return $resultSorted;
    }

    public function get_data_by_target_id($target_id, $dateLimit = '-48 hours')
    {
        $this->db->order_by('datetime', 'DESC');

        $dateLimitInThePast = date('U', strtotime($dateLimit));
        //get a maximum 1 hour in the past condition here

        $queryParamsArray = ['datetime >' => $dateLimitInThePast, 'target_id =' => $target_id];
        $query = $this->db->where($queryParamsArray)
            ->get('data');
        $result = $query->result_array();


        $resultSorted = array();

        foreach ($result as &$res) {
            if($res['response_time'] === null){
                $res['response_time'] = 0;
            }
            $resultSorted[$res['target_id']][] = $res;
        }

        return $resultSorted;
    }

    public function last_seen($target_id)
    {
        $this->db->order_by('datetime', 'DESC');

        $queryParamsArray = ['status' => '1', 'target_id =' => $target_id];
        $query = $this->db->where($queryParamsArray)
            ->get('data');
        $result = $query->result_array();

        if (count($result) === 0){
            return 0;
        }

        $resultSorted = array();

        foreach ($result as &$res) {
            if($res['response_time'] === null){
                $res['response_time'] = 0;
            }
            $resultSorted[$res['target_id']][] = $res;
        }

        return $resultSorted[$target_id][1]['datetime'];
    }

    public function insert_check_data($tagetId, $status, $datetime, $responseTime, $timeoutReached)
    {
        $data = array(
            'target_id' => $tagetId,
            'status'  => $status,
            'datetime'  => $datetime,
            'response_time' => $responseTime,
            'timeout_reached' => $timeoutReached
        );

        return $this->db->insert('data', $data);
    }

    public function purge_old_data()
    {
        $datetime48hInThePast = date('U', strtotime('-48 hours'));
        $this->db->where('datetime <', $datetime48hInThePast);

        return $this->db->delete('data');
    }
}