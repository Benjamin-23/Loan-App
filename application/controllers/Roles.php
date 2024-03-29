<?php

require_once ("Secure_area.php");
require_once ("interfaces/idata_controller.php");

class Roles extends Secure_area implements iData_controller {

    private $_model;
    private $_model_name;

    function __construct()
    {
        parent::__construct(strtolower(get_class()));
        $model_name = ucfirst(str_replace("s", "", get_class()));
        $this->load->model($model_name);
        $this->_model = $this->$model_name;
        $this->_model_name = strtolower($model_name);
    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $res = $this->Employee->getLowerLevels();
        $data['staffs'] = $res;
        // just make sure that controller name is equivalent to the table name in database
        $data['fields'] = $this->_model->get_fields($data['controller_name']);
        $this->load->view($data['controller_name'] . '/manage', $data);
    }

    function view($id = -1)
    {
        $controller_name = strtolower(get_class());
        $data['info'] = $this->_model->get_info($id);
        $data['low_levels'] = json_decode($data['info']->low_level, TRUE);
        $data['low_levels'] = is_array($data['low_levels']) ? $data['low_levels'] : array();
        $access_rights = json_decode($data["info"]->rights, TRUE);
        $module_ids = [];
        foreach($access_rights as $right)
        {
            $this->db->where("permission_id", $right);
            $query = $this->db->get("permissions");
            
            if ($query->num_rows() > 0)
            {
                $module_ids[] = $right;
            }
        }
        $data['module_ids'] = $module_ids;
        
        $query = $this->db->get("permissions");
        $permission_ids = [];
        if ($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $permission_ids[] = $row->permission_id;
            }
        }
        $data["permission_ids"] = $permission_ids;
        
        $data['id'] = $id;
        
        $data['roles'] = $this->_model->get_all_roles();
        
