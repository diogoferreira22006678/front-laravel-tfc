<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Person;
use App\Models\Arduino;
use App\Models\Country;
use App\Models\BindType;
use App\Models\Language;
use App\Models\AdminPerm;

use App\Models\CoverType;
use App\Models\PaperType;
use App\Models\PrintType;
use App\Models\Publisher;
use App\Models\CountryCity;

use Illuminate\Http\Request;
use App\Models\FunctionModel;
use App\Models\ExtraCoverType;
use App\Models\PublicationType;

class SelectController_api extends Controller{
  use \App\Traits\ApiUtils;

  private function search($query, $name, $request){
    $page = $request->page - 1 ?? 0;

    $query = $query->where($name, 'LIKE', '%'.$request->q.'%');

    $count = (clone $query)->count();
    $query = $query->skip($page * self::PAGING)
    ->take(self::PAGING)
    ->get();
    return $this->apiResponseSelect($query, $count, self::PAGING);
  }

  const PAGING = 10;

  public function arduinos(Request $request) {
    $query = Arduino::select('arduino_id as id', 'arduino_name as text');
    return $this->search($query, 'arduino_name', $request);
  }

}
