<?php

namespace App\Classes;

use App\Classes\Table;

class Project extends Table
{
  private $id;
  private $owner;
  private $title;
  private $country;
  private $date;
  private $headcount;

  public function format(): void
  {
    $this->id = null;
    $this->owner = null;
    $this->title = null;
    $this->country = null;
    $this->date = null;
    $this->headcount = null;
  }

  public function owner($owner = null) { return $this->setAndGet($owner, "owner"); }
  public function title($title = null) { return $this->setAndGet($title, "title"); }
  public function country($country = null) { return $this->setAndGet($country, "country"); }
  public function date($date = null) { return $this->setAndGet($date, "date"); }
  public function headcount($headcount = null) { return $this->setAndGet($headcount, "headcount"); }
}