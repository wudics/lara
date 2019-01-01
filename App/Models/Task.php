<?php

namespace App\Models;

/**
* Task model
*
* PHP version 5.6
*/
class Task extends \Core\Model
{
    public static $rtn = null;

    public static function getFresh()
    {
        self::$rtn = null;

        $medoo = parent::getDbHelper();

        // 通过transaction处理，确保数据库锁定，使其他客户端无法访问查询
        $medoo->action(function($medoo)
        {
            $task = $medoo->get("task", [
                "id",
                "channel",
                "mark_sell",
                "money",
                "createtime"
            ], [
                "ORDER" => ["id" => "ASC"],
                "LIMIT" => 1
            ]);

            if (empty($task)) {
                return false;
            }

            $createtime = strtotime($task["createtime"]);
            if ((time() - $createtime) < 120) {
                self::$rtn = $task;
            }

            $medoo->delete("task", [
                "id" => $task["id"]
            ]);
        });

        return self::$rtn;
    }

    public static function getAll()
    {
        $medoo = parent::getDbHelper();
        $tasks = $medoo->select("task", "*");
        return $tasks;
    }

    public static function newTask($money, $mark_sell, $channel='wechat')
    {
        $medoo = parent::getDbHelper();

        $current = time();
        $createtime = date('Y-m-d H:i:s', $current);

        $pdoStmt = $medoo->insert("task", [
            "channel" => $channel,
            "mark_sell" => $mark_sell,
            "money" => $money,
            "createtime" => $createtime
        ]);
        
        if ($pdoStmt->rowCount() == 0) {
            return null;
        }

        return [
            "id" => $medoo->id(),
            "channel" => $channel,
            "mark_sell" => $mark_sell,
            "money" => $money,
            "createtime" => $createtime
        ];
    }

    public static function newPayment($money, $extra='hello', $channel='wechat')
    {
        $medoo = parent::getDbHelper();

        $current = time();
        $mark_sell = $current . mt_rand(100, 999);
        $createtime = date('Y-m-d H:i:s', $current);

        $pdoStmt = $medoo->insert("payment", [
            "extra" => $extra,
            "channel" => $channel,
            "mark_sell" => $mark_sell,
            "money" => $money,
            "createtime" => $createtime,
            "hasurl" => false,
            "haspay" => false,
            "paymoney" => 0
        ]);
        
        if ($pdoStmt->rowCount() == 0) {
            return null;
        }

        $payment_id = $medoo->id();

        // 添加任务列表，用于HOOK设备读取
        self::newTask($money, $mark_sell, $channel);

        return [
            "id" => $payment_id,
            "channel" => $channel,
            "mark_sell" => $mark_sell,
            "money" => $money,
            "createtime" => $createtime
        ];
    }

    public static function applyPayment($mark_sell, $dev, $url)
    {
        $medoo = parent::getDbHelper();
        $current = time();

        $pdoStmt = $medoo->update("payment", [
            "url" => $url,
            "device" => $dev,
            "applytime" => date('Y-m-d H:i:s', $current),
            "hasurl" => true
        ], [
            "mark_sell" => $mark_sell
        ]);

        if ($pdoStmt->rowCount() == 0) {
            return null;
        }

        return [
            "url" => $url,
            "device" => $dev,
            "mark_sell" => $mark_sell
        ];
    }

    public static function doPayment($mark_sell, $mark_buy, $money, $device, $channel_id)
    {
        $medoo = parent::getDbHelper();
        $current = time();

        $data = $medoo->get("payment", [
            "id",
            "extra",
            "channel",
            "mark_sell",
            "money",
            "createtime",
            "url",
            "hasurl",
            "device",
            "applytime",
            "haspay",
            "paytime",
            "channel_id",
            "mark_buy",
            "paymoney"
        ], [
            "mark_sell" => $mark_sell
        ]);

        if (empty($data)) {
            return false;
        }

        if ($device != $data["device"]) {
            return false;
        }

        $haspay = false;
        if ($money >= $data["money"]) {
            $haspay = true;
        }

        $pdoStmt = $medoo->update("payment", [
            "haspay" => $haspay,
            "paytime" => date('Y-m-d H:i:s', $current),
            "channel_id" => $channel_id,
            "mark_buy" => $mark_buy,
            "paymoney" => $money
        ], [
            "id" => $data["id"]
        ]);

        if ($pdoStmt->rowCount() == 0) {
            return false;
        }

        return true;
    }

    public static function getPaymentByMarkSell($mark_sell)
    {
        $medoo = parent::getDbHelper();

        $data = $medoo->get("payment", [
            "id",
            "extra",
            "channel",
            "mark_sell",
            "money",
            "createtime",
            "url",
            "hasurl",
            "device",
            "applytime",
            "haspay",
            "paytime",
            "channel_id",
            "mark_buy",
            "paymoney"
        ], [
            "mark_sell" => $mark_sell
        ]);

        if (empty($data)) {
            return null;
        }

        return $data;
    }

    public static function log($msg) {
        $medoo = parent::getDbHelper();

        $medoo->insert("log", [
            "msg" => $msg,
            "logtime" => date('Y-m-d H:i:s', time()),
        ]);
    }
}
