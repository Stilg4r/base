<?php
class RestFullController extends Controller{
	public function __construct($controller,$action)
	{
		parent::__construct($controller, $action);
	}
	protected function jsonResponce($data,$code=200)
	{
		http_response_code($code);
		header('Content-Type: application/json');
		echo json_encode($data);
		exit();
	}
	protected function setter(&$result, $code=200, $data=null, $custom_query = null)
	{
		if (is_null($data)) {
			$data = json_decode(file_get_contents("php://input"),true);
		}
		foreach ($data as $key => $value) {
			$result->set($key,$value);
		}
		try{
			if ($result->save()) {
				if (!is_null($custom_query)) {
					$result = $custom_query->findOne($result->id);
				}
				$this->jsonResponce($result->asArray(),$code);
			}else {
				$this->jsonResponce($result->getErrors(),409);
			}
		}catch (Exception $e) {
			$this->jsonResponce(['error'=>$e],400);
		}
	}
	public function all($query = null, $custom_query = null)
	{
		if (is_null($custom_query)) {
			$model=$this->getModel();
			if (is_array($query)) {
				$result=$model::where($query)->findArray();
			}else{
				$result=$model::findArray();
			}
		} else {
			if (is_array($query)) {
				$result = $custom_query->where($query)->findArray();
			}else{
				$result = $custom_query->findArray();
			}
		}
		if (empty($result)) {
			http_response_code(204);
			exit();
		}
		$this->jsonResponce($result);
	}
	public function create($data = null)
	{
		$model=$this->getModel();
		$result=$model::create();
		if (is_array($data)) {
			$this->setter($result,201,$data);
		} else {
			$this->setter($result,201);
		}
	}
	public function read($id, $query = null, $custom_query = null)
	{
		if (is_null($custom_query)) {
			$model=$this->getModel();
			if (is_array($query)) {
				$result=$model::where($query)->findOne($id);
			} else {
				$result=$model::findOne($id);
			}
		} else {
			if (is_array($query)) {
				$result = $custom_query->where($query)->findOne($id);
			} else {
				$result = $custom_query->findOne($id);
			}
		}
		if ($result) {
			$this->jsonResponce($result->asArray());
		} else {
			http_response_code(404);
			exit();
		}
	}
	public function update($id, $query = null, $data = null)
	{
		$model=$this->getModel();
		if (is_array($query)) {
			$result=$model::where($query)->findOne($id);
		} else {
			$result=$model::findOne($id);
		}
		if ($result) {
			if (is_array($data)) {
				$this->setter($result,200,$data);
			} else {
				$this->setter($result,200);
			}
		} else {
			http_response_code(404);
			exit();
		}
	}
	public function delete($id, $query = null)
	{
		$model=$this->getModel();
		if (is_array($query)) {
			$result=$model::where($query)->findOne($id);
		} else {
			$result=$model::findOne($id);
		}
		if ($result) {
			try{
				if ($result->delete()) {
					http_response_code(200);
				}else{
					$this->jsonResponce($result->getErrors(),409);
				}
			}catch (Exception $e) {
				$this->jsonResponce(['error'=>$e],400);
			}
		} else {
			http_response_code(404);
			exit();
		}
	}
}