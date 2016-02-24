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

class  DoctorTest  extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Doctor::deleteAll();
        Patient::deleteAll();
        Specialty::deleteAll();
    }
    function test_getName()
    {
        $name = "Joe Blow";
        $specialty_id = 1;
        $id = null;
        $test_Doctor = new Doctor($name, $id, $specialty_id);
    }

    function test_save()
    {
        //Arrange
        $name = "DR Bob";
        $id = null;
        $specialty_id = null;
        $test_Doctor = new Doctor($name, $id, $specialty_id);
        $test_Doctor->save();

        //Act
        $result = Doctor::getAll();

        //Assert
        $this->assertEquals($test_Doctor, $result[0]);
    }
    function test_getAll()
    {
        //Arrange
        $doctor_name = "dr joe";
        $doctor_name2 = "dr tim";
        $id= null;
        $specialty_id = 1;
        $test_Doctor = new Doctor($doctor_name, $id, $specialty_id);
        $test_Doctor->save();
        $test_Doctor2 = new Doctor($doctor_name2, $id, $specialty_id);
        $test_Doctor2->save();

        //Act
        $result = Doctor::getAll();

        //Assert
        $this->assertEquals([$test_Doctor, $test_Doctor2], $result);
    }
    function test_find()
    {
        //Arrange
        $doctor_name = "DR Jo";
        $test_specialty_id = 1;
        $test_specialty_id2 = 2;
        $id = null;
        $doctor_name2 = "DR FRank";
        $test_Doctor = new Doctor($doctor_name, $id, $test_specialty_id);
        $test_Doctor->save();
        $test_Doctor2 = new Doctor($doctor_name2, $id, $test_specialty_id2);
        $test_Doctor2->save();

        //Act
        $result = Doctor::find($test_Doctor->getId());

        //Assert
        $this->assertEquals($test_Doctor, $result);
    }

    function testGetPatients()
    {
        //Arrange
        $doctor_name = "DR Joe Blow";
        $id = null;
        $specialty_id = 1;
        $test_doctor = new Doctor($doctor_name, $id, $specialty_id);
        $test_doctor->save();

        $test_doctor_id = $test_doctor->getId();

        $patient_name = "Buck";
        $birthday = '2016-02-24';
        $test_patient = new Patient($patient_name, $id, $test_doctor_id, $birthday);
        $test_patient->save();

        $patient_name2 = "Joan";
        $birthday2 = '2016-02-25';
        $test_patient2 = new Patient($patient_name2, $id, $test_doctor_id, $birthday2);
        $test_patient2->save();

        //Act
        $result = $test_doctor->getPatients();

        //Assert
        $this->assertEquals([$test_patient, $test_patient2], $result);
    }
}
 ?>
