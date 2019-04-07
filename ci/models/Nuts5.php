<?php
Class Nuts5 extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('nuts5', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('nuts5_id', $data['nuts5_id']);
        if($this->db->update('nuts5', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('nuts5');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('nuts5_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['nuts5_id']] = $row['nuts5_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('nuts5');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('nuts5', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('nuts5', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
