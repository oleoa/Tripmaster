<?php

namespace App\Stays;

use App\Stays\Table;

class Stays extends Table
{
  private $id;
  private $owner;
  private $title;
  private $description;
  private $capacity;
  private $bedrooms;
  private $locale;

  public function format(): void
  {
    $this->id = null;
    $this->owner = null;
    $this->title = null;
    $this->description = null;
    $this->capacity = null;
    $this->bedrooms = null;
    $this->locale = null;
  }

  public function owner($owner = null) { return $this->setAndGet($owner, "owner"); }
  public function title($title = null) { return $this->setAndGet($title, "title"); }
  public function description($description = null) { return $this->setAndGet($description, "description"); }
  public function capacity($capacity = null) { return $this->setAndGet($capacity, "capacity"); }
  public function bedrooms($bedrooms = null) { return $this->setAndGet($bedrooms, "bedrooms"); }
  public function locale($locale = null) { return $this->setAndGet($locale, "locale"); }
}