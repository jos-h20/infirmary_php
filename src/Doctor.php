<?php
class  Doctor
{
    private $doctor_name;
    private $specialty_id;
    private $id;


    function __construct($doctor_name, $id = null, $specialty_id)
    {
        $this->doctor_name = $doctor_name;
        $this->id = $id;
        $this->specialty_id = $specialty_id;

    }

    function setDoctorName($new_doctor_name)
    {
        $this->doctor_name = (string) $new_doctor_name;
    }

    function getDoctorName()
    {
        return $this->doctor_name;
    }

    function getId()
    {
        return $this->id;
    }

    function getSpecialtyId()
    {
        return $this->specialty_id;
    }

    function setSpecialtyId($new_specialty_id)
    {
        $this->specialty_id = $new_specialty_id;
    }



    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO doctor (name, specialty_id) VALUES ('{$this->getDoctorName()}', {$this->getSpecialtyId()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_doctors = $GLOBALS['DB']->query("SELECT * FROM doctor);");
        $doctors = array();
    
        foreach($returned_doctors as $doctor) {
            $doctor_name = $doctor['name'];
            $id = $doctor['id'];
            $specialty_id = $doctor['specialty_id'];
            $new_doctor = new Doctor($doctor_name, $id, $specialty_id);
            array_push($doctors, $new_doctor);
        }
        return $doctors;
    }

    static function deleteAll()
    {
       $GLOBALS['DB']->exec("DELETE FROM doctor;");
    }

    static function find($search_id)
    {
        $found_doctor = null;
        $doctors = Doctor::getAll();
        foreach ($doctors as $doctor){
            $doctor_id = $doctor->getId();
            if ($doctor_id == $search_id){
                $found_doctor = $doctor;
            }
        }
        return $found_doctor;
    }

    function getPatients()
    {
        $patients = Array();
        $returned_patients = $GLOBALS['DB']->query("SELECT * FROM patients WHERE doctor_id = {$this->getId()} ");
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

}



?>
