<?php
Class Agritype extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('agritype', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('agritype_id', $data['agritype_id']);
        if($this->db->update('agritype', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('agritype');
        if($where){
          $this -> db -> where($where);
        }
        $this -> db -> order_by('agritype_name');
        $query = $this -> db -> get();
        $result = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $result[$row['agritype_id']] = $row['agritype_name'];
            }
        }
        return $result;
    }

    function getAll() {
        $query = $this -> db -> get('agritype');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('agritype', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('agritype', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
