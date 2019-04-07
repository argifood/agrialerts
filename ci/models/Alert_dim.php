<?php
Class Alert_dim extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('alert_dim', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('alert_dim_id', $data['alert_dim_id']);
        if($this->db->update('alert_dim', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('alert_dim_list');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('agritype_name');
        $this -> db -> order_by('nuts2_name');
        $this -> db -> order_by('nuts3_name');
        $this -> db -> order_by('nuts5_name');
        $query = $this -> db -> get();
        return $query->result_array();
    }

    function getAll() {
        $query = $this -> db -> get('alert_dim');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('alert_dim', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('alert_dim', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
