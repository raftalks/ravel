<?php
/**
	 * API DOCUMENTATION
	 * 
	 * API Controller is the resource API controller for all the resources.
	 * 
	 * User can do following queries to each resource url.
	 * 
	 * Example Resource Items
	 * url: domain.com/items/  										=> list All items
	 * 		domain.com/items/1										=> show item with id 1
	 *   	domain.com/items/?page=1								=> show items for page 1
	 *    	domain.com/items/?page=1&items=10						=> show 10 items for page 1
	 *     	domain.com/items/?search=[search text]					=> search the item resource for the given text
	 *      domain.com/items/?order_by=[field1,field2]&sort=asc 	=> order the items by given fields with comma delimiter and sort either by asc or desc
	 * */

class ApiController extends RavelBaseController
{

	
	protected $moduleName = 'Global';
	protected $resource;
	protected $resource_model_name = '';
	protected $pagingSize = 10;
	protected $resource_with = null;
	protected $serialized_columns = null; //not in use

	protected $queryWhere = null;
	protected $forced_fieldvalues_on_create = null; //can be set to force a field to set with particular value
	protected $forced_fieldvalues_on_update = null; 

	//API Search Request
	protected $search_fields = array();
	protected $search_type = 'like';
	protected $search_template = '%[SEARCHTEXT]%';
	protected $result_sortby = null;
	protected $valid_sort_fields = array();


	//URL Query Strings
	protected $query_sortby = 'order_by';
	protected $query_sort_order = 'sort';
	protected $query_search = 'search';
	protected $query_page = 'page';
	protected $query_page_rows = 'items';
	protected $sort_url_delimiter = ',';
	protected $sort_default_order = 'asc';
	protected $sort_order_types = array('asc','desc');

	protected $Acl;

	//API Response Messages
	protected $delete_message = 'item is now deleted.';

	public function __construct()
	{
		//$this->beforeFilter('auth');
		
		$ACL = $this->Acl = App::make('AccessControl');
		
		$ACL->setModule($this->moduleName);

		$this->beforeFilter(function() use ($ACL)
		{
			if(!$ACL->can_create())
			{
				return Response::make('You do not have permission to create.', 403);
			}

		},array('only'=>array('store')));
		
		$this->beforeFilter(function() use ($ACL)
		{
			if(!$ACL->can_read())
			{
				return Response::make('You do not have permission to read.', 403);
			}

		},array('only'=>array('show','index')));
		
		$this->beforeFilter(function() use ($ACL)
		{
			if(!$ACL->can_update())
			{
				return Response::make('You do not have permission to create.', 403);
			}

		},array('only'=>array('update','edit')));
		

		$this->beforeFilter(function() use ($ACL)
		{
			if(!$ACL->can_delete())
			{
				return Response::make('You do not have permission to create.', 403);
			}

		},array('only'=>array('destroy')));


		//$this->beforeFilter('csrf',array('only'=>array('store','update','destroy')));
		
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$page = Request::query($this->query_page);

		$query = $this->resource;

		if((integer)$page !== 0)
		{
			if(!is_null($page))
			{
				$perPage = Request::query($this->query_page_rows);
				if(is_null($perPage))
				{
					$perPage = $this->pagingSize;
				}
				
				$query = $query->forPage($page, $perPage);
			}
		}

		if(!is_null($this->queryWhere))
		{
			foreach($this->queryWhere as $field => $filtervalue)
			{
				$query = $query->where($field,'=',$filtervalue);
			}

		}

		$searchText = Request::query($this->query_search);
		if(!is_null($searchText))
		{
			$searchType = $this->search_type;
			$template = $this->search_template;
			$phrase = str_replace('[SEARCHTEXT]', $searchText, $template);

			$i = 0;
			foreach($this->search_fields as $field)
			{

				if($i)
				{
					$query = $query->orWhere($field,$searchType,$phrase);	
				}
				else
				{
					$query = $query->where($field,$searchType,$phrase);
				}
				$i++;
				
			}
		}
		
		
		if(!is_null($this->resource_with))
		{
			$query = $query->with($this->resource_with);
		}


		//sorting order
		$sortby = Request::query($this->query_sortby);
		$sortOrder = Request::query($this->query_sort_order);
		if(is_null($sortOrder))
		{
			$sortOrder = $this->sort_default_order;
		}
		else
		{
			if(!in_array($sortOrder, $this->sort_order_types))
			{
				$sortOrder = $this->sort_default_order;
			}
		}

		$sort_array = false;
		$result_sortby = null;

		if(!is_null($sortby))
		{

			$sortby_array = explode($this->sort_url_delimiter, $sortby);
			$sortable_Array = array();
			foreach($sortby_array as $field)
			{
				$sortable_Array[$field] = $sortOrder;
			}

			$result_sortby = $sortable_Array;
		}

		if(is_null($result_sortby))
		{
			$result_sortby = $this->result_sortby;
		}
		
		if(is_array($result_sortby))
		{
			foreach($result_sortby as $field => $order)
			{
				if(in_array($field, $this->valid_sort_fields))
				{
					
					$query = $query->orderBy($field, $order);
					
					
				}
			}
		}

		return  $query->get();
	
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$dataObj = Input::json();
		$data = (array)$dataObj;

		if(!is_null($this->forced_fieldvalues_on_create))
		{
			$fieldstoset = $this->forced_fieldvalues_on_create;
			foreach($fieldstoset as $Key => $setValue)
			{
				$data[$Key] = $setValue;
			}
		}

		$validation = App::make('ModelValidator')->validate($data, $this->resource_model_name);
		
		if($validation->fails())
		{
			$errors = $validation->messages();
			$response = array('errors'=>$errors->all(':message'));
			return Response::json($response, 406);
			
		}

		$resource = $this->resource->newInstance();

		$resource->fill($data);

		if($resource->save())
		{
			return $resource;
		}

		//return error here
	}


	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		return $this->resource->find($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$dataObj = Input::json();
		$data = (array)$dataObj;

		if(!is_null($this->forced_fieldvalues_on_update))
		{
			$fieldstoset = $this->forced_fieldvalues_on_update;
			foreach($fieldstoset as $Key => $setValue)
			{
				$data[$Key] = $setValue;
			}
		}

		$resource = $this->resource->find($id);
		$skip = array();

		$validation = App::make('ModelValidator')->validate($data, $this->resource_model_name,$skip);
		
		if($validation->fails())
		{
			$errors = $validation->messages();
			$response = array('errors'=>$errors->all(':message'));
			return Response::json($response, 406);
			
		}

		$resource->fill($data);

		if($resource->save())
		{
			
			return $resource;
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$item = $this->resource->find($id);
		if(!is_null($item))
		{
			if($item->delete())
			{
				$response = array('message'=>$this->delete_message);
				return Response::json($response, 200);
			}
		}
	}


	public function getUserID()
	{
		$user = $this->Acl->getUser();
		return $user->id;
	}


	

}