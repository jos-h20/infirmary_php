<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Doctor.php";
require_once "src/Patient.php";
require_once "src/Specialty.php";

$server = 'mysql:host=localhost;dbname=infirmary_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class  PatientTest  extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Patient::deleteAll();
        Specialty::deleteAll();
        Doctor::deleteAll();
    }

    function test_save()
    {
        //Arrange

        $doctor_name = "Dr Joe Blow";
        $id = null;
        $specialty_id = 1;
        $test_doctor= new Doctor($doctor_name, $id, $specialty_id);
        $test_doctor->save();

        $patient_name = "John Doe";
        $doctor_id = $test_doctor->getId();
        $birthday = '2016-02-23';
        $test_patient = new Patient($patient_name, $id, $doctor_id, $birthday);

        //Act
        $test_patient->save();

        //Assert
        $result = Patient::getAll();
        
        $this->assertEquals($test_patient, $result[0]);
    }
    function test_getAll()
    {
        //Arrange
        $doctor_name = "Dr Joe Blow";
        $id = null;
        $specialty_id = 1;
        $test_doctor_id = new Doctor($doctor_name, $id, $specialty_id);
        $test_doctor_id->save();

        $patient_name = "John Doe";
        $doctor_id = $test_doctor_id->getId();
        $birthday = '2016-02-23';
        $patient_name2 = "Jane Doe";
        $birthday2 = '2016-05-23';
        $test_patient = new Patient($patient_name, $id, $doctor_id, $birthday);
        $test_patient->save();
        $test_patient2 = new Patient($patient_name2, $id, $doctor_id, $birthday2);
        $test_patient2->save();

        //Act
        $result = Patient::getAll();

        //Assert
        $this->assertEquals([$test_patient, $test_patient2], $result);
    }
    function test_deleteAll()
    {
        //Arrange
        $doctor_name = "Dr Joe Blow";
        $id = null;
        $specialty_id = 1;
        $test_doctor = new Doctor($doctor_name, $id, $specialty_id);
        $test_doctor->save();

        $patient_name = "John Doe";
        $doctor_id = $test_doctor->getId();
        $birthday = '2016-02-23';
        $patient_name2 = "Jane Doe";
        $birthday2 = '2016-05-23';
        $test_patient = new Patient($patient_name, $id, $doctor_id, $birthday);
        $test_patient->save();
        $test_patient2 = new Patient($patient_name2, $id, $doctor_id, $birthday2);
        $test_patient2->save();

        //Act
        Patient::deleteAll();

        //Assert
        $result = Patient::getAll();
        $this->assertEquals([], $result);
    }

    function test_getId()
    {
        //Arrange

        $doctor_name = "Dr Joe Blow";
        $id = null;
        $specialty_id = 1;
        $test_doctor = new Doctor($doctor_name, $id, $specialty_id);
        $test_doctor->save();

        $patient_name = "John Doe";
        $doctor_id = $test_doctor->getId();
        $birthday = '2016-05-23';
        $test_patient = new Patient($patient_name, $id, $doctor_id, $birthday);
        $test_patient->save();

        //Act
        $result = $test_patient->getId();

        //Assert
        $this->assertEquals(true, is_numeric($result));
    }

    function test_find()
    {
        //Arrange
        $doctor_name = "Dr Joe Blow";
        $id = null;
        $specialty_id = 1;
        $test_doctor = new Doctor($doctor_name, $id, $specialty_id);
        $test_doctor->save();

        $patient_name = "John Doe";
        $doctor_id = $test_doctor->getId();
        $birthday = '2016-02-23';
        $patient_name2 = "Jane Doe";
        $birthday2 = '2016-05-23';
        $test_patient = new Patient($patient_name, $id, $doctor_id, $birthday);
        $test_patient->save();
        $test_patient2 = new Patient($patient_name2, $id, $doctor_id, $birthday2);
        $test_patient2->save();

        //Act

        $result = Patient::find($test_patient->getId());

        //Assert
        $this->assertEquals($test_patient, $result);
    }

}
 ?>
