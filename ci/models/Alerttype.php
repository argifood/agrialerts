<?php
Class Alerttype extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('alerttype', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('alerttype_id', $data['alerttype_id']);
        if($this->db->update('alerttype', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('alerttype');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('alerttype_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['alerttype_id']] = $row['alerttype_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('alerttype');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('alerttype', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('alerttype', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
