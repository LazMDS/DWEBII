class User {
    private $name;
    private $email;
    private $password;
    private $profilePicture;

    public function __construct($name, $email, $password, $profilePicture) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->profilePicture = $profilePicture;
    }

    //! Métodos Get e Set
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getProfilePicture() {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
    }

    //! Métodos Especificos
    public function register() {
        //* Terminar de implementar
    }

    public function login() {
        //* Terminar de implementar
    }

    public function recoverPassword() {
        //* Terminar de implementar
    }

    public function updateProfile($name, $email, $password, $profilePicture) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setProfilePicture($profilePicture);
    }
}