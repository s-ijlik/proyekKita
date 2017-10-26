<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Detail_Proyek;

class Detail_ProyeksController extends Controller
{
	public $show_action = true;
	public $view_col = 'kamarTidur';
	public $listing_cols = ['id', 'kamarTidur', 'kamarMandi', 'luasTanah', 'luasBangunan', 'jumlahLantai', 'garasi', 'gambar'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Detail_Proyeks', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Detail_Proyeks', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Detail_Proyeks.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Detail_Proyeks');
		
		if(Module::hasAccess($module->id)) {
			return View('la.detail_proyeks.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new detail_proyek.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created detail_proyek in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Detail_Proyeks", "create")) {
		
			$rules = Module::validateRules("Detail_Proyeks", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Detail_Proyeks", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.detail_proyeks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified detail_proyek.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Detail_Proyeks", "view")) {
			
			$detail_proyek = Detail_Proyek::find($id);
			if(isset($detail_proyek->id)) {
				$module = Module::get('Detail_Proyeks');
				$module->row = $detail_proyek;
				
				return view('la.detail_proyeks.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('detail_proyek', $detail_proyek);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("detail_proyek"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified detail_proyek.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Detail_Proyeks", "edit")) {			
			$detail_proyek = Detail_Proyek::find($id);
			if(isset($detail_proyek->id)) {	
				$module = Module::get('Detail_Proyeks');
				
				$module->row = $detail_proyek;
				
				return view('la.detail_proyeks.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('detail_proyek', $detail_proyek);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("detail_proyek"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified detail_proyek in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Detail_Proyeks", "edit")) {
			
			$rules = Module::validateRules("Detail_Proyeks", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Detail_Proyeks", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.detail_proyeks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified detail_proyek from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Detail_Proyeks", "delete")) {
			Detail_Proyek::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.detail_proyeks.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('detail_proyeks')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Detail_Proyeks');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/detail_proyeks/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Detail_Proyeks", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/detail_proyeks/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Detail_Proyeks", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.detail_proyeks.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
