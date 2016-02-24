<?php
class Patient
{
    private $name;
    private $doctor_id;
    private $id;
    private $birthday;

    function __construct($name, $id = null, $doctor_id, $birthday)
    {
        $this->name = $name;
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->birthday = $birthday;
    }

    function setName($new_name)
    {
        $this->name = (string) $new_name;
    }

    function getName()
    {
        return $this->name;
    }

    function getId()
    {
        return $this->id;
    }

    function getDoctorId()
    {
        return $this->doctor_id;
    }

    function getBirthday()
    {
        return $this->birthday;
    }

    function setBirthday($new_birthday)
    {
        $this->birthday = $new_birthday;
    }


    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO patients (name, doctor_id, birthday) VALUES ('{$this->getName()}', {$this->getDoctorId()}, '{$this->getBirthday()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_patients = $GLOBALS['DB']->query("SELECT * FROM patients ORDER BY birthday;");
        $patients = array();
        foreach($returned_patients as $patient) {
            $name = $patient['name'];
            $id = $patient['id'];
            $doctor_id = $patient['doctor_id'];
            $birthday = $patient['birthday'];
            $new_patient = new Patient($name, $id, $doctor_id, $birthday);
            array_push($patients, $new_patient);
        }
        return $patients;
    }

    static function deleteAll()
    {
       $GLOBALS['DB']->exec("DELETE FROM patients;");
    }

    static function find($search_id)
    {
        $found_patient = null;
        $patients = Patient::getAll();
        foreach ($patients as $patient){
            $patient_id = $patient->getID();
            if ($patient_id == $search_id){
                $found_patient = $patient;
            }
        }
        return $found_patient;
    }

}

?>
