<?php 

class Genre
{
    private $conn;
    private $table = 'genre';

    public $id=-1;
    public $name;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
        
    public function GetSingle()
    { 
        $sql = "SELECT * 
            FROM $this->table 
            WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        // Parameter einbinden
        $stmt->bindParam(1, $this->id);

        // SQL ausführen
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Props
        $this->id = $row['id'];
        $this->name = $row['name'];
    }

    public function GetAll()
    {
        $sql = "SELECT * 
            FROM $this->table 
            ORDER BY name ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt;
    }

    public function Create()
    {
        $query = 'INSERT INTO ' .$this->table. '
        SET
            name = :name,
            year = :year';

        // Vorbereiten
        $stmt = $this->conn->prepare($query);

        // Validierung
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Binden
        $stmt->bindParam(':name', $this->name);

        // Ausführen
        if($stmt->execute())
        {
            // Erfolg
            return true;
        }
        else
        {
            // Fehler
            return false;
        }
    }

    public function Update()
    {
        $query = 'UPDATE ' .$this->table. '
        SET
            name = :name,
            year = :year
        WHERE
            id = :id';
        
        // Vorbereiten
        $stmt = $this->conn->prepare($query);
        
        // Validierung
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        
        // Binden
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        
        // Ausführen
        if($stmt->execute())
        {
            // Erfolg
            return true;
        }
        else
        {
            // Fehler
            return false;
        }
    }

    public function Delete()
    {
        $query = 'DELETE FROM ' .$this->table. ' WHERE id=:id';
        
        // Vorbereiten
        $stmt = $this->conn->prepare($query);
        
        // Validierung
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Binden
        $stmt->bindParam(':id', $this->id);
        
        // Ausführen
        if($stmt->execute())
        {
            // Erfolg
            return true;
        }
        else
        {
            // Fehler
            printf("Error: %s. \n", $stmt->error);
            return false;
        }
    }

}

?>