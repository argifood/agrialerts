<?php

namespace App;
require 'db.php';
use Auth0\SDK\JWTVerifier;
class Main {

  protected $token;
  protected $tokenInfo;

  public function setCurrentToken($token) {

    try {
      $verifier = new JWTVerifier([
        'supported_algs' => ['RS256'],
        'valid_audiences' => ['https://alerts.quercus.com.gr'],
        'authorized_iss' => ['https://quercus.eu.auth0.com/']
      ]);

      $this->token = $token;
      $this->tokenInfo = $verifier->verifyAndDecode($token);
    }
    catch(\Auth0\SDK\Exception\CoreException $e) {
      throw $e;
    }
  }

/*******************************
*-----------ALERTS-------------*
*******************************/
  public function alertsEndpoint() {
		$sql="SELECT 
		`alert_api_list`.*
		FROM 
		`alert_api_list`";
		try {
			$db = getDB();
			$stmt = $db->query($sql);
			$alerts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($alerts);
	}

  	public function userAlertsEndpoint($user_id) {
		$sql="SELECT 
		`alert_api_pref_list`.*
		FROM 
		`alert_api_pref_list`
		 WHERE `user_id`=:id";
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $user_id, \PDO::PARAM_INT);
			$stmt->execute();
			$alerts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($alerts);
	}

/*******************************
*----------OBSERVATIONS--------*
*******************************/  
  public function obsEndpoint() {
		$sql="SELECT 
		`observations_api_list`.*
		FROM 
		`observations_api_list`";
		try {
			$db = getDB();
			$stmt = $db->query($sql);
			$alerts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($alerts);
	}

  	public function userObsEndpoint($user_id) {
		$sql="SELECT 
		`observation_api_pref_list`.*
		FROM 
		`observation_api_pref_list`
		 WHERE `agency_name`=:id";
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $user_id, \PDO::PARAM_INT);
			$stmt->execute();
			$alerts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($alerts);
	}
    
  public function userAddObsEndpoint() {
    $input = json_decode($this->_getBody());
    $user_id=$input->user_ext_id;
    $observation_name=$input->observation_name;
    $observation_date=$input->observation_date;
    $sql="INSERT INTO `observation` (
    `user_ext_id`,
    `observation_name`,
    `observation_date`)
    VALUES (
    :user_ext_id,
    :observation_name,
    :observation_date)";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':user_ext_id',$user_id, \PDO::PARAM_INT);
      $stmt->bindParam(':observation_name',$observation_name, \PDO::PARAM_STR);
      $stmt->bindParam(':observation_date',$observation_date, \PDO::PARAM_STR);
      $stmt->execute();
      $newid = $db->lastInsertId();
      $db = null;
      echo json_encode('{"observation_id":'.$newid.',"user_ext_id":'.$user_id.',"observation_name":'.$observation_name.',"observation_date":'.$observation_date.'}');
    } catch(PDOException $e) {
      echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_ext_id":'.$user_id.',"observation_name":'.$observation_name.',"observation_date":'.$observation_date.'}}');
    }	
  }
  
  public function userAddObsDimEndpoint() {
    $input = json_decode($this->_getBody());
    $observation_id=$input->observation_id;
    $alerttype_id=$input->alerttype_id;
    $agritype_id=$input->agritype_id;
    $nuts2_id=$input->nuts2_id;
    $nuts3_id=$input->nuts3_id;
    $nuts5_id=$input->nuts5_id;
    $sql="INSERT INTO `observation_dim` (
    `observation_id`,
    `alerttype_id`,
    `agritype_id`,
    `nuts2_id`,
    `nuts3_id`, 
    `nuts5_id`)
    VALUES (
    :observation_id,
    :alerttype_id,
    :agritype_id,
    :nuts2_id,
    :nuts3_id,
    :nuts5_id)";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':observation_id',$observation_id, \PDO::PARAM_INT);
      $stmt->bindParam(':alerttype_id',$alerttype_id, \PDO::PARAM_INT);
      $stmt->bindParam(':agritype_id',$agritype_id, \PDO::PARAM_INT);
      $stmt->bindParam(':nuts2_id',$nuts2_id, \PDO::PARAM_INT);
      $stmt->bindParam(':nuts3_id',$nuts3_id, \PDO::PARAM_STR);
      $stmt->bindParam(':nuts5_id',$nuts5_id, \PDO::PARAM_STR);
      $stmt->execute();
      $db = null;
    } catch(PDOException $e) {
      echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"observation_id":'.$observation_id.',"agritype_id":'.$agritype_id.',"nuts2_id":'.$nuts2_id.',"nuts3_id":'.$nuts3_id.',"nuts5_id":'.$nuts5_id.'}}');
    }	
  }

  public function userAddObsVerifEndpoint() {
    $input = json_decode($this->_getBody());
    $user_id=$input->user_ext_id;
    $observation_dim_id=$input->observation_dim_id;
    $sql="INSERT INTO `observation_verification` (
    `observation_dim_id`,
    `user_ext_id`)
    VALUES (
    :observation_dim_id,
    :user_ext_id)";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':observation_dim_id',$observation_dim_id, \PDO::PARAM_INT);
      $stmt->bindParam(':user_ext_id',$user_id, \PDO::PARAM_INT);
      $stmt->execute();
      $db = null;
    } catch(PDOException $e) {
      echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_ext_id":'.$user_id.',"observation_name":'.$observation_name.',"observation_date":'.$observation_date.'}}');
    }	
  }
  
