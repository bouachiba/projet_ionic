<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Author
 *@ORM\Table(name="authors")
 * @ORM\Entity
 * @author moustakil
 */
class Author {
    /**
     *@ORM\Column(name="email",type="string",length=80,unique=true)
     * @var string 
     */
    private $email;
    /**
     *@ORM\Column(name="name",type="string",length=80)
     * @var string 
     */
    private $name;
    /**
     *@ORM\Column(name="first_name",type="string",length=50,nullable=true)
     * @var string 
     */
    private $firstName;
    /**
     *@ORM\Column(name="password",type="string",length=41)
     * @var string
     */
    
    private $password;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
public function getEmail() {
return $this->email;
}

public function getName() {
return $this->name;
}

public function getFirstName() {
return $this->firstName;
}

public function getPassword() {
return $this->password;
}

public function setEmail($email) {
$this->email = $email;
return $this;
}

public function setName($name) {
$this->name = $name;
return $this;
}

public function setFirstName($firstName) {
$this->firstName = $firstName;
return $this;
}

public function setPassword($password) {
$this->password = $password;
return $this;
}
public function getId() {
    return $this->id;
}

public function setId($id) {
    $this->id = $id;
    return $this;
}

public function  getFullName(){
    if($this->firstName==null){
        $fullName=strtoupper($this->$name);
    }else{
        $fullName=  $this->firstName.''.strtoupper($this->name);
        
    }
    return $fullName;
}
  //  $fullName=implode(' ',array_filter([$this->firstName,strtouper($this->name)]));
}

