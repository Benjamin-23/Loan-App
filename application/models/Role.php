<?php

class Role extends CI_Model {
    /*
      Determines if a given id exist
     */

    function exists($id)
    {
        $this->db->from(strtolower(get_class()) . 's');
        $this->db->where(strtolower(get_class()) . '_id', $id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function get_fields($controller_name)
    {
        return $this->db->list_fields(strtolower($controller_name));
    }

    function get_all($limit = 10000, $offset = 0, $search = "", $order = array())
    {
        $user_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $sorter = $this->get_fields(strtolower(get_class()) . 's');
        $this->db->from(strtolower(get_class()) . 's');

        if ($search !== "")
        {
            // customization needed
            $this->db->where($sorter[1] . ' LIKE ', '%' . $search . '%');
        }
        
        if (isset($_GET['employee_id']) && $_GET['employee_id'] > 0)
        {
            $user_id = $_GET['employee_id'];
        }
        
        if ($user_id !== '1')
        {
            $this->db->where('added_by', $user_id);
        }

        if (count($order) > 0 && $order['index'] < count($sorter))
        {
            $this->db->order_by($sorter[$order['index']], $order['direction']);
        }
        else
        {
            // customization needed
            $this->db->order_by(strtolower(get_class()) . "s_id", "asc");
        }

        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }
    
    function get_all_roles($low_levels = false)
    {
        $user_id = $this->Employee->get_logged_in_employee_info()->person_id;
        
        if ($low_levels)
        {
            $this->db->where_in("role_id", $low_levels);
        }
        
        if ($user_id !== '1')
        {
            $this->db->where('added_by', $user_id);
        }
        
        $query = $this->db->get("roles");
        return $query->result();
    }

    function count_all()
    {
        $this->db->from(strtolower(get_class()) . 's');
        return $this->db->count_all_results();
    }

    function get_multiple($ids = -1)
    {
        $this->db->from(strtolower(get_class()) . 's');
        if ($ids > -1)
        {
            $this->db->where_in(strtolower(get_class()) . '_id', $ids);
        }
        return $this->db->get()->result();
    }

    /*
      Gets information about a particular item kit
     */

    function get_info($id)
    {
        $this->db->from(strtolower(get_class()) . 's');
        $this->db->where(strtolower(get_class()) . '_id', $id);

        $query = $this->db->get();

        if ($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            //Get empty base parent object, as $item_kit_id is NOT an item kit
            $item_obj = new stdClass();

            //Get all the fields from items table
            $fields = $this->db->list_fields(strtolower(get_class()) . 's');

            foreach ($fields as $field)
            {
                $item_obj->$field = '';
            }

            return $item_obj;
        }
    }

    /*
      Inserts or updates an item kit
     */
    function save(&$data, $id = false)
    {
        $user_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $data['added_by'] = $user_id;
        
        if (!$id or ! $this->exists($id))
        {
            unset($data["role_id"]);
            if ($this->db->insert(strtolower(get_class()) . 's', $data))
            {
                $data[strtolower(get_class()) . '_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where(strtolower(get_class()) . '_id', $id);
        return $this->db->update(strtolower(get_class()) . 's', $data);
    }

    /*
      Deletes one item
     */
    function delete($id)
    {
        // though customization if you wish to just have a soft delete
        return $this->db->delete(strtolower(get_class()) . 's', array(strtolower(get_class()) . '_id' => $id));
    }

    /*
      Deletes a list of item kits
     */

    function delete_list($ids)
    {
        // though customization if you wish to just have a soft delete
        $this->db->where_in(strtolower(get_class()) . '_id', $ids);
        return $this->db->delete(strtolower(get_class()) . 's');
    }
    
    /*
     * Function to remove all files related to this plugin
     */
    function remove_files($ids)
    {
        
    }

    function add_plugin()
    {
        // parse or decompress the zip file
    }

    function validate_plugin($plugin)
    {
        $plugin_name = $plugin['plugin']['name'];
        $plugin_desc = isset($plugin['plugin']['description']) ? $plugin['plugin']['description'] : "No description!";

        if (!$this->_exists($plugin_name))
        {
            $data['module_name'] = $plugin_name;
            $data['module_desc'] = $plugin_desc;
            $data['module_files'] = json_encode($plugin['plugin']['files']);
            $this->db->insert(strtolower(get_class()) . 's', $data);
        }
    }

    private function _exists($name)
    {
        $this->db->from(strtolower(get_class()) . 's');
        $this->db->where('module_name', $name);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    public function get_plugin($id)
    {
        $this->db->where("plugin_id", $id);
        $this->db->from(strtolower(get_class()) . "s");
        $query = $this->db->get();

        return $query->row();
    }

    public function register_plugin($plugin_name)
    {
        if (!$this->_module_exists($plugin_name))
        {
            $data = array();
            $data['module_id'] = $plugin_name;
            $data['name_lang_key'] = "module_" . $plugin_name;
            $data['desc_lang_key'] = "module_" . $plugin_name . "_desc";
            $data['icons'] = '<i class="fa fa-smile-o" style="font-size: 50px; color:#FF5400"></i>';
            $data['is_active'] = 1;
            $this->db->insert('modules', $data);

            $data = array();
            $data['permission_id'] = $plugin_name;
            $data['module_id'] = $plugin_name;
            $this->db->insert('permissions', $data);

            $data = array();
            $data['permission_id'] = $plugin_name;
            $data['person_id'] = 1;
            $this->db->insert('grants', $data);

            // execute the file table
            $files = glob(FCPATH . "modules/" . $plugin_name . "/sql/*.*");
            foreach ($files as $file)
            {
                $this->db->query(file_get_contents($file));
            }
        }
    }

    private function _module_exists($plugin_name)
    {
        $this->db->from("modules");
        $this->db->where("module_id", $plugin_name);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }
    
    public function update_status($status, $id)
    {
        $this->db->where("plugin_id", $id);
        $this->db->update(strtolower(get_class()).'s', array("status_flag" => $status));
    }

    public function getStaffs($ids)
    {
        $this->db->where_in("role_id", $ids);
        $results = $this->db->get("roles")->result();
        
        $tmp = array();
        foreach($results as $result):
            $tmp[] = $result->name;        
        endforeach;
        
        return implode(", ", $tmp);
    }
}

?>