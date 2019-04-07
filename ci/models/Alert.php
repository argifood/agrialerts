<?php
Class Alert extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('alert', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('alert_id', $data['alert_id']);
        if($this->db->update('alert', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('alert');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('alert_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['alert_id']] = $row['alert_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('alert');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('alert', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('alert', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
