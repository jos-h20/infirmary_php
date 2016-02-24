<?php
class Specialty
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }
    function getName()
    {
        return $this->name;
    }
    function getId()
    {
        return $this->id;
    }
    function setName($new_name)
    {
        $this->name =$new_name;
    }
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO specialty (name) VALUES ('{$this->getName()}')");
        $this->id= $GLOBALS['DB']->lastInsertId();
    }
    static function getAll()
    {
        $returned_specialties = $GLOBALS['DB']->query("SELECT * FROM specialty;");
        $specialties = array();
        foreach($returned_specialties as $specialty) {
            $name = $specialty['name'];
            $id = $specialty['id'];
            $new_specialty = new Specialty($name, $id);
            array_push($specialties, $new_specialty);
        }
        return $specialties;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM specialty;");
    }

    static function find($search_id)
    {
        $found_specialty = null;
        $specialties = Specialty::getAll();
        foreach($specialties as $specialty)
        {
            $specialty_id = $specialty->getId();
            if ($specialty_id == $search_id)
            { $found_specialty = $specialty;
            }
        }
        return $found_specialty;
    }
    function getDoctors()
    {
        $doctors = array();
        $returned_doctors = $GLOBALS['DB']->query("SELECT * FROM doctor WHERE specialty_id = {$this->getId()}");
        foreach($returned_doctors as $doctor) {
            $doctor_name = $doctor['name'];
            $id = $doctor['id'];
            $specialty_id = $doctor['specialty_id'];
            $new_doctor = new Doctor($doctor_name, $id, $specialty_id);
            array_push($doctors, $new_doctor);
        }

        return $doctors;
    }

}

?>
