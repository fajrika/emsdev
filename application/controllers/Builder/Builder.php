<?php

// use Custom\Libraries\Element;
use custom\Libraries\Element;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/Element.php';
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File Element not found

class Builder extends Element
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        if (!$this->m_login->status_login())
            redirect(site_url());
        $this->load->model('m_coa');
        $this->load->model('m_core');
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
    }
    public function index()
    {
        $this->theme("layouts/admin_gentelella");
        $this->title_submenu("Builder > Prototipe V 1.0");
        // $this->content("proyek/report/exam/index");
        $this->content("builder/index");
        $this->css("layouts/css/dataTables");
        $this->css("layouts/css/dataTables");
        $this->js("layouts/js/dataTables");
        $this->js("builder/indexJS");
        $this->render();
    }
    public function ajax_builder()
    {
        $rows = $this->input->post()['item'];
        $builder = "
                <div class='col-md-12'>
                    <div class='x_panel'>
                        <div class='x_title'>
                            <h2>Result Builder - Preview</h2>
                            <div class='clearfix'></div>
                        </div>
                        <div class='x_content'>
                            <div class='row'>
                                <form class='col-md-12'>";
        foreach ($rows as $columns) {
            $builder = $builder . "
                                    <div class='col-md-12'>";
            foreach ($columns as $item) {
                $len = 12 / count($columns);
                $builder = $builder . "
                                        <div class='col-md-$len'>";
                foreach ($item as $row_item) {
                    $row_item = (object)$row_item;
                    $builder = $builder . "
                                            <div class='item form-group'>
                                                <label class='control-label col-md-1 col-sm-1 col-xs-12'>
                                                    $row_item->label
                                                </label>
                                                <div class='col-md-11 col-sm-11 col-xs-12'>";
                    // echo ('<pre>');
                    // print_r($row_item);
                    // echo ('</pre>');
                    if ($row_item->tag == 'input') {
                        $builder = $builder . "<input id='$row_item->id' class='form-control col-md-12 $row_item->class' type='$row_item->tipe' name='$row_item->name' value='$row_item->value' $row_item->attribut>";
                    }
                    if ($row_item->tag == 'textarea') {
                        $builder = $builder . "<textarea id='$row_item->id' class='form-control col-md-12 $row_item->class' type='$row_item->tipe' name='$row_item->name' $row_item->attribut>$row_item->value</textarea>";
                    }
                    if ($row_item->tag == 'select') {
                        $builder = $builder . "<select id='$row_item->id' class='form-control col-md-12 $row_item->class' name='$row_item->name' $row_item->attribut>
                                                    <option selected disabled>.:: Manual Option ::.</option>$row_item->value</select>";
                    }
                    if ($row_item->tag == 'button') {
                        $builder = $builder . "<button id='$row_item->id' class='form-control col-md-12 $row_item->class' name='$row_item->name' $row_item->attribut>$row_item->value</button>";
                    }
                    $builder = $builder . "
                                                </div>
                                            </div>";
                }
                $builder = $builder . "
                                        </div>";
            }
            $builder = $builder . "
                                    </div>";
        }
        $builder = $builder . "
                            </form>
                        </div>
                    </div>
                </div>
            </div>";
        echo ($builder);
    }
}
