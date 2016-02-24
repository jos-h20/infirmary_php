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

class  SpecialtyTest  extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
      Specialty::deleteAll();
      Doctor::deleteAll();
      Patient::deleteAll();

    }

    function test_getName()
    {
        $name = "Proctology";
        $test_Specialty = new Specialty($name);

        $result = $test_Specialty->getName();

        $this->assertEquals($name, $result);
    }
    function test_getId()
    {
        $name = "Proctology";
        $id = 1;
        $test_Specialty = new Specialty($name, $id);

        $result = $test_Specialty->getId();

        $this->assertEquals(true, is_numeric($result));
    }
    function test_save()
    {
        //Arrange
        $name = "Proctology";
        $id = 1;
        $test_Specialty = new Specialty($name, $id);
        $test_Specialty->save();

        //Act
        $result = Specialty::getAll();

        //Assert
        $this->assertEquals($test_Specialty, $result[0]);
    }
    function test_getAll()
    {
        //Arrange
        $name = "Proctology";
        $name2 = "Cardiology";
        $test_Specialty = new Specialty($name);
        $test_Specialty->save();
        $test_Specialty2 = new Specialty($name2);
        $test_Specialty2->save();
        //Act
        $result = Specialty::getAll();

        //Assert
        $this->assertEquals([$test_Specialty, $test_Specialty2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name = "Proctology";
        $name2 = "Cardiology";
        $test_Specialty = new Specialty($name);
        $test_Specialty->save();
        $test_Specialty2 = new Specialty($name2);
        $test_Specialty2->save();

        //Act
        Specialty::deleteAll();
        $result = Specialty::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name = "Proctology";
        $name2 = "Cardiology";
        $test_Specialty = new Specialty($name);
        $test_Specialty->save();
        $test_Specialty2 = new Specialty($name2);
        $test_Specialty2->save();


        //Act
        $result = Specialty::find($test_Specialty->getId());

        //Assert
        $this->assertEquals($test_Specialty, $result);
    }
    function testGetDoctors()
    {
        //Arrange
        $name = "Proctology";
        $id = null;
        $test_specialty = new Specialty($name, $id);
        $test_specialty->save();

        $test_specialty_id = $test_specialty->getId();

        $doctor_name = "DR Joe Blow";
        $test_doctor = new Doctor($doctor_name, $id, $test_specialty_id);
        $test_doctor->save();

        $doctor_name2 = "Dr Bottom";
        $test_doctor2 = new Doctor($doctor_name2, $id, $test_specialty_id);
        $test_doctor2->save();

        //Act
        $result = $test_specialty->getDoctors();
        
        //Assert
        $this->assertEquals([$test_doctor, $test_doctor2], $result);
    }
}
 ?>
