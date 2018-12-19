<?php 

class User
{
    private $conn;
    private $table = 'user';

    public $id=-1;
    public $name;
	public $lastname;
	public $email;

	public function __construct($db)
	{
	    $this->conn = $db;
	}
	
	public function GetAll()
	{
	    $sql = "SELECT *
            FROM $this->table
            ORDER BY name ASC";
	    
	    $stmt = $this->conn->prepare($sql);
	    
	    $stmt->execute();  
	    
	    // Daten zählen
	    $count =$stmt->rowCount();
	    
	    // Daten vorhanden?
	    if($count > 0)
	    {
	        $dataArr = array();
	        
	        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        {
	            extract($row);
	            $item = array(
	                'id' => $id,
	                'name' => utf8_encode($name),
	                'lastname' => utf8_encode($lastname),
	                'email' => utf8_encode($email)
	            );
	            
	            // an Array hängen
	            array_push($dataArr, $item);
	        }
	        
	        // JSON Format
	        return $dataArr;
	    }
	    else
	    {
	        // Keine Daten!
	        return 'Keine Daten gefunden';
	    }
	}
	
	public function GetActiveUser()
	{	    
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else{
	        $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    
	    $sql = "SELECT u.* 
                FROM user AS u 
                INNER JOIN activuser AS a ON u.id = a.keyUser
                WHERE a.ip = :ip
                ORDER BY a.timestamp DESC 
                LIMIT 1";
	    	    
	    $stmt = $this->conn->prepare($sql);
	    
	    $ip = htmlspecialchars(strip_tags($ip));
	    
	    // Parameter einbinden
	    $stmt->bindParam(':ip', $ip);
	    	    
	    // SQL ausführen
	    if($stmt->execute())
	    {
    	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    	    
    	    $this->id = $row['id'];
    	    $this->name = $row['name'];
    	    $this->lastname = $row['lastname'];
    	    $this->email = $row['email'];
	    }
	}
	
	public function SetActiveUser()
	{
	    $sql = "INSERT INTO activuser
                SET
                    keyUser = :keyUser,
                    ip = :ip,
                    timestamp = :timestamp";
	    
	    $stmt = $this->conn->prepare($sql);
	    
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else{
	        $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    
	    // Parameter einbinden
	    $stmt->bindParam(':keyUser', $this->id);
	    $stmt->bindParam(':ip', $ip);
	    $stmt->bindParam(':timestamp', time());
	    
	    // SQL ausführen
	    $stmt->execute();
	}
}
?>