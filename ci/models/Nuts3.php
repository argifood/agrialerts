<?php
Class Nuts3 extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('nuts3', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('nuts3_id', $data['nuts3_id']);
        if($this->db->update('nuts3', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('nuts3');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('nuts3_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['nuts3_id']] = $row['nuts3_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('nuts3');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('nuts3', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('nuts3', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
