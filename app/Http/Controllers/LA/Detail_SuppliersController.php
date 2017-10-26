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
use Dwij\Laraadmin\Helpers\LAHelper;
use App\User;
use App\Models\Detail_Supplier;
use Mail;
use Log;

class Detail_SuppliersController extends Controller
{
	public $show_action = true;
	public $view_col = 'namaSupplier';
	public $listing_cols = ['id', 'namaSupplier', 'no_telepon', 'nama_toko', 'alamatSupplier', 'emailSupplier'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Detail_Suppliers', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Detail_Suppliers', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Detail_Suppliers.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Detail_Suppliers');
		
		if(Module::hasAccess($module->id)) {
			return View('la.detail_suppliers.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new detail_supplier.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created detail_supplier in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Detail_Suppliers", "create")) {
		
			$rules = Module::validateRules("Detail_Suppliers", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Detail_Suppliers", $request);
            // generate password
            $password = LAHelper::gen_password();

            // Create User
            $user = User::create([
                'name' => $request->namaSupplier,
                'email' => $request->emailSupplier,
                'password' => bcrypt($password),
                'context_id' => $insert_id,
                'type' => "Client",
            ]);

            Log::info("User created: username: ".$request->emailSupplier." Password: ".$password);

            // update user role
            $user->detachRoles();

            $user->attachRole(4);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.detail_suppliers.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified detail_supplier.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Detail_Suppliers", "view")) {
			
			$detail_supplier = Detail_Supplier::find($id);
			if(isset($detail_supplier->id)) {
				$module = Module::get('Detail_Suppliers');
				$module->row = $detail_supplier;
				
				return view('la.detail_suppliers.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('detail_supplier', $detail_supplier);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("detail_supplier"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified detail_supplier.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Detail_Suppliers", "edit")) {			
			$detail_supplier = Detail_Supplier::find($id);
			if(isset($detail_supplier->id)) {	
				$module = Module::get('Detail_Suppliers');
				
				$module->row = $detail_supplier;
				
				return view('la.detail_suppliers.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('detail_supplier', $detail_supplier);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("detail_supplier"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified detail_supplier in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Detail_Suppliers", "edit")) {
			
			$rules = Module::validateRules("Detail_Suppliers", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Detail_Suppliers", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.detail_suppliers.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified detail_supplier from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Detail_Suppliers", "delete")) {
			Detail_Supplier::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.detail_suppliers.index');
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
		$values = DB::table('detail_suppliers')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Detail_Suppliers');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/detail_suppliers/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Detail_Suppliers", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/detail_suppliers/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Detail_Suppliers", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.detail_suppliers.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