/*******************************
*-----------USERS_EXT----------*
*******************************/
 
  public function userAddEndpoint() {
    $input = json_decode($this->_getBody());
    foreach($input as $i){
      $user_id = $i->user_id;
      $email = $i->email;
      $sql="INSERT INTO `user_ext` (
      `user_ext_id`,
      `user_ext_email`)
      VALUES (
      :user_id,
      :email)";

      try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id',$user_id, \PDO::PARAM_INT);
        $stmt->bindParam(':email',$email, \PDO::PARAM_STR, 100);
        $stmt->execute();
        $db = null;
        echo json_encode('{"success":{"text":"User added succesfully"}}');
      } catch(PDOException $e) {
        echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_id":'.$user_id.',"email":'.$email.'}}');
      }
    }
  }

/*******************************
*-----------PREFS----------*
*******************************/  
  public function userCheckPrefsEndpoint($user_id) {
    $arr_prefs = array();
    $sql="SELECT `user_pref_list`.* 
      FROM `user_pref_list` 
      WHERE `user_ext_id` = :id";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id',$user_id, \PDO::PARAM_INT);
      $stmt->execute();
			$prefs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      $db = null;
  		echo json_encode($prefs);
    } catch(PDOException $e) {
      echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_id":'.$user_id.',"email":'.$email.'}}');
    }	
  }
  
  public function userGetPrefEndpoint($user_id, $pref_id) {
    $arr_prefs = array();
    $sql="SELECT `user_pref_list`.* 
      FROM `user_pref_list` 
      WHERE `user_pref_id` = :id";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id',$pref_id, \PDO::PARAM_INT);
      $stmt->execute();
			$prefs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      $db = null;
  		echo json_encode($prefs);
    } catch(PDOException $e) {
      echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_id":'.$user_id.',"pref_id":'.$pref_id.'}}');
    }	
  }

  public function userAddPrefsEndpoint() {
    $input = json_decode($this->_getBody());
    $user_id=$input->user_ext_id;
    $agritype_id=$input->agritype_id;
    $nuts2_id=$input->nuts2_id;
    $nuts3_id=$input->nuts3_id;
    $nuts5_id=$input->nuts5_id;
    $sql="INSERT INTO `user_pref` (
    `user_ext_id`,
    `agritype_id`,
    `nuts2_id`,
    `nuts3_id`, 
    `nuts5_id`)
    VALUES (
    :user_id,
    :agritype_id,
    :nuts2_id,
    :nuts3_id,
    :nuts5_id)";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':user_id',$user_id, \PDO::PARAM_INT);
      $stmt->bindParam(':agritype_id',$agritype_id, \PDO::PARAM_INT);
      $stmt->bindParam(':nuts2_id',$nuts2_id, \PDO::PARAM_INT);
      $stmt->bindParam(':nuts3_id',$nuts3_id, \PDO::PARAM_STR);
      $stmt->bindParam(':nuts5_id',$nuts5_id, \PDO::PARAM_STR);
      $stmt->execute();
      $db = null;
    } catch(PDOException $e) {
      echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_id":'.$user_id.',"agritype_id":'.$agritype_id.',"nuts2_id":'.$nuts2_id.',"nuts3_id":'.$nuts3_id.',"nuts5_id":'.$nuts5_id.'}}');
    }	
  }
  

  public function userUpdatePrefsEndpoint() {
    $input = json_decode($this->_getBody());
    foreach($input as $i){
      $user_pref_id=$i->user_pref_id;
      $agritype_id=$i->agritype_id;
      $nuts2_id=$i->nuts2_id;
      $nuts3_id=$i->nuts3_id;
      $nuts5_id=$i->nuts5_id;
      $sql="UPDATE `user_pref` SET
      `agritype_id` = :agritype_id,
      `nuts2_id` = :nuts2_id,
      `nuts3_id` = :nuts3_id,
      `nuts5_id` = :nuts5_id
      WHERE `user_pref_id` = :user_pref_id";
      try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_pref_id',$user_pref_id, \PDO::PARAM_INT);
        $stmt->bindParam(':agritype_id',$agritype_id, \PDO::PARAM_INT);
        $stmt->bindParam(':nuts2_id',$nuts2_id, \PDO::PARAM_INT);
        $stmt->bindParam(':nuts3_id',$nuts3_id, \PDO::PARAM_STR);
        $stmt->bindParam(':nuts5_id',$nuts5_id, \PDO::PARAM_STR);
        $stmt->execute();
        $db = null;
        $a_json=array();
        $a_json["user_pref_id"]=$user_pref_id;
        $a_json["agritype_id"]=$agritype_id;
        $a_json["nuts2_id"]=$nuts2_id;
        $a_json["nuts3_id"]=$nuts3_id;
        $a_json["nuts5_id"]=$nuts5_id;
        //$json=str_replace(array('[',']'),'',json_encode($a_json));
        //echo $json;
        echo json_encode($a_json);
      } catch(PDOException $e) {
        echo json_encode('{"error":{"text":'. $e->getMessage() .'},"data":{"user_pref_id":'.$user_pref_id.',"agritype_id":'.$agritype_id.',"nuts2_id":'.$nuts2_id.',"nuts3_id":'.$nuts3_id.',"nuts5_id":'.$nuts5_id.'}}');
      }	
    }
  }
  
