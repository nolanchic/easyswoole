<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/2/6
 * Time: 下午4:18
 */

namespace EasySwoole\Core\Component\Cluster\Common;


use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Core\Component\Cluster\Communicate\SysCommand;
use EasySwoole\Core\Component\Event;
use EasySwoole\Core\Component\Cluster\Communicate\CommandBean;
use EasySwoole\Core\Component\Rpc\Server\ServiceNode;

class CommandRegister extends Event
{
    use Singleton;

    function __construct(array $allowKeys = null)
    {
        parent::__construct($allowKeys);
        $this->set(SysCommand::NODE_BROADCAST,function (CommandBean $commandBean,$udpAddress){
//            var_dump($commandBean->toArray(),$udpAddress);
        });
        $this->set(SysCommand::RPC_NODE_BROADCAST,function (CommandBean $commandBean,$udpAddress){
            $services = $commandBean->getArgs();
            if(is_array($services)){
                foreach ($services as $item){
                    $node = new ServiceNode($item);
                    var_dump($node->toArray());
                }
            }
        });
    }

}