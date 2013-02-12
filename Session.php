<?php
/**
 * LudoDBModel for Sessions
 * User: borrow
 * Date: 19.12.12
 */
class Session extends LudoDBModel implements LudoDBService
{
    protected $config = array(
        'sql' => 'select * from chess_session where session_key=? and logged_out IS NULL',
        'table' => 'chess_session',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'session_key' => array(
                'db' => 'varchar(512)',
                'access' => 'rw'
            ),
            'user_id' => array(
                'db' => 'int',
                'access' => 'rw',
                'references' => 'chess_player(id) on delete cascade'
            ),
            'created' => array(
                'db' => 'timestamp',
                'access' => 'rw'
            ),
            'last_action' => array(
                'db' => 'datetime',
                'access' => 'rw'
            ),
            'logged_out' => array(
                'db' => 'char(1)',
                'access' => 'rw'
            )
        ),
        'indexes' => array('session_key', 'user_id')
    );

    public function __construct($key = null)
    {
        parent::__construct($key);
    }

    private function getUserId()
    {
        return $this->getValue('user_id');
    }

    private function expired()
    {
        return $this->getValue('logged_out') ? true : false;
    }

    protected function beforeInsert()
    {
        $this->setValue('session_key', 'U_' . md5(uniqid()));
    }

    public function setUserId($id)
    {
        $this->setValue('user_id', $id);
    }

    public function getKey()
    {
        return $this->getValue('session_key');
    }

    public function getValidServices()
    {
        return array("authenticate", "signin");
    }

    public function validateArguments($service, $arguments)
    {
        return count($arguments) === 0;
    }

    public function cacheEnabled()
    {
        return false;
    }

    public function signIn(array $userDetails)
    {
        $pl = new PlayerByUsernamePassword($userDetails['username'], $userDetails['password']);
        if ($pl->getId()) {
            $session = new Session();
            $session->setUserId($pl->getId());
            $session->commit();
            $this->setCookie($session);
            return $session;
        }
        return null;
    }

    private function setCookie(Session $session)
    {
        setcookie(ChessRegistry::getCookieName(), $session->getKey(), time() + $this->daysToSeconds(365));
    }

    private function daysToSeconds($days)
    {
        return $days * 24 * 60 * 60;
    }

    public function authenticate($session)
    {
        $session = new Session($session);
        return $session->getId() ? $session : null;
    }

    /**
     * @var Player
     */
    private $user;
    private $userLoaded;

    /**
     * @return null|Player
     */
    public function getUser()
    {
        if (!isset($this->userLoaded)) {
            $this->userLoaded = true;
            $cookie = $this->getCookieValue();
            if (isset($cookie)) {
                $session = new Session($cookie);
                if (!$session->expired()) {
                    $user = new Player($session->getUserId());
                    $this->user = $user->getId() ? $user : null;
                }
            }
        }
        return $this->user;
    }

    private function getCookieValue()
    {
        return isset($_COOKIE[ChessRegistry::getCookieName()]) ? $_COOKIE[ChessRegistry::getCookieName()] : null;
    }

    public function validateServiceData($service, $data)
    {
        return true;
    }

}
