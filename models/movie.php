<?php 

class Movie
{
    private $conn;
    private $table = 'movies';

    public $id=-1;
    public $name;
    public $year=0;
    public $fsk=0;
    public $rating=0.0;
    public $duration=0;
    public $keyGenre1;
    public $keyGenre2;
    
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
        $this->year = $row['year'];
        $this->fsk = $row['fsk'];
        $this->rating = $row['rating'];
        $this->duration = $row['duration'];
        $this->keyGenre1 = $row['keyGenre1'];
        $this->keyGenre2 = $row['keyGenre2'];
    }

    public function GetSearchByTitle($title)
    {
        if(!isset($title))
            return null;
        
        $title = strtolower($title);
            
        $sql = "SELECT *
            FROM $this->table
            WHERE LOWER(name) LIKE '%$title%'
            ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();
        
        return $stmt;
    }
    
    public function GetFavorit($user)
    {
        if(!isset($user))
            return null;
            
            $sql = "SELECT *
            FROM $this->table as m
            INNER JOIN usermovies as us ON m.i=us.keyMovie";
            
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            
            return $stmt;
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
            year = :year,
            fsk = :fsk,
            rating = :rating,
            duration = :duration,
            keyGenre1 = :keyGenre1,
            keyGenre2 = :keyGenre2';

        // Vorbereiten
        $stmt = $this->conn->prepare($query);

        // Validierung
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->fsk = htmlspecialchars(strip_tags($this->fsk));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->keyGenre1 = htmlspecialchars(strip_tags($this->keyGenre1));
        $this->keyGenre2 = htmlspecialchars(strip_tags($this->keyGenre2));

        // Binden
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':fsk', $this->fsk);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':keyGenre1', $this->keyGenre1);
        $stmt->bindParam(':keyGenre2', $this->keyGenre2);
        
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
            year = :year,
            fsk = :fsk,
            rating = :rating,
            duration = :duration,
            keyGenre1 = :keyGenre1,
            keyGenre2 = :keyGenre2
        WHERE
            id = :id';
        
        // Vorbereiten
        $stmt = $this->conn->prepare($query);
        
        // Validierung
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->fsk = htmlspecialchars(strip_tags($this->fsk));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->keyGenre1 = htmlspecialchars(strip_tags($this->keyGenre1));
        $this->keyGenre2 = htmlspecialchars(strip_tags($this->keyGenre2));
        
        // Binden
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':fsk', $this->fsk);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':keyGenre1', $this->keyGenre1);
        $stmt->bindParam(':keyGenre2', $this->keyGenre2);
        
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