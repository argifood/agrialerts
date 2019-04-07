<?php
Class Agency extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('agency', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('agency_id', $data['agency_id']);
        if($this->db->update('agency', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('agency');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('agency_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['agency_id']] = $row['agency_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('agency');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('agency', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('agency', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
