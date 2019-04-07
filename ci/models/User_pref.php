<?php
Class User_pref extends CI_Model {
  
    function add($data){
        if ($this -> db -> insert('user_pref', $data)) {
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    function update($data){
        $this->db->where('user_pref_id', $data['user_pref_id']);
        if($this->db->update('user_pref', $data)) {
            return true;
        }
        else {
            return false;
        }
    }

    function dropdown($where = null) {
        $this -> db -> from('user_pref_list');
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
        $query = $this -> db -> get('user_pref');
        return $query->result_array();
    }

    function get($param) {
        $query = $this -> db -> get_where('user_pref', $param, 1);
        return $query->row_array();
    }

    function delete($where) {
       if($this -> db -> delete('user_pref', $where)) {
         return true;
       }
       else {
         return false;
       }
    }

}
?>