/*******************************
*-----------AGRITYPES----------*
*******************************/
  public function agritypesEndpoint() {
		$sql="SELECT 
		`agritype`.*
		FROM 
		`agritype`";
		try {
			$db = getDB();
			$stmt = $db->query($sql);
			$agritypes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($agritypes);
	}
  public function alerttypesEndpoint() {
		$sql="SELECT 
		`alerttype`.*
		FROM 
		`alerttype`";
		try {
			$db = getDB();
			$stmt = $db->query($sql);
			$agritypes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($agritypes);
	}
  
/*******************************
*-----------NUTS2--------------*
*******************************/
	public function nuts2Endpoint() {
		$sql="SELECT 
		`nuts2`.*
		FROM 
		`nuts2`";
		try {
			$db = getDB();
			$stmt = $db->query($sql);
			$nuts2 = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($nuts2);
	}
  
/*******************************
*-----------NUTS3--------------*
*******************************/
	public function nuts3Endpoint($n2) {
		$sql="SELECT 
		`nuts3_id`,
    `nuts3_name`
		FROM 
		`nuts3` 
    WHERE `nuts2_id` = :id";
		try {
			$db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id',$n2, \PDO::PARAM_INT);
      $stmt->execute();
			$nuts3 = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($nuts3);
	}
  
/*******************************
*-----------NUTS5--------------*
*******************************/
	public function nuts5Endpoint($n3) {
		$sql="SELECT 
		`nuts5_id`,
    `nuts5_name`
		FROM 
		`nuts5` 
    WHERE `nuts3_id` = :id";
		try {
			$db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id',$n3, \PDO::PARAM_STR);
      $stmt->execute();
			$nuts5 = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch(\PDOException $e) {
			echo json_encode('{"error":{"text":'. $e->getMessage() .'}}');
		}
		echo json_encode($nuts5);
	}
  
  
  public function checkScope($scope){
    if ($this->tokenInfo){
      $scopes = explode(" ", $this->tokenInfo->scope);
      foreach ($scopes as $s){
        if ($s === $scope)
          return true;
      }
    }

    return false;
  }

  public function privateScopedEndpoint() {
    return array(
	  "status" => "ok",
	  "message" => "Hello from a private endpoint! You need to be authenticated and have a scope of read:messages to see this."
    );
  }
  
  private function _getBody(){
    $rawInput = @file_get_contents('php://input');
    if (!$rawInput) {
        $rawInput = '';
    }
    return $rawInput;
  }
  
}

