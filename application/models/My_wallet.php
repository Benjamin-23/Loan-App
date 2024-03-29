<?php

class My_wallet extends CI_Model {
    /*
      Determines if a given item_id is an item kit
     */

    function exists($wallet_id)
    {
        $this->db->from('wallets');
        $this->db->where('wallet_id', $wallet_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }
    
    function get_total()
    {
        // credit
        $user_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $sql = "SELECT SUM(amount) AS amount FROM ".$this->db->dbprefix("wallets")." WHERE wallet_type = 'credit' AND added_by = ".$user_id;
        $query = $this->db->query($sql);
        $credit = $query->row()->amount;
        
        // debit
        $sql = "SELECT SUM(amount) AS amount FROM ".$this->db->dbprefix("wallets")." WHERE wallet_type = 'debit' AND added_by = ".$user_id;
        $query = $this->db->query($sql);
        $debit = $query->row()->amount;
        
        // transfer to
        $sql = "SELECT SUM(amount) AS amount FROM ".$this->db->dbprefix("wallets")." WHERE wallet_type = 'transfer' AND added_by = ".$user_id." AND transfer_to <> ".$user_id;
        $query = $this->db->query($sql);
        $transfer_to = $query->row()->amount;
        
        // transfer to me
        $sql = "SELECT SUM(amount) AS amount FROM ".$this->db->dbprefix("wallets")." WHERE wallet_type = 'transfer' AND transfer_to = ".$user_id;
        $query = $this->db->query($sql);
        $transfer_to_me = $query->row()->amount;
        
        return $debit - $credit - $transfer_to + $transfer_to_me;
    }

    function get_all($limit = 10000, $offset = 0, $search = "", $order = array())
    {
        $user_id = $this->Employee->get_logged_in_employee_info()->person_id;
        
        $sorter = array(
            "wallet_id",
            "wallet_id",
            "amount",
            "descriptions",
            "trans_date"
        );

        $this->db->from('wallets');

        if ($search !== "")
        {
            $this->db->where('amount LIKE ', '%' . $search . '%');
            $this->db->or_where('descriptions LIKE', '%' . $search . '%');            
        }

        if (isset($_GET['employee_id']) && $_GET['employee_id'] > 0)
        {
            $user_id = $_GET['employee_id'];
        }
        
        if ($user_id !== '1')
        {
            $this->db->where('added_by', $user_id);
            $this->db->or_where('transfer_to', $user_id);
        }
        
        if (count($order) > 0 && $order['index'] < count($sorter))
        {
            $this->db->order_by($sorter[$order['index']], $order['direction']);
        }
        else
        {
            $this->db->order_by("wallet_id", "desc");
        }

        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('wallets');
        return $this->db->count_all_results();
    }

    function get_multiple_wallets($wallet_ids = -1)
    {
        $this->db->from('wallets');
        if ($wallet_ids > -1)
        {
            $this->db->where_in('wallet_id', $wallet_ids);
        }
        return $this->db->get()->result();
    }

    /*
      Gets information about a particular item kit
     */

    function get_info($wallet_id)
    {
        $this->db->from('wallets');
        $this->db->where('wallet_id', $wallet_id);

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
            $fields = $this->db->list_fields('wallets');

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

    function save(&$wallet_data, $wallet_id = false)
    {
        $user_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $wallet_data["added_by"] = $user_id;        
        if (!$wallet_id or ! $this->exists($wallet_id))
        {
            if ($this->db->insert('wallets', $wallet_data))
            {
                $wallet_data['wallet_id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where('wallet_id', $wallet_id);
        return $this->db->update('wallets', $wallet_data);
    }

    /*
      Deletes one item kit
     */

    function delete($wallet_id)
    {
        return $this->db->delete('wallets', array('wallet_id' => $wallet_id));
    }

    /*
      Deletes a list of item kits
     */

    function delete_list($wallet_ids)
    {
        $this->db->where_in('wallet_id', $wallet_ids);
        return $this->db->delete('wallets');
    }

}

?>