<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 06.06.13
 * Time: 21:53
 */
class PasswordLookup extends LudoDBModel implements LudoDBService
{

    protected $config = array(
        'table' => 'chess_password_lookup',
        "sql" => "select * from chess_password_lookup where unique_key=?",
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'unique_key' => 'varchar(255)',
            'player' => array(
                'db' => 'int',
                'references' => 'chess_player(id) on delete cascade'
            ),
            'created' => 'timestamp'
        )
    );

    public function getValidServices(){
        return array("save","read");
    }

    public function validateArguments($service, $arguments){
        return empty($arguments);
    }

    public function validateServiceData($service, $data){
        if(empty($data) || !is_array($data) || !isset($data['email'])) return false;
        $player = new PlayerByEmail($data['email']);
        $id = $player->getId();
        return !empty($id);
    }

    public function save($data){
        $player = new PlayerByEmail($data['email']);
        if(!$this->exists())$this->createTable();

        $this->setValue("unique_key",$this->getUniqueKey());
        $this->setValue("player", $player->getId());
        $this->commit();

        $this->sendEmail($data['email']);
    }

    private function getUniqueKey(){
        $chars = 'abcdefghijklmnopqrstuvxyz1234567890';
        $ret = "";
        $len = strlen($chars);
        for($i=0;$i<50;$i++){
            $ret .= substr($chars, rand(0,$len-1), 1 );
        }
        return $ret;
    }

    private function sendEmail($email){
        return;
        mail($email, ChessRegistry::getPasswordResetSubject(), $this->getMessageBody());
    }

    private function getMessageBody(){
        return ChessRegistry::getPasswordResetBody().$this->getValue("unique_key");
    }
}
