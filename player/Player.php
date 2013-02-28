<?php
/**
 * LudoDBModel for chess player objects
 */

class Player extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;

    public function setPassword($password)
    {
        if(!$this->isMd5($password))$password = md5($password);
        $this->setValue('password', $password);
    }

    private function isMd5($string){
        return preg_match("/^[0-9a-f]{32}$/i", $string);
    }

    public function hasAccessTo($role){
        return $this->getUserAccess() & $role ? true : false;
    }

    public function getFullName()
    {
        if ($this->getId()) {
            return $this->getValue('full_name');
        }
        return null;
    }

    public function getUserAccess(){
        return $this->getValue('user_access');
    }

    public function setUserAccess($access){
        $this->setValue('user_access', $access);
    }

    public function grantAccessTo($role){
        if(!$this->hasAccessTo($role)){
            $this->setUserAccess($this->getUserAccess() + $role);
        }
    }

    public function clearUserAccess(){
        $this->setUserAccess(0);
    }

    public function grantAdminAccess(){
        $this->setUserAccess(1+2+4+8+16+32+64+128+256+512+1024+2048+4096+8192);
    }

    public function isValid()
    {
        if(!$this->getValue('online_player'))return true;
        $username = $this->getUsername();
        if (!$username) return false;
        $sql = "select " . $this->parser->getIdField() . " from " . $this->parser->getTableName() . " where username='" . $this->getUsername() . "'";
        if ($this->getId()) $sql .= " and " . $this->parser->getIdField() . " <> '" . $this->getId() . "'";
        return $this->db->countRows($sql) === 0;
    }

    public function setUsername($username){
        $this->setValue('username', $username);
    }

    public function getUsername(){
        return $this->getValue('username');
    }

    public function setFullName($name){
        $this->setValue('full_name', $name);
    }


    public function games($category)
    {
        $obj = new PlayerGames($this->getId(), '0', $category);
        return $obj->getValues();
    }

    public function archive()
    {
        $obj = new PlayerGames($this->getId(), '1');
        return $obj->getValues();
    }

    public function setOnlinePlayer($online){
        $this->setValue('online_player', $online);
    }

    public function gravatar()
    {
        $size = 80;
        $default = "";
        if(!$this->getValue('email'))return "";
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->getValue('email') ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    }

    public function getPassword(){
        return $this->getValue('password');
    }

    public function seeks(){
        $seeks = new Seeks($this->getId());
        return $seeks->getValues();
    }

    public function getValidServices(){
        return array("gravatar", "seeks", "games", "archive", "register");
    }

    public function validateArguments($service, $arguments){
        switch($service){
            case 'read':
                return count($arguments) === 1;
            case "register":
                return count($arguments) < 2;
            default:
        }
        return count($arguments) === 1;
    }

    public function validateServiceData($service, $data){
        switch($service){
            case "register":
                if(!isset($data['username']) || !isset($data['email']) || !isset($data['password']) || !isset($data['repeat_password'])){
                    throw new LudoDBException("Missing user data");
                }
                if($this->hasRowWith(array("email" => $data["email"]))){
                    throw new LudoDBException("Invalid email address");
                }
                if($this->hasRowWith(array("username" => $data["username"]))){
                    throw new LudoDBException("Invalid user name");
                }
                if($data['password'] != $data['repeat_password']){
                    throw new LudoDBException("Password does not match");
                }
                break;
            case "games":
                if(!empty($data) || !is_numeric($data)){
                    throw new LudoDBException("Numeric category missing.");
                }

        }
        return true;
    }

    public function shouldCache($service){
        return false;
    }


    public function register($userDetails){
        $this->setValues($userDetails);
        $this->setDefaultValuesForNewPlayers();
        $this->commit();
        $rememberMe = isset($userDetails['rememberMe']) ? true : false;
        $session = new Session();
        $session->signIn(array("username" => $this->getUsername(),"password" => $this->getPassword(), "rememberMe" => $rememberMe));

        return array('token' => $session->getKey(), 'access' => $this->getUserAccess());
    }

    private function setDefaultValuesForNewPlayers(){
        $this->setOnlinePlayer(1);
        $this->setUserAccess(1);
    }

    public function save($data){
        $cp = CurrentPlayer::getInstance();
        if(!$cp->hasAccessTo(ChessRoles::EDIT_USERS) && $cp->getId() !== $this->getId()){
            throw new LudoDBUnauthorizedException("You are not allowed to edit this user");
        }
        if(!$cp->hasAccessTo(ChessRoles::EDIT_USERS)){
            if(isset($data['user_access']))unset($data['user_access']);
        }
        if (isset($values['password']) && !$values['password']) {
            unset($values['password']);
        }
        return parent::save($data);
    }

    public function getElo($category){
        $elo = new Elo($this->getId(), $category);
        return $elo->getElo();
    }
}
