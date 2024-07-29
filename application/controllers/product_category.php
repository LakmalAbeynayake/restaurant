<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Product_Category extends CI_Controller
{
    var $main_menu_name = "settings";
    var $sub_menu_name = "categories";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_models');
        $this->load->model('Common_Model');
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('product_category', $data);
    }
    public function add_category()
    {
        $data['id'] = 1;
        $this->load->view('models/create_category', $data);
    }
    public function edit_category($category_id)
    {
        $data['category_details'] = $this->category_models->getCategory_by_id($category_id);
        $this->load->view('models/create_category', $data);
    }
    public function update_category()
    {
        if (!empty($_FILES["userfile"]['name'])) {
            $image_name_enc = time() . $_FILES["userfile"]['name'];
            $this->load->library('upload', $this->image_manipulation->image_config($image_name_enc));
            if (!$this->upload->do_upload()) {
                $st = array('status' => 0, 'validation' => $this->upload->display_errors());
                echo json_encode($st);
            } else {
                $this->load->library('image_lib', $this->image_manipulation->image_thumb($image_name_enc, 100, 100));
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                } else {
                    $imgName    = $this->upload->data();
                    $imageThumb = $imgName['raw_name'] . "_thumb" . $imgName['file_ext'];
                    if ($this->category_models->category_update($this->input->post('category_tbl_id'), $this->input->post('cat_id'), $this->input->post('cat_name'), $imgName['file_name'], $imageThumb, '1',$this->input->post('color'),$this->input->post('bg_color'))) {
                        $st = array('status' => 1, 'validation' => 'Done!');
                        echo json_encode($st);
                    } else {
                        $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
                        echo json_encode($st);
                    }
                    $this->image_lib->clear();
                }
            }
        } else {
            if ($this->category_models->category_update($this->input->post('category_tbl_id'), $this->input->post('cat_id'), $this->input->post('cat_name'), NULL, NULL, '0',$this->input->post('color'),$this->input->post('bg_color'))) {
                $st = array('status' => 1, 'validation' => 'Done!');
                echo json_encode($st);
            } else {
                $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
                echo json_encode($st);
            }
        }
    }
    public function add_subcategory()
    {
        $data = array('getCategory' => $this->category_models->getCategory());
        $this->load->view('models/create_sub_category', $data);
    }
    public function getProduct($value = '')
    {
        $arrayName = array('id' => 123);
        echo json_encode($arrayName);
    }
    public function category_save()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('cat_id', 'Category Code', 'required|is_unique[product_category.cat_code]');
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else {
            if (!empty($_FILES["userfile"]['name'])) {
                $image_name_enc = time() . $_FILES["userfile"]['name'];
                $this->load->library('upload', $this->image_manipulation->image_config($image_name_enc));
                if (!$this->upload->do_upload()) {
                    $st = array('status' => 0, 'validation' => $this->upload->display_errors());
                    echo json_encode($st);
                } else {
                    $this->load->library('image_lib', $this->image_manipulation->image_thumb($image_name_enc, 100, 100));
                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    } else {
                        $imgName    = $this->upload->data();
                        $imageThumb = $imgName['raw_name'] . "_thumb" . $imgName['file_ext'];
                        if ($this->category_models->category_save($this->input->post('cat_id'), $this->input->post('cat_name'), $imgName['file_name'], $imageThumb)) {
                            $st = array('status' => 1, 'validation' => 'Done!');
                            echo json_encode($st);
                        } else {
                            $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
                            echo json_encode($st);
                        }
                        $this->image_lib->clear();
                    }
                }
            } else {
                if ($this->category_models->category_save($this->input->post('cat_id'), $this->input->post('cat_name'), NULL, NULL)) {
                    $st = array('status' => 1, 'validation' => 'Done!');
                    echo json_encode($st);
                } else {
                    $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
                    echo json_encode($st);
                }
            }
        }
    }
    public function getCategory()
    {
        $values = $this->category_models->getCategory();
        $data = array();
        if (!empty($values)) {
            foreach ($values as $categoriy) {
                $k2 = '';
                $m2 = '';
                if ($categoriy->cat_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                if ($categoriy->pos_status == 0) {
                    $k2 = "btn-warning";
                    $m2 = "fa-minus-circle";
                } else {
                    $k2 = "btn-green";
                    $m2 = "fa-check";
                }
                $row = array();
                $row[] = '<div style="margin-bottom: 0px; height: 70px; width: 70px;" class="fileupload-new thumbnail"><img alt="" src="' . asset_url() . "uploads/thumbs/" . $categoriy->cat_image_thumb . '">
                </div>';
                $row[] = strtoupper($categoriy->cat_code);
                $row[] = strtoupper($categoriy->cat_name);
                $row[] = '<a class="btn btn-xs btn-blue" href="' . base_url() . "system_settings/subcategories/" . $categoriy->cat_id . '" data-toggle="modal"><i class="glyphicon fa fa-list"></i></a> <a class="btn btn-xs btn-blue" href="#" data-toggle="modal" onclick="category_edit(' . $categoriy->cat_id . ')"><i class="glyphicon fa fa-edit"></i></a>
                <a class="btn btn-xs ' . $k . '" href="#" data-toggle="modal" onclick="change_status(' . $categoriy->cat_id . ',' . $categoriy->cat_status . ')"><i class="glyphicon fa ' . $m . '"></i></a>
                <a class="btn btn-xs ' . $k2 . '" href="#" data-toggle="modal" onclick="change_pos_status(' . $categoriy->cat_id . ',' . $categoriy->pos_status . ')"> Show on POS: <i class="glyphicon fa ' . $m2 . '"></i></a>
                <a class="btn btn-xs btn-bricky" href="#" data-toggle="modal" onclick="perm_delete(' . $categoriy->cat_id . ')"><i class="glyphicon fa fa-trash-o"></i></a>';
                $data[] = $row;
            }
            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }
    public function category_change_status()
    {
        if ($this->category_models->category_change_status($this->input->post('cat_id'), $this->input->post('status'))) {
            $st = array('status' => 1, 'validation' => 'Done!');
            echo json_encode($st);
        } else {
            $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
            echo json_encode($st);
        }
    }
    public function category_change_pos_status()
    {
        if ($this->category_models->category_change_pos_status($this->input->post('cat_id'), $this->input->post('status'))) {
            $st = array('status' => 1, 'validation' => 'Done!');
            echo json_encode($st);
        } else {
            $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
            echo json_encode($st);
        }
    }
    public function category_permanent_delete()
    {
        if ($this->category_models->category_permanent_delete($this->input->post('cat_id'))) {
            $st = array('status' => 1, 'validation' => 'Done!');
            echo json_encode($st);
        } else {
            $st = array('status' => 0, 'validation' => 'cannot delete parent category with children categorys existing');
            echo json_encode($st);
        }
    }
    //sub category module function begin
    public function category_sub_save()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('parent_category', 'parent category', 'required');
        $this->form_validation->set_rules('cat_code', 'Category Code', 'required|is_unique[product_category.cat_code]');
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array('status' => 0, 'validation' => validation_errors());
            echo json_encode($st);
        } else {
            if ($this->category_models->category_sub_save($this->input->post('parent_category'), $this->input->post('cat_code'), $this->input->post('cat_name'))) {
                $st = array('status' => 1, 'validation' => 'Done!');
                echo json_encode($st);
            } else {
                $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
                echo json_encode($st);
            }
        }
    }
    //var $parent_category_id;
    public function subcategories($parent_category_id = '')
    {
        //$this->parent_category_id = $parent_category_id;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
        $data['sub_categorys'] = $this->category_models->getCategory();
        $data['parent_cat_id'] = $parent_category_id;
        $this->load->view('subcategory', $data);
    }
    public function get_sub_Category($parent_category_id)
    {
        $values = $this->category_models->get_sub_category($parent_category_id);
        $data = array();
        if (!empty($values)) {
            foreach ($values as $categoriy) {
                $row = array();
                $row[] = strtoupper($categoriy->sub_cat_code);
                $row[] = strtoupper($categoriy->sub_cat_name);
                $row[] = strtoupper($categoriy->cat_name);
                $row[] = '<a class="btn btn-xs btn-blue" href="#" data-toggle="modal" onclick="sub_category_edit(' . $categoriy->sub_cat_id . ')"><i class="glyphicon fa fa-edit"></i></a>
                <a class="btn btn-xs btn-bricky" href="#" data-toggle="modal" onclick="sub_perm_delete(' . $categoriy->sub_cat_id . ')"><i class="glyphicon fa fa-trash-o"></i></a>';
                $data[] = $row;
            }
            $output = array('data' => $data);
            echo json_encode($output);
        } else {
            $output = array('data' => '');
            echo json_encode($output);
        }
    }
    public function edit_sub_category($category_id = "")
    {
        $data['sub_category_details'] = $this->category_models->get_sub_Category_by_id($category_id);
        $data['getCategory']          = $this->category_models->getCategory();
        $this->load->view('models/create_sub_category', $data);
    }
    public function sub_category_permanent_delete()
    {
        if ($this->category_models->sub_category_permanent_delete($this->input->post('sub_cat_id'))) {
            $st = array('status' => 1, 'validation' => 'Done!');
            echo json_encode($st);
        } else {
            $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
            echo json_encode($st);
        }
    }
    public function update_sub_category()
    {
        if ($this->category_models->sub_category_update($this->input->post('parent_category'), $this->input->post('sub_category_tbl_id'), $this->input->post('cat_code'), $this->input->post('cat_name'))) {
            $st = array('status' => 1, 'validation' => 'Done!');
            echo json_encode($st);
        } else {
            $st = array('status' => 0, 'validation' => 'error occurred please contact your system administrator');
            echo json_encode($st);
        }
    }
    //sub category module function end
}