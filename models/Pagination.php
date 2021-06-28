<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

class Pagination extends Model{

  public $total = 1;
  public $records = 8;
  public $page = 1;

  public $next = true;
  public $previous = true;

  public $next_page = 1;
  public $previous_page = 1;

  public $display_from = 0;
  public $display_to = 0;

  public $reszta = 0;
  public $total_pages = 0;
  public $min_page = 0;
  public $max_page = 0;

  public $search = "";

  public function generatePagination($params = []){
    $data = Yii::$app->request->get();
    $search_pattern = $data['search'];

    $this->search = $search_pattern;

    $this->total = $params["total"];
    $this->records = $data['records'] ? $data["records"] : ($params['records'] ? $params['records'] : $this->records);
    $this->page = $data['page'] ? $data['page'] : 1;

    $this->next_page = $this->page + 1;
    $this->previous_page = $this->page - 1;

    $this->display_from = $this->records*$this->page - $this->records + 1;
    $this->display_to = $this->records*$this->page;

    $this->total_pages = intval($this->total/$this->records);
    if(($this->total_pages * $this->records) < $this->total) $this->total_pages = $this->total_pages +1;

    $max_to_side = 3;
    $this->min_page = 0;
    $this->max_page = 999999999;

    $add_to_start = 0;
    $add_to_end = 0;
    $this->min_page = $this->page - $max_to_side - $add_to_start > 1 ? $this->page - $max_to_side - $add_to_start : 1;
    $start_diff = $this->page - $this->min_page;
    if($start_diff < $max_to_side) $add_to_end = $max_to_side - $start_diff;

    $this->max_page = $this->page + $max_to_side + $add_to_end < $this->total_pages ? $this->page + $max_to_side + $add_to_end : $this->total_pages;
    $end_diff = $this->max_page - $this->page;
    if($end_diff < $max_to_side) $add_to_start = $max_to_side - $end_diff;

    $this->min_page = $this->page - $max_to_side - $add_to_start > 1 ? $this->page - $max_to_side - $add_to_start : 1;
    $start_diff = $this->page - $this->min_page;

    //
    // echo "Zacznij od ".($this->min_page)."(".$start_diff.") +".$add_to_start."<br>";
    // echo "Obecna strona ".$this->page."<br>";
    // echo "Skoncz na ".($this->max_page). "(".$end_diff.") +".$add_to_end."";
    //
    // die();

    if($this->display_from > $this->total) $this->display_from = $this->total;
    if($this->display_to > $this->total) $this->display_to = $this->total;

    if($this->display_to >= $this->total) $this->next = false;
    if($this->display_from == 1) $this->previous = false;

    return $this;
  }

  public function displayPagination(){
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;

    $pagination = '<div class="custom-pagination py-3 d-flex justify-content-between anim-200">';

        $pagination.= '<a class="pager" href="'.($this->previous ? Url::to([$controller.'/'.$action, 'page' => $this->previous_page, "records" => $this->records, 'search' => $this->search]) : '#').'">';
          $pagination.='<i class="fas fa-chevron-left"></i>';
        $pagination.='</a>';

        $pagination.='<span class="pager-digits">';
          for ($i= $this->min_page; $i < $this->page; $i++) {
            $pagination.="<a href='".Url::to([$controller.'/'.$action, 'page' => $i, "records" => $this->records, 'search' => $this->search])."' class='pagi-tile'>".$i."</a>";
          }

          $pagination.="<a href='#' class='pagi-tile active'>".$this->page."</a>";

          for ($i= $this->page+1; $i <= $this->max_page; $i++) {
            $pagination.="<a href='".Url::to([$controller.'/'.$action, 'page' => $i, "records" => $this->records, 'search' => $this->search])."' class='pagi-tile'>".$i."</a>";
          }

          // $pagination.='Wyświetlono '.$this->display_from.' - '.$this->display_to.'  z '.$this->total;
        $pagination.='</span>';

        $pagination.= '<a class="pager" href="'.($this->next ? Url::to([$controller.'/'.$action, 'page' => $this->next_page, "records" => $this->records, 'search' => $this->search]) : '#').'">';
          $pagination.='<i class="fas fa-chevron-right"></i>';
        $pagination.='</a>';

    $pagination.= '</div>';

    echo $this->total_pages > 1 ? $pagination : "" ;
  }

  public function displayRecordSelector(){
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    $options = array(1,10,20,50,100);

    $selector = '<select class="custom-select" id="records">';
      foreach ($options as $key => $value) {
        $selector .= '<option '.($this->records == $value ? 'selected ' : '').'value="'.$value.'">'.$value.'</option>';
      }
    $selector .= '</select>';

    echo $selector;
  }
}
