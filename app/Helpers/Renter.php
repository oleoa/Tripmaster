<?php 

namespace App\Helpers;

use Carbon\CarbonPeriod;
use Carbon\Carbon;

class Renter
{
  private $dbRents;
  private $projectStart;
  private $projectEnd;

  public function dbRents($rents)
  {
    $this->dbRents = $rents;
  }

  public function projectStart($date)
  {
    $this->projectStart = $date;
  }

  public function projectEnd($date)
  {
    $this->projectEnd = $date;
  }

  private function checkConflict($period1, $period2)
  {
    
  }

  public function canRent()
  {
    /**
     * Para verificar se pode ser alugado, é necessário verificar se o período
     * de aluguel está dentro do período do projeto e se não há conflito com
     * outros aluguéis.
     * 
     * Para verificar se há conflito, é necessário verificar se o período de
     * aluguel está dentro de algum período de aluguel já cadastrado no banco
     * de dados.
     */

    $P_period = CarbonPeriod::create($this->projectStart, $this->projectEnd);
    $DB_periods = array();
    foreach($this->dbRents as $rent)
      $DB_periods[] = CarbonPeriod::create($rent['start_date'], $rent['end_date']);
    
    $canRent = array();
    foreach($DB_periods as $DB_period)
      $canRent[] = $this->checkConflict($P_period, $DB_period);
    
    return $canRent;
  }
}
