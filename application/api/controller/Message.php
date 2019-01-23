<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */

namespace app\api\controller;

use app\api\model\Messages;
use app\api\model\Device;
use app\portal\model\MessagesModel;
use function var_dump;

class Message extends AuthBase
{

    /*
     * 推送给某一个设备消息
     */
    public function pushTo()
    {

    }

    /*
     * 推送给某全部设备消息
     */
    public function pushAll()
    {

    }

    /*
     * 发布一条消息
     */
    public function send()
    {

    }

    /**
     * @desc 我的所有数据列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function messageList()
    {
        $uuid      = $this->request->get('user_id', session('userid'));
        $device_id = $this->request->get('device_id', false);
        $page      = $this->request->get('page', 1);
        $limit     = $this->request->get('limit', 10);
        if ($uuid)
            $condition['uuid'] = $uuid;
        if ($device_id) {
            $condition['device_id'] = $device_id;
        }
        array_push($condition, ['status', '<>', 100]);

        $offset       = ($page - 1) * $limit;
        $messageCount = Messages::where($condition)
            ->limit($offset, $limit)->select()
            ->count();
        $messages     = Messages::Where($condition)
            ->limit($offset, $limit)
            ->select()->toArray();
        return $this->json(1, "ok", [
            'total' => $messageCount,
            'rows'  => $messages
        ]);
    }

    /**
     * @desc 消息详情
     */
    public function msgDetail()
    {
        $msgId = $this->request->get("id", 0);
        if ($msgId) {
            $condition = ['id' => $msgId];
        };
        $message = Messages::Where($condition)
            ->select()->toArray();
        $result  = [
            'code' => 1,
            'msg'  => 'ok',
            'data' => $message
        ];
        return $this->json($result);
    }

    /**
     * @desc 移除消息，软删除
     */
    public function messageRemove()
    {
        $msgId = $this->request->get("message_id", 0);
        if ($msgId) {
            $condition = ['id' => $msgId];
        };
        $message         = MessagesModel::get(['id' => $msgId]);
        $message->status = 100;
        $f               = $message->save();
        if ($f) {
            $this->json(1, '删除成功');
        } else {
            $this->json(-1, '删除失败');
        }
    }

    public function messageType()
    {
        $types = [
            'utf8'     => 'UTF8字符串',
            'utf8json' => 'UTF8 JSON字符串',
            'utf8bson' => 'UTF8 BSON字符串',
            'utf8xml'  => 'UTF8 XML字符串',
            'hex'      => 'HEX(16进制字符串)',
            'ascii'    => 'Ascii字符串',
            'base64'   => 'Base64字符串',
            'latin'    => 'Latin字符串',
        ];
        $this->json(1, "获取成功", $types);
    }
}