        $data['all_modules'] = $this->Module->get_all_modules();
        $data['all_subpermissions'] = $this->Module->get_all_subpermissions();
        $data['controller_name'] = $controller_name;
        $this->load->view($controller_name . "/form", $data);
    }

    function save($id = -1)
    {
        $data["role_id"] = $id;
        $data["name"] = $this->input->post("role_name");
        $data["low_level"] = json_encode($this->input->post("low_level"));
        
        $tmp_rights = $this->input->post("rights");
        $rights = [];
        foreach($tmp_rights as $right)
        {
            $this->db->where("permission_id", $right);
            $query = $this->db->get("permissions");
            
            if ($query->num_rows() > 0)
            {
                $rights[] = $right;
            }
        }
        
        $data["rights"] = json_encode($rights);

        if ($this->_model->save($data, $id))
        {
            //New
            if ($id == -1)
            {
                echo json_encode(array('success' => true, 'message' => $this->lang->line(strtolower(get_class()) . '_successful_adding') . ' ' .
                    $data[$this->_model_name . '_id'], $this->_model_name . '_id' => $data[$this->_model_name . '_id']));
                $id = $data[$this->_model_name . '_id'];
            }
            else //previous item
            {
                echo json_encode(array('success' => true, 'message' => $this->lang->line(strtolower(get_class()) . '_successful_updating') . ' ' .
                    $data[$this->_model_name . '_id'], $this->_model_name . '_id' => $id));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(strtolower(get_class()) . '_error_adding_updating') . ' ' .
                $data[$this->_model_name . '_id'], $this->_model_name . '_id' => -1));
        }
    }

    function delete()
    {
        $ids = $this->input->post('ids');
        $controller_name = strtolower(get_class());

        if ($this->_model->delete_list($ids))
        {
            echo json_encode(array('success' => true, 'message' => $this->lang->line($controller_name . '_successful_deleted') . ' ' .
                count($ids) . ' ' . $this->lang->line($controller_name . '_one_or_multiple')));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => $this->lang->line('loan_type_cannot_be_deleted')));
        }
    }

    function data()
    {
        $index = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 1;
        $dir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : "asc";
        $order = array("index" => $index, "direction" => $dir);
        $length = isset($_GET['length']) ? $_GET['length'] : 50;
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $key = isset($_GET['search']['value']) ? $_GET['search']['value'] : "";

        $controller_name = strtolower(get_class());
        $$controller_name = $this->_model->get_all($length, $start, $key, $order);

        $id = strtolower(str_replace("s", "", $controller_name) . "_id");
        $format_result = array();

        $fields = $this->_model->get_fields(ucfirst($controller_name));

        foreach ($$controller_name->result() as $data)
        {
            $tmp = array();
            $tmp[] = "<input type='checkbox' name='chk[]' class='select_' id='" . $controller_name . "_" . $data->$id . "' value='" . $data->$id . "'/>";
            foreach ($fields as $field)
            {
                if ($field === 'low_level')
                {
                    if ($data->$field !== "false")
                    {
                        $tmp[] = $this->_model->getStaffs(json_decode($data->$field, TRUE));
                    }
                    else
                    {
                        $tmp[] = "";
                    }
                }
                else if ($field === 'rights')
                {
                    if ($data->$field !== "false")
                    {
                        $access_rights = json_decode($data->$field, TRUE);
                        $tmp_access_rights = [];
                        foreach($access_rights as $rights)
                        {
                            $this->db->where("permission_id", $rights);
                            $query = $this->db->get("permissions");
                            if ($query->num_rows() > 0)
                            {
                                $tmp_access_rights[] = $rights;                                
                            }
                        }
                        $tmp[] = implode(", ", $tmp_access_rights);
                    }
                    else
                    {
                        $tmp[] = "";
                    }
                }
                else if($field === 'added_by')
                {
                    $emp = $this->Employee->get_info($data->$field);
                    $tmp[] = (isset($emp->first_name) ? ucwords($emp->first_name." ".$emp->last_name) : "");
                }
                else
                {
                    $tmp[] = $data->$field;
                }
                
            }

            $action = array();

            $action[] = anchor($controller_name . '/view/' . $data->$id, $this->lang->line('common_edit'), array('class' => 'btn btn-success', "title" => $this->lang->line($controller_name . '_update')));

            $tmp[] = implode("&nbsp", $action);

            $format_result[] = $tmp;
        }

        $data = array(
            "recordsTotal" => $this->_model->count_all(),
            "recordsFiltered" => $this->_model->count_all(),
            "data" => $format_result
        );

        echo json_encode($data);
        exit;
    }

    public function get_row()
    {
        
    }

    public function search()
    {
        
    }

    public function suggest()
    {
        
    }

    public function get_form_width()
    {
        
    }

    public function upload()
    {
        $directory = FCPATH . "modules/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $module_id = $this->_model->add_plugin($data);

        // decompress the archive file
        $decompress = $this->_decompress($data['filename']);

        echo json_encode(array("filename" => $data['filename'], "module_id" => $module_id, "decompress" => $decompress));
        exit;
    }

    private function _decompress($file)
    {
        // get the absolute path to $file
        $path = FCPATH . "modules/";
        $file = FCPATH . "modules/" . $file;

        $zip = new ZipArchive;
        $res = $zip->open($file);
        if ($res === TRUE)
        {
            // extract it to the path we determined above
            $zip->extractTo($path);
            $zip->close();
            return true;
        }

        return false;
    }

    public function activate($id)
    {
        $data = $this->_model->get_plugin($id);

        $files = json_decode($data->module_files, true);

        $plugin_name = $data->module_name;

        $controllers = $files['controllers'];

        $this->_move_files($controllers, 'controllers', $plugin_name);

        $models = $files['models'];

        $this->_move_files($models, 'models', $plugin_name);

        $views = $files['views'];

        $this->_move_files($views, 'views', $plugin_name);

        $language = $files['language'];

        $this->_move_files($language, 'language', $plugin_name);

        $js = $files['js'];

        $this->_move_files($js, 'js', $plugin_name);

        // finally, let's save to database;
        $this->_model->register_plugin($plugin_name);

        // update status as active
        $this->_model->update_status("active", $id);

        //var_dump($data);
    }

    private function _move_files($arr, $type, $plugin_name)
    {
        foreach ($arr as $path)
        {
            if (strpos($path, '*') !== false)
            {
                $src = 'modules/' . $plugin_name;
                $dest = 'application';
                $files = glob(FCPATH . "modules/" . $plugin_name . str_replace("*", "", $path) . "*.*");
                foreach ($files as $file)
                {
                    $file_to_go = str_replace($src, $dest, $file);

                    $dir = str_replace($src, $dest, dirname($file));
                    if (!file_exists($dir))
                    {
                        @mkdir($dir);
                    }
                    copy($file, $file_to_go);
                }
            }
        }
    }

}

?>