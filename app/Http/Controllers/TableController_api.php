<?php
namespace App\Http\Controllers;

use App\Utils;
use App\Models\Tag;

use App\Models\Book;
use App\Models\Page;
use App\Models\Admin;
use App\Models\Person;
use App\Models\BindType;
use App\Models\AdminPerm;
use App\Models\CoverType;
use App\Models\PaperType;
use App\Models\PrintType;
use App\Models\Publisher;
use App\Models\Collection;
use App\Models\CountryCity;
use Illuminate\Http\Request;
use App\Models\FunctionModel;
use App\Models\ExtraCoverType;
use App\Models\PublicationType;
use App\Models\AdminPermRelation;

class TableController_api extends Controller{
  use \App\Traits\ApiUtils;

  /* Utils */
  private function searchQuery($query, $request){
    $q = $request['search']['value'];
    if($q == null) return;


    $parts = preg_split("/\\s+/", $q);
    foreach($parts as $q){
      $q = strtolower("%$q%");

      $query->where(function($query) use ($request, $q){
        $where = 'where';
        foreach($request['columns'] as $col){
          if($col['searchable'] === 'false') continue;
          if($col['name'] === null) continue;

          $parts = explode('.', $col['name']);
          if(count($parts) > 1){
            $useWhere = true;
            $recurse = function($query) use (&$parts, $request, $q, $where, &$useWhere, &$recurse, &$www){
              $first = array_shift($parts);

              if(reset($parts) !== false){
                $w = $useWhere?$where.'Has':'whereHas';
                $useWhere = false;
                $www[] = $w;
                $first = Utils::toCamelCase($first);
                $query->{$w}($first, function($query) use (&$recurse){
                  $recurse($query);
                });
              }else{
                $query->where($first, 'LIKE', $q);
              }
            };
            $recurse($query);
          }else{
            $query->{$where}($parts[0], 'LIKE', $q);
          }

          $where = 'orWhere';
        }
      });
    }
  }
  private function searchOrder($query, $request){
    foreach($request['order'] as $o){
      $col = $request['columns'][$o['column']];
      $parts = explode('.', $col['name']);
      if(count($parts) > 1){
        // TODO make it work with deeper relations (currently 1 deep)
        $model = $query->getModel();
        $p0 = $parts[0];
        $p0 = Utils::toCamelCase($p0);
        $p1 = $parts[1];
        $q = $model::whereHas($p0, function($query) use ($p1){$query->select($p1);});

        $matches = [];
        preg_match('/\((.+)\)/', $q->toSql(), $matches);
        $q = '('.$matches[1].' limit 1)';
        $query->orderBy(\DB::raw($q), $o['dir']);
      }else{
        $query->orderBy($col['name'], $o['dir']);
      }
    }
  }
  private function searchLimit($query, $request){
    $start = $request['start'];
    $length = $request['length'];
    $query->skip($start)->take($length);
  }
  private function search($query, $request){
    $count = $query->count();
    $query->addSelect('*');
    $this->searchQuery($query, $request);
    $countFiltered = (clone $query)->count();
    $this->searchOrder($query, $request);
    $this->searchLimit($query, $request);

    // dd($query->toSql(), $request->input());

    return $this->rawApiResponse([
      'draw' => $request['draw'],
      'recordsTotal' => $count,
      'recordsFiltered' => $countFiltered,
      'data' => $query->get()
    ]);
  }

  /* Calls */
  public function books(Request $request){
    $query = Book::with('publishers', 'authors');
    return $this->search($query, $request);
  }
  public function coverTypes(Request $request){
    $query = CoverType::query();
    return $this->search($query, $request);
  }
  public function bindTypes(Request $request){
    $query = BindType::query();
    return $this->search($query, $request);
  }
  public function extraCoverTypes(Request $request){
    $query = ExtraCoverType::query();
    return $this->search($query, $request);
  }
  public function paperTypes(Request $request){
    $query = PaperType::query();
    return $this->search($query, $request);
  }
  public function printTypes(Request $request){
    $query = PrintType::query();
    return $this->search($query, $request);
  }
  public function publicationTypes(Request $request){
    $query = PublicationType::query();
    return $this->search($query, $request);
  }
  public function countryCities(Request $request){
    $query = CountryCity::with('country');
    return $this->search($query, $request);
  }
  public function people(Request $request){
    $query = Person::query();
    return $this->search($query, $request);
  }
  public function publishers(Request $request){
    $query = Publisher::query();
    return $this->search($query, $request);
  }
  public function functions(Request $request){
    $query = FunctionModel::query();
    return $this->search($query, $request);
  }
  public function tags(Request $request){
    $query = Tag::query();
    return $this->search($query, $request);
  }
  public function users(Request $request){
    $query = Admin::with('perm');
    return $this->search($query, $request);
  }
  public function perms_relations(Request $request){
    $query = AdminPermRelation::with('perm');
    return $this->search($query, $request);
  }
  public function perms(Request $request){
    $query = AdminPerm::with('relations');
    return $this->search($query, $request);
  }
  public function pages(Request $request){
    $query = Page::query();
    return $this->search($query, $request);
  }
  public function collections(Request $request){
    $query = Collection::query();
    return $this->search($query, $request); 
  }
}
