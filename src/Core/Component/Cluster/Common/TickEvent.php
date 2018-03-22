<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/3/22
 * Time: 上午10:50
 */

namespace EasySwoole\Core\Component\Cluster\Common;


use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Core\Component\Cluster\Communicate\CommandBean;
use EasySwoole\Core\Component\Cluster\Communicate\SysCommand;
use EasySwoole\Core\Component\Cluster\Config;
use EasySwoole\Core\Component\Container;
use EasySwoole\Core\Component\Rpc\Server\ServiceManager;

class TickEvent extends Container
{
    use Singleton;

    /*
     * must  return a command
     */
    function __construct(array $allowKeys = null)
    {
        parent::__construct($allowKeys);
        $this->set(SysCommand::NODE_BROADCAST,function (){
            $conf = Config::getInstance();
            $command = new CommandBean();
            $command->setCommand(SysCommand::NODE_BROADCAST);
            $command->setArgs($conf->toArray());
            return $command;
        });

        $this->set(SysCommand::RPC_NODE_BROADCAST,function (){
            $list = ServiceManager::getInstance()->getLocalServices();
            $command = new CommandBean();
            $command->setCommand(SysCommand::RPC_NODE_BROADCAST);
            $command->setArgs($list);
            return $command;
        });

        //gc命令不用广播 ，不返回command
        $this->set('gc',function (){
            //清理RPC
            ServiceManager::getInstance()->gc();
            //清理serverNode
        });
    }

}