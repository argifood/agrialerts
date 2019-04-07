<?php
Class Nuts2 extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('nuts2', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('nuts2_id', $data['nuts2_id']);
        if($this->db->update('nuts2', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('nuts2');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('nuts2_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['nuts2_id']] = $row['nuts2_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('nuts2');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('nuts2', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('nuts2', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
