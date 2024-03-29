<?php

class Person extends CI_Model {
    /* Determines whether the given person exists */

    function exists($person_id)
    {
        $this->db->from('people');
        $this->db->where('people.person_id', $person_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    /* Gets all people */

    function get_all($limit = 10000, $offset = 0)
    {
        $this->db->from('people');
        $this->db->order_by("last_name", "asc");
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('people');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a person as an array.
     */

    function get_info($person_id)
    {
        $query = $this->db->get_where('people', array('person_id' => $person_id), 1);

        if ($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            //create object with empty properties.
            $fields = $this->db->list_fields('people');
            $person_obj = new stdClass;

            foreach ($fields as $field)
            {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    /*
      Get people with specific ids
     */

    function get_multiple_info($person_ids)
    {
        $this->db->from('people');
        $this->db->where_in('person_id', $person_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates a person
     */

    function save(&$person_data, &$custom_data = [], $person_id = false, &$financial_data = array())
    {
        if (!$this->exists($person_id))
        {
            if ($this->db->insert('people', $person_data))
            {
                $person_data['person_id'] = $this->db->insert_id();
                $this->move_photo($person_data);
                return true;
            }
            return false;
        }

        if ($person_id)
        {
            $this->db->where('person_id', $person_id);
            return $this->db->update('people', $person_data);
        }
        
        return false;
    }

    function get_search_suggestions($search, $limit = 25)
    {
        $suggestions = array();
        $by_person_id = $this->db->get();

        foreach ($by_person_id->result() as $row)
        {
            $suggestions[] = $row->person_id;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Deletes one Person (doesn't actually do anything)
     */

    function delete($person_id)
    {
        return true;
        ;
    }

    /*
      Deletes a list of people (doesn't actually do anything)
     */

    function delete_list($person_ids)
    {
        return true;
    }

    function move_photo($person_data)
    {
        $data = $this->session->userdata('data');

        if (trim($data['filename']) !== "")
        {
            $tmp_dir = FCPATH . "uploads/profile-/";
            $user_dir = FCPATH . "uploads/profile-" . $person_data['person_id'] . "/";

            if (!file_exists($user_dir))
            {
                // temporary set to full access
                @mkdir($user_dir);
            }

            $target_dist = $user_dir . $data['filename'];
            @copy($tmp_dir . $data['filename'], $target_dist);

            @unlink($tmp_dir . $data['filename']);

            $this->save_photo($person_data['person_id'], $data);
        }
        
        $this->session->set_userdata(array("data" => null));
    }

    function save_photo($person_id, $data)
    {
        $this->db->where('person_id', $person_id);
        return $this->db->update('people', array("photo_url" => $data['filename']));
    }

}

?>
