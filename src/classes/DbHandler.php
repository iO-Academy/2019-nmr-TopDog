<?php
echo "catty";
$db = new PDO('mysql:host=127.0.0.1; dbname=top_dog', 'root');

$breed_name = 'hound';
$sub_breed = 'rich';
$url_image = 'www.google.co.uk/robothouseeeee';
$breed_id = 4;



/**
 * Class DbHandler handles inputting breeds into db, inserting images into the db based on the breed, and retrieving the breed name, sub breed
 * and id when required.
 */
class DbHandler
{
    /**
     * @var
     */
    private $dbConnection;

    /**
     * DbHandler constructor.
     *
     * @param $db PDO connection to the database
     */
    public function __construct($db) {
        $this->dbConnection = $db;
    }

    /**
     * inserts a the breed and sub breed into the database
     *
     * @param $db PDO connection to the database
     * @param $breed_name string name of dog breed category
     * @param $sub_breed string name of sub dog breed category if available
     *
     * @return boolean dependent on if insertion is successful
     */
    public function insertBreed ($db, string $breed_name, string $sub_breed) :bool{
        $query = $db->prepare("INSERT INTO `breed_table` (`breed_name`, `sub_breed`) VALUES (:breed_name,:sub_breed)");
        $query->bindParam(':breed_name', $breed_name);
        $query->bindParam(':sub_breed', $sub_breed);
        return $query->execute();
    }

    /**
     * inserts urls and breed-ids into the database base
     *
     * @param $db PDO connection to the database
     * @param $breed_id string id of breed type
     * @param $url_image string url to image
     *
     * @return boolean dependent on if insertion is successful
     */
    public function insertImages ($db, string $breed_id, string $url_image) :bool{
        $query = $db->prepare("INSERT INTO `image_table` (`breed_id`, `url_image`) VALUES (:breed_id,:url_image)");
        $query->bindParam(':breed_id', $breed_id);
        $query->bindParam(':url_image', $url_image);
        return $query->execute();
    }

    /**
     * retrieves the id, breed names and sub breeds from the breeds table
     *
     * @param $db PDO connection to the database
     *
     * @return array containing the the id, breed_name and sub_breed
     */
    public function getBreed ($db) :array{
        $query= $db->prepare("SELECT `id`, `breed_name`, `sub_breed` FROM `breed_table`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

$test = new DbHandler($db);
var_dump($test->insertBreed($db, $breed_name, $sub_breed));
$thing = $test->getBreed($db);
$test->insertImages($db, $breed_id, $url_image);
var_dump($thing);
