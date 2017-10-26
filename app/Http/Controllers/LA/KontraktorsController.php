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
use App\Models\Kontraktor;

use App\User;

use App\Role;
use Mail;
use Log;
class KontraktorsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name_perusahaan';
	public $listing_cols = ['id', 'name_perusahaan', 'alamat', 'email_kontraktor', 'no_telepon', 'npwp', 'no_akta', 'siup', 'tahun_berdiri'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Kontraktors', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Kontraktors', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Kontraktors.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Kontraktors');
		
		if(Module::hasAccess($module->id)) {
			return View('la.kontraktors.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new kontraktor.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created kontraktor in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Kontraktors", "create")) {
		
			$rules = Module::validateRules("Kontraktors", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Kontraktors", $request);
            // generate password
            $password = LAHelper::gen_password();

            // Create User
            $user = User::create([
                'name' => $request->name_perusahaan,
                'email' => $request->email_kontraktor,
                'password' => bcrypt($password),
                'context_id' => $insert_id,
                'type' => "Client",
            ]);
            Log::info("User created: username: ".$request->email_kontraktor." Password: ".$password);

            // update user role
            $user->detachRoles();

            $user->attachRole(2);
			return redirect()->route(config('laraadmin.adminRoute') . '.kontraktors.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified kontraktor.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Kontraktors", "view")) {
			
			$kontraktor = Kontraktor::find($id);
			if(isset($kontraktor->id)) {
				$module = Module::get('Kontraktors');
				$module->row = $kontraktor;
				
				return view('la.kontraktors.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('kontraktor', $kontraktor);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("kontraktor"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified kontraktor.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Kontraktors", "edit")) {			
			$kontraktor = Kontraktor::find($id);
			if(isset($kontraktor->id)) {	
				$module = Module::get('Kontraktors');
				
				$module->row = $kontraktor;
				
				return view('la.kontraktors.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('kontraktor', $kontraktor);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("kontraktor"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified kontraktor in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Kontraktors", "edit")) {
			
			$rules = Module::validateRules("Kontraktors", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Kontraktors", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.kontraktors.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified kontraktor from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Kontraktors", "delete")) {
			Kontraktor::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.kontraktors.index');
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
		$values = DB::table('kontraktors')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Kontraktors');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/kontraktors/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Kontraktors", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/kontraktors/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Kontraktors", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.kontraktors.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
